<?php

namespace App\Http\Livewire;

use App\Mail\PaymentAcceptedMail;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class PaymentForm extends Component
{
    public $paymentId;
    public $sub_title;
    public $verification_status;
    public $amount;
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
        $this->amount = '';
    }
    public function save()
    {
        // Simulasikan pemrosesan yang memerlukan waktu
        sleep(2);
        $validate = $this->validate([
            'verification_status' => 'required|min:2|max:50',
            'amount' => 'required',
        ]);
        $validate['amount'] = str_replace('.', '', $validate['amount']);
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
                    if ($validate['verification_status'] == 'terverifikasi') {
                        Mail::to($payment->resident->user->email)->send(new PaymentAcceptedMail($payment->resident->room->room_name));
                    }
                    $payment->update($validate);
                    session()->flash('success', 'Berhasil mengubah data');
                }
            } catch (Exception $e) {
                session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
            }
        }
    }
    public function updatedAmount()
    {
        // Mengonversi nilai input menjadi format Rupiah
        if ($this->amount !== "") {
            $validate = $this->validate([
                'amount' => 'required|regex:/^[0-9.]+$/',
            ]);
            $formatter =  number_format(str_replace('Rp ', '', str_replace('.', '', $this->amount)), 0, ',', '.');
            $this->amount = $formatter;
        }
    }
}
