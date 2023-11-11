<?php

namespace App\Http\Livewire;

use App\Models\Resident;
use App\Models\Room;
use Exception;
use Livewire\Component;

class ResidentTable extends Component
{
    public $data;
    public $sub_title;
    public $no = 1;
    public $listeners = ['triggerCheckoutResident' => 'checkoutResident'];

    public function render()
    {
        return view('livewire.resident-table');
    }

    public function delete($residentId)
    {
        try {
            $resident = Resident::find($residentId);
            Room::find($resident->room_id)->update(['is_reserved' => false]);
            $resident->delete();

            $this->emit('needRefresh');
            session()->flash('success', 'Berhasil menghapus item');
        } catch (Exception $e) {
            session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
        }
    }

    public function checkoutResident($resident_id, $room_id, $hasCheckout)
    {
        try {
            Resident::find($resident_id)->update([
                'is_checkout' => $hasCheckout
            ]);
            if ($hasCheckout) {
                Room::find($room_id)->update(['is_reserved' => false]);
                session()->flash('success', 'Berhasil checkout penghuni');
            } else {
                Room::find($room_id)->update(['is_reserved' => true]);
                session()->flash('success', 'Berhasil uncheckout penghuni');
            }

            $this->emit('needRefresh');
        } catch (Exception $e) {
            session()->flash('error', 'Gagal checkout penghuni. Error' . $e->getMessage());
        }
    }
}
