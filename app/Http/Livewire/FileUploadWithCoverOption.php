<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class FileUploadWithCoverOption extends Component
{
    use WithFileUploads;

    public $files = [];
    public $coverIndex = null; // Menyimpan indeks file sampul yang dipilih

    public function addFile()
    {
        $this->files[] = null;
    }

    public function removeFile($index)
    {
        unset($this->files[$index]);
        $this->files = array_values($this->files);

        // Jika file yang dihapus adalah file sampul, set coverIndex menjadi null
        if ($index === $this->coverIndex) {
            $this->coverIndex = null;
        }
    }
    public function render()
    {
        return view('livewire.file-upload-with-cover-option');
    }
}
