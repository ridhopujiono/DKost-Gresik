<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;

class ResidentController extends Controller
{
    protected $title = "Manajemen Kost | Penghuni Kos";
    protected $sub_title = "Penghuni Kos";

    public function index()
    {
        Date::setLocale('id');

        if (request()->ajax()) {

            $residents = Resident::with('room')->orderBy('created_at', 'asc')->get();
            return datatables()->of($residents)
                ->addColumn('action', function ($resident) {
                    return '<div class="flex">
                        <a href="' . url('residents') . '/' . $resident->id . '/edit" class="btn px-2 bg-light border"><span class="bx bx-pencil"></span></a>
                        <a href="' . url('residents') . '/' . $resident->id . '" class="btn px-2 bg-warning"><span class="bx bx-show"></span></a>
                        <button onclick="showConfirmation(' . $resident->id . ')" class="btn px-2 btn-danger"><span class="bx bx-trash"></span></button>
                    </div>';
                })
                ->addColumn('rental_period', function ($resident) {
                    if (Date::now()->greaterThan($resident->contract_end)) {
                        return "<span class='badge bg-danger'>Habis</span>";
                    } else {
                        return Date::now()->timespan($resident->contract_end);
                    }
                })
                ->addColumn('registered_at', function ($resident) {
                    return Date::parse($resident->created_at)->diffForHumans();
                })
                ->rawColumns(['action', 'rental_period'])
                ->make(true);
        }
        return view('admin.residents.index', [
            "title" => $this->title,
            "sub_title" => $this->sub_title
        ]);
    }
    public function create()
    {
        return view('admin.residents.create', [
            "title" => $this->title,
            "sub_title" => "Entri " . $this->sub_title
        ]);
    }
    public function edit($id)
    {
        return view('admin.residents.create', [
            "title" => $this->title,
            "sub_title" => "Edit " . $this->sub_title,
            "residentId" => $id
        ]);
    }
    public function show($id)
    {
        return view('admin.residents.create', [
            "title" => $this->title,
            "sub_title" => "Detail " . $this->sub_title,
            "residentId" => $id,
            "showMode" => true
        ]);
    }
}
