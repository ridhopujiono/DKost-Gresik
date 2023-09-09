<?php

namespace App\Http\Livewire;

use App\Models\Facility;
use Livewire\Component;

class FacilityForm extends Component
{
    public $facilityId;
    public $sub_title;
    public $facility_name;
    public $editMode = false; // Menentukan apakah dalam mode "edit"
    public $showMode = false; // Menentukan apakah dalam mode "edit"


    public function mount()
    {
        if ($this->facilityId !== null) {
            // Jika memiliki ID, kita berada dalam mode "edit"
            $facility = Facility::find($this->facilityId);
            if ($facility) {
                $this->facility_name = $facility->facility_name;
                $this->editMode = true;
            }
        }
    }

    public function render()
    {
        return view('livewire.facility-form');
    }

    public function resetFields()
    {
        $this->facility_name = '';
    }
    public function save()
    {
        // Simulasikan pemrosesan yang memerlukan waktu
        sleep(2);
        if (!$this->editMode) {
            $validate = $this->validate([
                'facility_name' => 'required|min:2|max:100'
            ]);

            try {
                Facility::create($validate);
                session()->flash('success', 'Berhasil simpan data');
                $this->resetFields();
            } catch (Exception $e) {
                session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
            }
        } else {
            // Logika untuk mode "edit"
            $validate = $this->validate([
                'facility_name' => 'required|min:2|max:100'
            ]);
            try {
                $facility = Facility::find($this->facilityId);
                if ($facility) {
                    $facility->update($validate);
                    session()->flash('success', 'Berhasil mengubah data');
                }
            } catch (Exception $e) {
                session()->flash('error', 'Ada error disisi server. Pesan error: ' . $e->getMessage());
            }
        }
    }
}
