<?php

namespace App\Http\Controllers;

use App\Models\Room;

class RoomController extends Controller
{
    protected $title = "Manajemen Kost | Kamar Kos";
    protected $sub_title = "Kamar Kos";

    public function index()
    {
        if (request()->ajax()) {
            $rooms = Room::with('location') // Menggunakan "with" untuk mengambil relasi
                ->orderBy('room_name', 'asc')
                ->get();

            return datatables()->of($rooms)
                ->addColumn('action', function ($room) {
                    return '<div class="flex">
                        <a href="' . url('rooms') . '/' . $room->id . '/edit" class="btn px-2 bg-light border"><span class="bx bx-pencil"></span></a>
                        <a href="' . url('rooms') . '/' . $room->id . '" class="btn px-2 bg-warning"><span class="bx bx-show"></span></a>
                        <button onclick="showConfirmation(' . $room->id . ')" class="btn px-2 btn-danger"><span class="bx bx-trash"></span></button>
                    </div>';
                })
                ->make(true);
        }
        return view('admin.rooms.index', [
            "title" => $this->title,
            "sub_title" => $this->sub_title
        ]);
    }
    public function create()
    {
        return view('admin.rooms.create', [
            "title" => $this->title,
            "sub_title" => "Entri " . $this->sub_title
        ]);
    }
    public function edit($id)
    {
        return view('admin.rooms.create', [
            "title" => $this->title,
            "sub_title" => "Edit " . $this->sub_title,
            "roomId" => $id
        ]);
    }
    public function show($id)
    {
        return view('admin.rooms.create', [
            "title" => $this->title,
            "sub_title" => "Detail " . $this->sub_title,
            "roomId" => $id,
            "showMode" => true
        ]);
    }
}
