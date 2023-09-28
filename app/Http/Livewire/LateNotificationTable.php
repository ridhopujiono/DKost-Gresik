<?php

namespace App\Http\Livewire;

use App\Models\LatePaymentNotification;
use Livewire\Component;

class LateNotificationTable extends Component
{
    public $title = 'Manajemen Kos | Notifikasi Telat Pembayaran';
    public $sub_title = 'Notifikasi Telat Pembayaran';
    public function render()
    {
        $notifications = LatePaymentNotification::with('resident')->orderBy('created_at', 'desc')->get();

        return view('livewire.late-notification-table', [
            'notifications' => $notifications
        ]);
    }
}
