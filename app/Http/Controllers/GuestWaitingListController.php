<?php

namespace App\Http\Controllers;

use App\Models\GuestWaitingList;
use Exception;
use Illuminate\Http\Request;

class GuestWaitingListController extends Controller
{
    protected $title = "Guest | List Tunggu Guest";
    protected $sub_title = "List Tunggu Guest";

    public function post_guest(Request $request)
    {
        try {
            $insert = GuestWaitingList::create([
                "location_id" => $request->post('location_id'),
                "guest_name" => $request->post('guest_name'),
                "guest_contact" => $request->post('guest_contact'),
                "request_date" => $request->post('request_date'),
                "status" => "menunggu",
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
    public function create()
    {
        return view('admin.guests.create', [
            "title" => $this->title,
            "sub_title" => "Entri " . $this->sub_title
        ]);
    }
    public function edit($id)
    {

        return view('admin.guests.create', [
            "title" => $this->title,
            "sub_title" => "Edit " . $this->sub_title,
            "guestId" => $id
        ]);
    }
    public function show($id)
    {
        return view('admin.guests.create', [
            "title" => $this->title,
            "sub_title" => "Detail " . $this->sub_title,
            "guestId" => $id,
            "showMode" => true
        ]);
    }
}
