<?php

namespace App\Http\Controllers;

use App\Models\Facility;

class FacilityController extends Controller
{
    protected $title = "Manajemen Kost | Fasilitas Kos";
    protected $sub_title = "Fasilitas Kos";

    public function index()
    {
        if (request()->ajax()) {
            $facilities = Facility::orderBy('facility_name', 'asc')->get();

            return datatables()->of($facilities)
                ->addColumn('action', function ($facility) {
                    return '<div class="flex">
                        <a href="' . url('facilities') . '/' . $facility->id . '/edit" class="btn px-2 bg-light border"><span class="bx bx-pencil"></span></a>
                        <a href="' . url('facilities') . '/' . $facility->id . '" class="btn px-2 bg-warning"><span class="bx bx-show"></span></a>
                        <button onclick="showConfirmation(' . $facility->id . ')" class="btn px-2 btn-danger"><span class="bx bx-trash"></span></button>
                    </div>';
                })
                ->make(true);
        }
        return view('admin.facilities.index', [
            "title" => $this->title,
            "sub_title" => $this->sub_title
        ]);
    }
    public function create()
    {
        return view('admin.facilities.create', [
            "title" => $this->title,
            "sub_title" => "Entri " . $this->sub_title
        ]);
    }
    public function edit($id)
    {

        return view('admin.facilities.create', [
            "title" => $this->title,
            "sub_title" => "Edit " . $this->sub_title,
            "facilityId" => $id
        ]);
    }
    public function show($id)
    {
        return view('admin.facilities.create', [
            "title" => $this->title,
            "sub_title" => "Detail " . $this->sub_title,
            "facilityId" => $id,
            "showMode" => true
        ]);
    }
}
