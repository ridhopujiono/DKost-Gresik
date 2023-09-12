<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Livewire\Component;

class PaymentForm extends Component
{
    public $paymentId;
    public $sub_title;
    public $verification_status;
    public $editMode = false; // Menentukan apakah dalam mode "edit"
    public $showMode = false; // Menentukan apakah dalam mode "edit"


    public function mount()
    {
        if ($this->paymentId !== null) {
            // Jika memiliki ID, kita berada dalam mode "edit"
            $payment = Payment::find($this->paymentId);
            if ($payment) {
                $this->verification_status = $payment->verification_status;
                $this->editMode = true;
            }
        }
    }

    public function render()
    {
        return view('livewire.payment-form');
    }

    public function resetFields()
    {
        $this->verification_status = '';
    }
    public function save()
    {
        // Simulasikan pemrosesan yang memerlukan waktu
        sleep(2);
        $validate = $this->validate([
            'verification_status' => 'required|min:2|max:50'
        ]);
        if (!$this->editMode) {

            try {
                Payment::create($validate);
                session()->flash('success', 'Berhasil simpan data');
                $this->resetFields();
            } catch (Exception $e) {
                session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
            }
        } else {
            // Logika untuk mode "edit"
            try {
                $payment = Payment::find($this->paymentId);
                if ($payment) {
                    $payment->update($validate);
                    session()->flash('success', 'Berhasil mengubah data');
                }
            } catch (Exception $e) {
                session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
            }
        }
    }
}
