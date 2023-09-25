<?php

namespace App\Http\Livewire;

use App\Models\GuestWaitingList;
use Livewire\Component;

class GuestWaitingListForm extends Component
{
    public $guestId;
    public $sub_title;
    public $guest_name;
    public $guest_contact;
    public $request_date;
    public $status;
    public $editMode = false; // Menentukan apakah dalam mode "edit"
    public $showMode = false; // Menentukan apakah dalam mode "edit"


    public function mount()
    {
        if ($this->guestId !== null) {
            // Jika memiliki ID, kita berada dalam mode "edit"
            $guest = GuestWaitingList::find($this->guestId);
            if ($guest) {
                $this->guest_name = $guest->guest_name;
                $this->guest_contact = $guest->guest_contact;
                $this->request_date = $guest->request_date;
                $this->status = $guest->status;
                $this->editMode = true;
            }
        }
    }

    public function render()
    {
        return view('livewire.guest-waiting-list-form');
    }

    public function resetFields()
    {
        $this->guest_name = '';
        $this->guest_contact = '';
        $this->request_date = '';
        $this->status = '';
    }
    public function save()
    {
        // Simulasikan pemrosesan yang memerlukan waktu
        sleep(2);
        $validate = $this->validate([
            'status' => 'required|min:2|max:50'
        ]);
        if (!$this->editMode) {

            try {
                GuestWaitingList::create($validate);
                session()->flash('success', 'Berhasil simpan data');
                $this->resetFields();
            } catch (Exception $e) {
                session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
            }
        } else {
            // Logika untuk mode "edit"
            try {
                $guest = GuestWaitingList::find($this->guestId);
                if ($guest) {
                    if ($validate['status'] == "diterima") {
                        $guest->update($validate);
                    }
                    session()->flash('success', 'Berhasil mengubah data');
                }
            } catch (Exception $e) {
                session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
            }
        }
    }
}
