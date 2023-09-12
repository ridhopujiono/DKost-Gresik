<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $title = "Pembayaran | Pembayaran";
    protected $sub_title = "Pembayaran";

    public function post_payment(Request $request)
    {
        try {
            $insert = Payment::create([
                "resident_id" => $request->post('resident_id'),
                "payment_date" => $request->post('payment_date'),
                "amount" => $request->post('amount'),
                "payment_proof" => $request->post('payment_proof'),
                "verification_status" => "menunggu",
            ]);
            if ($insert) {
                return response()->json([
                    "status" => 200,
                    "message" => "success"
                ], 200);
            } else {
                return response()->json([
                    "status" => 400,
                    "message" => "error"
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        if (request()->ajax()) {
            $payments = Payment::with('resident') // Menggunakan "with" untuk mengambil relasi
                ->orderBy('created_at', 'asc')
                ->get();
            return datatables()->of($payments)
                ->addColumn('action', function ($payment) {
                    return '<div class="flex">
                        <a href="' . url('payments') . '/' . $payment->id . '/edit" class="btn px-2 bg-light border"><span class="bx bx-pencil"></span></a>
                        <button onclick="showConfirmation(' . $payment->id . ')" class="btn px-2 btn-danger"><span class="bx bx-trash"></span></button>
                    </div>';
                })
                ->addColumn('room_name', function ($payment) {
                    return $payment->resident->room->room_name;
                })
                ->make(true);
        }
        return view('admin.payments.index', [
            "title" => $this->title,
            "sub_title" => $this->sub_title
        ]);
    }
    public function create()
    {
        return view('admin.payments.create', [
            "title" => $this->title,
            "sub_title" => "Entri " . $this->sub_title
        ]);
    }
    public function edit($id)
    {
        return view('admin.payments.create', [
            "title" => $this->title,
            "sub_title" => "Edit " . $this->sub_title,
            "paymentId" => $id
        ]);
    }
    public function show($id)
    {
        return view('admin.payments.create', [
            "title" => $this->title,
            "sub_title" => "Detail " . $this->sub_title,
            "paymentId" => $id,
            "showMode" => true
        ]);
    }
}
