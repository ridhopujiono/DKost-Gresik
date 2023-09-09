<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $title = "Manajemen Kost | Kamar Kos";
    protected $sub_title = "Kamar Kos";

    public function index()
    {
        if (request()->ajax()) {
            $locations = Room::orderBy('location_name', 'asc')->get();

            return datatables()->of($locations)
                ->addColumn('action', function ($location) {
                    return '<div class="flex">
                        <a href="' . url('location') . '/' . $location->id . '/edit" class="btn px-2 bg-light border"><span class="bx bx-pencil"></span></a>
                        <a href="' . url('location') . '/' . $location->id . '" class="btn px-2 bg-warning"><span class="bx bx-show"></span></a>
                        <button onclick="showConfirmation(' . $location->id . ')" class="btn px-2 btn-danger"><span class="bx bx-trash"></span></button>
                    </div>';
                })
                ->make(true);
        }
        return view('admin.locations.index', [
            "title" => $this->title,
            "sub_title" => $this->sub_title
        ]);
    }
    public function create()
    {
        return view('admin.locations.create', [
            "title" => $this->title,
            "sub_title" => "Entri " . $this->sub_title
        ]);
    }
    public function edit($id)
    {

        return view('admin.locations.create', [
            "title" => $this->title,
            "sub_title" => "Edit " . $this->sub_title,
            "locationId" => $id
        ]);
    }
    public function show($id)
    {
        return view('admin.locations.create', [
            "title" => $this->title,
            "sub_title" => "Detail " . $this->sub_title,
            "locationId" => $id,
            "showMode" => true
        ]);
    }
}
