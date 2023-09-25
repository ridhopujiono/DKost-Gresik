<?php

namespace App\Http\Livewire;

use App\Mail\AcceptRoomReservation;
use App\Models\GuestWaitingList;
use App\Models\Resident;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class GuestWaitingListTable extends Component
{
    public $data;
    public $sub_title;
    public $no = 1;
    public $loadingContent = '';
    public $listeners = ['triggerUpdate' => 'update'];


    public function render()
    {
        return view('livewire.guest-waiting-list-table');
    }

    public function delete($guestId)
    {
        try {
            GuestWaitingList::find($guestId)->delete();
            $this->emit('needRefresh');
            session()->flash('success', 'Berhasil menghapus item');
        } catch (Exception $e) {
            session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
        }
    }
    public function insertResident($guest)
    {
        $resident = Resident::where('room_id', $guest->room_id)->where('user_id', $guest->user_id)->get();
        $result = [];
        if(count($resident) > 0){
            $result['status'] = 'error';
            $result['message'] = 'Penghuni yang sama sudah menempati kamar ini';
            return $result;
        }

        $insert_resident = Resident::create([
            'user_id' => $guest->user_id,
            'room_id' => $guest->room_id,
            'name' => $guest->guest_name,
            'address' => '-',
            'contact' => $guest->guest_contact,
            'emergency_info' => [
                "contact_name" => "",
                "contact_number" => ""
            ],
            'contract_start' => $guest->request_date,
            'contract_end' => Carbon::parse($guest->request_date),
            'payment_status' => 'belum_lunas',
            'late_status' => 1
        ]);

        //Ambil data kamar berdasarkan ID
        $room = Room::find($guest->room_id);

        // Kurangi stok kamar dengan jumlah tertentu
        $room->decrement('stock', 1);

        // Simpan perubahan
        $room->save();

        $result['status'] = 'success';
        return $result;
    }
    public function update($guestId, $isChecked)
    {
        try {

            $guest = GuestWaitingList::find($guestId);

            if ($isChecked) {
                $guest->status = 'diterima'; // Atur status menjadi 'diterima' jika checkbox diaktifkan

                $insert = $this->insertResident($guest);

                if($insert['status'] == 'error'){
                    return session()->flash('error', $insert['message']);
                }

                // Send Email
                Mail::to($guest->user->email)->send(new AcceptRoomReservation($guest->room->room_name));
                $this->dispatchBrowserEvent('hide-alert');

                session()->flash('success', 'Pengajuan diterima, Pemesan akan mendapatkan email pemberitahuan untuk pelunasan');
            } else {
                $guest->status = 'menunggu'; // Atur status menjadi 'menunggu' jika checkbox dinonaktifkan
            }


            $guest->save();

            $this->emit('needRefresh');
        } catch (Exception $e) {
            dd($e->getMessage());
            session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
        }
    }

}
