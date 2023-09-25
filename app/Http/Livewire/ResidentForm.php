<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\Resident;
use App\Models\Room;
use Carbon\Carbon;
use Livewire\Component;

class ResidentForm extends Component
{
    public $residentId;
    public $sub_title;
    public $room_id;
    public $rooms = [];
    public $locationSelected;
    public $location_id;
    public $locations;
    public $name;
    public $address;
    public $contact;
    public $contact_name;
    public $contact_number;
    public $emergency_info;
    public $contract_start;
    public $contract_end;
    public $payment_status;
    public $editMode = false; // Menentukan apakah dalam mode "edit"
    public $showMode = false; // Menentukan apakah dalam mode "edit"

    public $isContractEndChanged = false;


    public function mount()
    {
        $this->locations = Location::orderBy('location_name', 'asc')->get();
        $resident = Resident::where('id', $this->residentId)->with('room')->first();
        if ($this->residentId !== null) {
            // Jika memiliki ID, kita berada dalam mode "edit"
            if ($resident) {
                $this->locationSelected = $resident->room->location_id;
                $this->location_id = $resident->room->location_id;

                $this->updatedLocationSelected();

                $this->room_id = $resident->room_id;
                $this->name = $resident->name;
                $this->address = $resident->address;
                $this->contact = $resident->contact;
                $this->contact_name = $resident->emergency_info["contact_name"];
                $this->contact_number = $resident->emergency_info["contact_number"];
                $this->contract_start = $resident->contract_start;
                $this->contract_end = $resident->contract_end;
                $this->payment_status = $resident->payment_status;
                $this->editMode = true;
            }
        }
    }
    public function render()
    {
        return view('livewire.resident-form');
    }
    public function resetFields()
    {
        $this->room_id = '';
        $this->name = '';
        $this->address = '';
        $this->contact = '';
        $this->contact_name = '';
        $this->contact_number = '';
        $this->emergency_info = '';
        $this->contract_start = '';
        $this->contract_end = '';
        $this->payment_status = '';
    }
    public function setContractEndChanged(){
        $this->isContractEndChanged = true;
    }
    public function save()
    {
        // Simulasikan pemrosesan yang memerlukan waktu
        sleep(2);
        $validate = $this->validate([
            'room_id' => 'required|min:1|max:100',
            'name' => 'required|min:2|max:100',
            'address' => 'required|min:2|max:255',
            'contact' => 'required|min:2|max:20',
            'contact_name' => 'required|min:2|max:100',
            'contact_number' => 'required|min:2|max:20',
            'contract_start' => 'required',
            'contract_end' => 'required',
            'payment_status' => 'required',
        ]);
        $validate['emergency_info'] = [
            "contact_name" => $validate['contact_name'],
            "contact_number" => $validate['contact_number']
        ];


        // Logika untuk mode "edit"
        try {
            $resident = Resident::find($this->residentId);

            $validate['late_status'] = $validate['payment_status'] == "lunas" ? 0 : 1;

            if ($resident['payment_status'] != 'lunas') {
                if(!$this->isContractEndChanged){
                    $validate['contract_end'] = $validate['payment_status'] == "lunas" ? Carbon::parse($validate['contract_end'])->addMonth(1) : $validate['contract_end'];
                }

                $this->contract_end =  Carbon::parse($validate['contract_end'])->format('Y-m-d H:i');
            }


            if ($resident) {
                $resident->update($validate);
                session()->flash('success', 'Berhasil mengubah data');
            }
        } catch (Exception $e) {
            session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
        }

    }
    public function updatedLocationSelected()
    {
        $this->rooms = Room::where('location_id', $this->locationSelected)->get();
    }
    public function updatedContractStart()
    {
        $this->contract_end = Carbon::parse($this->contract_start)->addMonth(1)->format('Y-m-d H:i');
    }
}
