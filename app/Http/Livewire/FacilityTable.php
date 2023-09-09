<?php

namespace App\Http\Livewire;

use App\Models\Facility;
use Livewire\Component;

class FacilityTable extends Component
{
    public $data;
    public $sub_title;
    public $no = 1;

    public function render()
    {
        return view('livewire.facility-table');
    }

    public function delete($facilityId)
    {
        try {
            Facility::find($facilityId)->delete();
            $this->emit('needRefresh');
            session()->flash('success', 'Berhasil menghapus item');
        } catch (Exception $e) {
            session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
        }
    }
}
