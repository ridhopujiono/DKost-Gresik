<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\Resident;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResidentForm extends Component
{
    use WithFileUploads;
    public $residentId;
    public $sub_title;
    public $room_id;
    public $rooms = [];
    public $locationSelected;
    public $location_id;
    public $locations;
    public $email;
    public $name;
    public $address;
    public $contact;
    public $contact_name;
    public $contact_number;
    public $emergency_info;
    public $ktp_number;
    public $ktp_image;
    public $job;
    public $institute;
    public $institute_address;
    public $vehicle;
    public $vehicle_number;
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
                $this->ktp_number = $resident->ktp_number;
                $this->ktp_image = $resident->ktp_image;
                $this->job = $resident->job;
                $this->institute = $resident->institute;
                $this->institute_address = $resident->institute_address;
                $this->vehicle = $resident->vehicle;
                $this->vehicle_number = $resident->vehicle_number;
                $this->contract_start = $resident->contract_start;
                $this->contract_end = $resident->contract_end;
                $this->payment_status = $resident->payment_status;
                $this->editMode = true;
                $this->showMode = true;
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
    public function setContractEndChanged()
    {
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
            'ktp_number' => 'required',
            'ktp_image' => 'nullable',
            'job' => 'required',
            'institute' => 'required',
            'institute_address' => 'required',
            'vehicle' => 'required',
            'vehicle_number' => 'required'
        ]);
        $validate['emergency_info'] = [
            "contact_name" => $validate['contact_name'],
            "contact_number" => $validate['contact_number']
        ];


        // Logika untuk mode "edit"
        if ($this->editMode) {
            try {
                $resident = Resident::find($this->residentId);

                $validate['late_status'] = $validate['payment_status'] == "lunas" ? 0 : 1;

                if ($resident['payment_status'] != 'lunas') {
                    if (!$this->isContractEndChanged) {
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
        } else {
            try {
                $response = Cloudinary::upload($this->ktp_image->getRealPath(), [
                    'folder' => 'ktp_image', // Folder di Cloudinary
                    'quality' => 'auto:low', // Kualitas kompresi
                ]);
                if (!$response) {
                    return session()->flash('error', 'Galat mengunggah KTP');
                }
                $user = User::updateOrCreate([
                    'email' => $this->email
                ], [
                    'email' => $this->email,
                    'password' => Hash::make('12345678'),
                    'name' => $this->name,
                    'level' => 'guest',
                    'profile_picture' => 'https://img.icons8.com/material-rounded/48/7950F2/user-male-circle.png'
                ]);
                // Save DB
                Resident::create([
                    'user_id' => $user->id,
                    'room_id' => $this->room_id,
                    'name' => $this->name,
                    'address' => $this->address,
                    'contact' => $this->contact,
                    'emergency_info' => [
                        'contact_name' => $this->contact_name,
                        'contact_number' => $this->contact_number,
                    ],
                    'ktp_number' => $this->ktp_number,
                    'ktp_image' => $response->getSecurePath(),
                    'job' => $this->job,
                    'institute' => $this->institute,
                    'institute_address' => $this->institute_address,
                    'vehicle' => $this->vehicle,
                    'vehicle_number' => $this->vehicle_number,
                    'payment_status' => $this->payment_status,
                    'contract_start' => $this->contract_start,
                    'contract_end' => $this->contract_end,
                    'late_status' => $validate['late_status'] = $validate['payment_status'] == "lunas" ? 0 : 1
                ]);
                session()->flash('success', 'Berhasil mengunggah penghuni');
            } catch (Exception $e) {
                return session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
            }
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
