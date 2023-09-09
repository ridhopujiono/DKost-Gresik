<?php

namespace App\Http\Livewire;

use App\Models\Location;
use Exception;
use Livewire\Component;

class LocationTable extends Component
{
    public $data;
    public $sub_title;
    public $no = 1;

    public function render()
    {
        return view('livewire.location-table');
    }
    public function delete($locationId)
    {
        try {
            Location::find($locationId)->delete();
            $this->emit('needRefresh');
            session()->flash('success', 'Berhasil menghapus item');
        } catch (Exception $e) {
            session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
        }
    }
}
