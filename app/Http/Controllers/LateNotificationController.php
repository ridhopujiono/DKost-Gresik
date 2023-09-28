<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LateNotificationController extends Controller
{
    public function index()
    {
        return view('admin.notification.index', [
            'title' => 'Manajemen Kos | Notifikasi Telat Pembayaran',
            'sub_title' => 'Notifikasi Telat Pembayaran',
        ]);
    }
}
