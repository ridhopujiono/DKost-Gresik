<?php

namespace App\Http\Livewire;

use App\Models\Room;
use App\Models\RoomFacility;
use Livewire\Component;

class RoomTable extends Component
{
    public $data;
    public $sub_title;
    public $no = 1;

    public function render()
    {
        return view('livewire.room-table');
    }

    public function delete($roomId)
    {
        try {
            RoomFacility::where('room_id', $roomId)->delete();
            Room::find($roomId)->delete();
            $this->emit('needRefresh');
            session()->flash('success', 'Berhasil menghapus item');
        } catch (Exception $e) {
            session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
        }
    }
}
