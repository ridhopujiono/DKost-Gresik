<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LatePaymentController extends Controller
{
    protected $title = "Pembayaran | Telat Pembayaran";
    protected $sub_title = "Telat Pembayaran";

    public function index()
    {
        if (request()->ajax()) {
            $guests = GuestWaitingList::with('location')->orderBy('created_at', 'asc')->get();

            return datatables()->of($guests)
                ->addColumn('action', function ($guest) {
                    return '<div class="flex">
                        <a href="' . url('guests') . '/' . $guest->id . '/edit" class="btn px-2 bg-light border"><span class="bx bx-pencil"></span></a>
                        <a href="' . url('guests') . '/' . $guest->id . '" class="btn px-2 bg-warning"><span class="bx bx-show"></span></a>
                        <button onclick="showConfirmation(' . $guest->id . ')" class="btn px-2 btn-danger"><span class="bx bx-trash"></span></button>
                    </div>';
                })
                ->make(true);
        }
        return view('admin.guests.index', [
            "title" => $this->title,
            "sub_title" => $this->sub_title
        ]);
    }
}
