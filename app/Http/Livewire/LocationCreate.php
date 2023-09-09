<?php

namespace App\Http\Livewire;

use App\Models\Location;
use Exception;
use Livewire\Component;

class LocationCreate extends Component
{

    public $locationId;
    public $sub_title;
    public $location_name;
    public $address;
    public $latitude;
    public $longitude;
    public $editMode = false; // Menentukan apakah dalam mode "edit"
    public $showMode = false; // Menentukan apakah dalam mode "show"


    public function mount()
    {
        if ($this->locationId !== null) {
            // Jika memiliki ID, kita berada dalam mode "edit"
            $location = Location::find($this->locationId);
            if ($location) {
                $this->location_name = $location->location_name;
                $this->address = $location->address;
                $this->latitude = $location->latitude;
                $this->longitude = $location->longitude;
                $this->editMode = true;
            }
        }
    }

    public function render()
    {
        return view('livewire.location-create');
    }

    public function resetFields()
    {
        $this->location_name = '';
        $this->address = '';
        $this->latitude = '';
        $this->longitude = '';
    }
    public function save()
    {
        // Simulasi delay 2 detik
        sleep(2);
        if (!$this->editMode) {
            $validate = $this->validate([
                'location_name' => 'required|min:3|max:100',
                'address' => 'required|min:3|max:500',
                'latitude' => 'required|min:3|max:20',
                'longitude' => 'required|min:3|max:20'
            ]);

            try {
                Location::create($validate);
                session()->flash('success', 'Berhasil simpan data');
                $this->resetFields();
            } catch (Exception $e) {
                session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
            }
        } else {
            // Logika untuk mode "edit"
            $validate = $this->validate([
                'location_name' => 'required|min:3|max:100',
                'address' => 'required|min:3|max:500',
                'latitude' => 'required|min:3|max:20',
                'longitude' => 'required|min:3|max:20'
            ]);
            try {
                $location = Location::find($this->locationId);
                if ($location) {
                    $location->update($validate);
                    session()->flash('success', 'Berhasil mengubah data');
                }
            } catch (Exception $e) {
                session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
            }
        }
    }
}
