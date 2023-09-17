<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\Room;
use App\Models\RoomFacility;
use Carbon\Carbon;
use Livewire\Component;

class RoomTable extends Component
{
    public $data;
    public $sub_title;
    public $no = 1;
    public $locations;
    public $locationSelected = null;
    public $rooms = [];
    public $roomSelected = null;

    public function mount()
    {
        $this->locations = Location::orderBy('location_name', 'asc')->get();
    }


    public function render()
    {
        return view('livewire.room-table');
    }

    public function updatedLocationSelected()
    {
        $this->rooms = Room::where('location_id', $this->locationSelected)->orderBy('room_name', 'asc')->get();
    }

    public function save()
    {
        $room = Room::find($this->roomSelected);
        $newRoom = $room->replicate();
        $newRoom->created_at = Carbon::now();
        $newRoom->save();

        sleep(2);
        return redirect('rooms' . '/' . $newRoom->id . '/edit')->with('success', 'Berhasil duplikasi kamar. Silahkan edit kamar baru anda');
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
