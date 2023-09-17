<?php

namespace App\Http\Livewire;

use App\Models\Facility;
use App\Models\Location;
use App\Models\Room;
use App\Models\RoomFacility;
use Livewire\Component;

class RoomForm extends Component
{
    public $locations;
    public $locationSelected;
    public $location_id;
    public $facility_ids = [];
    public $facilities;
    public $facilitySelected = [];
    public $roomId;
    public $sub_title;
    public $room_name;
    public $room_type;
    public $roomTypeSelected;
    public $capacity;
    public $price;
    public $stock;
    public $room_status;
    public $roomStatusSelected;
    public $editMode = false; // Menentukan apakah dalam mode "edit"
    public $showMode = false; // Menentukan apakah dalam mode "show"

    public function mount()
    {
        $this->locations = Location::orderBy('location_name', 'asc')->get();
        $this->facilities = Facility::orderBy('facility_name', 'asc')->get();
        if ($this->roomId !== null) {
            // Jika memiliki ID, kita berada dalam mode "edit"
            $room = Room::where('id', $this->roomId)->with('roomFacilities')->first();

            if ($room) {
                $this->location_id = $room->location_id;
                $this->room_type = $room->room_type;
                $this->room_status = $room->room_status;
                // timpa nilai selected dengan nilai database
                $this->locationSelected = $room->location_id;
                $this->roomTypeSelected = $room->room_type;
                $this->roomStatusSelected = $room->room_status;
                // 
                $this->facility_ids = $room->roomFacilities->pluck('facility_id')->toArray();
                $this->facilitySelected = $room->roomFacilities->pluck('facility_id')->toArray();
                $this->room_name = $room->room_name;
                $this->capacity = $room->capacity;
                $this->price = (float) $room->price;
                $this->stock = $room->stock;
                $this->editMode = true;
            }
        }
    }

    public function updatedPrice()
    {
        // Mengonversi nilai input menjadi format Rupiah
        if ($this->price !== "") {
            $validate = $this->validate([
                'price' => 'required|regex:/^[0-9.]+$/',
            ]);
            $formatter =  number_format(str_replace('Rp ', '', str_replace('.', '', $this->price)), 0, ',', '.');
            $this->price = $formatter;
        }
    }


    public function render()
    {
        return view('livewire.room-form');
    }

    public function resetFields()
    {
        $this->locationSelected = '';
        $this->roomTypeSelected = '';
        $this->roomStatusSelected = '';
        $this->facilitySelected = [];
        $this->room_name = '';
        $this->capacity = '';
        $this->price = '';
        $this->stock = '';
    }
    public function save()
    {
        // Simulasi delay 2 detik
        sleep(2);

        $validate = $this->validate([
            'locationSelected' => 'required',
            'roomTypeSelected' => 'required',
            'roomStatusSelected' => 'required',
            'facilitySelected' => 'required',
            'room_name' => 'required|min:3|max:100',
            'capacity' => 'required|max:10',
            'price' => 'required|min:3|max:20',
            'stock' => 'required|max:10'
        ]);
        if (!$this->editMode) {
            try {
                // Insert to master data
                $insert = Room::create([
                    'location_id' => $validate['locationSelected'],
                    'room_name' => $validate['room_name'],
                    'room_type' => $validate['roomTypeSelected'],
                    'capacity' => $validate['capacity'],
                    'price' => str_replace('.', '', $validate['price']),
                    'stock' => $validate['stock'],
                    'room_status' => $validate['roomStatusSelected'],
                ]);
                // then insert to room_facility
                foreach ($validate['facilitySelected'] as $facility_id) {
                    RoomFacility::create([
                        "room_id" => $insert->id,
                        "facility_id" => $facility_id
                    ]);
                }
                session()->flash('success', 'Berhasil simpan data');
                $this->resetFields();
            } catch (Exception $e) {
                session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
            }
        } else {
            // Logika untuk mode "edit"
            try {
                $room = Room::find($this->roomId);
                if ($room) {
                    $room->update([
                        'location_id' => $validate['locationSelected'],
                        'room_name' => $validate['room_name'],
                        'room_type' => $validate['roomTypeSelected'],
                        'capacity' => $validate['capacity'],
                        'price' => str_replace('.', '', $validate['price']),
                        'stock' => $validate['stock'],
                        'room_status' => $validate['roomStatusSelected'],
                    ]);
                    RoomFacility::where('room_id', $this->roomId)->delete();
                    // then insert to room_facility
                    foreach ($validate['facilitySelected'] as $facility_id) {
                        RoomFacility::create([
                            "room_id" => $room->id,
                            "facility_id" => $facility_id
                        ]);
                    }
                    session()->flash('success', 'Berhasil mengubah data');
                }
            } catch (Exception $e) {
                session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
            }
        }
    }
}
