<?php

namespace App\Http\Livewire;

use App\Models\Resident;
use Livewire\Component;

class PaymentTable extends Component
{
    public $data;
    public $sub_title;
    public $no = 1;

    public function render()
    {
        return view('livewire.payment-table');
    }

    public function delete($residentId)
    {
        try {
            Resident::find($residentId)->delete();
            $this->emit('needRefresh');
            session()->flash('success', 'Berhasil menghapus item');
        } catch (Exception $e) {
            session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
        }
    }
}
