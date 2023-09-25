<?php

namespace App\Http\Controllers;

use App\Models\GuestWaitingList;
use Exception;
use Illuminate\Http\Request;

class GuestWaitingListController extends Controller
{
    protected $title = "Kamar | List Pengajuan Kamar";
    protected $sub_title = "List Pengajuan Kamar";


    public function index()
    {
        if (request()->ajax()) {
            $guests = GuestWaitingList::with('room')->orderBy('created_at', 'asc')->get();

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
