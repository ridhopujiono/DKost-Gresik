<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use App\Models\Resident;
use Livewire\Component;

class ResidentTable extends Component
{
    public $data;
    public $sub_title;
    public $no = 1;

    public function render()
    {
        return view('livewire.resident-table');
    }

    public function delete($residentId)
    {
        try {
            Payment::where('resident_id', $residentId)->delete();
            Resident::find($residentId)->delete();
            $this->emit('needRefresh');
            session()->flash('success', 'Berhasil menghapus item');
        } catch (Exception $e) {
            session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
        }
    }
}