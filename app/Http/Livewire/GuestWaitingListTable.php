<?php

namespace App\Http\Livewire;

use App\Models\GuestWaitingList;
use Livewire\Component;

class GuestWaitingListTable extends Component
{
    public $data;
    public $sub_title;
    public $no = 1;

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
}
