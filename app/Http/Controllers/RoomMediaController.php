<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomMediaController extends Controller
{
    protected $title = "Manajemen Kost | Media Kamar Kos";
    protected $sub_title = "Media Kamar Kos";

    public function index()
    {
        if (request()->ajax()) {
            $room_media = Room::with('location') // Menggunakan "with" untuk mengambil relasi
                ->orderBy('room_name', 'asc')
                ->get();

            return datatables()->of($room_media)
                ->addColumn('action', function ($rm) {
                    return '<div class="flex">
                    <a href="' . url('room/media') . '/' . $rm->id . '/edit" class="btn px-2 btn-primary border"><span class="bx bx-plus"></span></a>
                    </div>';
                })
                ->make(true);
        }
        return view('admin.room_media.index', [
            "title" => $this->title,
            "sub_title" => $this->sub_title
        ]);
    }
    public function create()
    {
        return view('admin.room_media.create', [
            "title" => $this->title,
            "sub_title" => "Entri " . $this->sub_title
        ]);
    }
    public function edit($id)
    {
        return view('admin.room_media.create', [
            "title" => $this->title,
            "sub_title" => "Edit " . $this->sub_title,
            "roomId" => $id
        ]);
    }
    public function show($id)
    {
        return view('admin.room_media.create', [
            "title" => $this->title,
            "sub_title" => "Detail " . $this->sub_title,
            "roomId" => $id,
            "showMode" => true
        ]);
    }
}
