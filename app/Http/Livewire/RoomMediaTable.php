<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RoomMediaTable extends Component
{
    public $data;
    public $sub_title;
    public $no = 1;

    public function render()
    {
        return view('livewire.room-media-table');
    }
}
