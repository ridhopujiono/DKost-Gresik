<?php

namespace App\Http\Livewire;

use App\Models\Room;
use App\Models\RoomFacility;
use App\Models\RoomImage;
use Livewire\Component;
use Livewire\WithFileUploads;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;

class RoomMediaForm extends Component
{
    use WithFileUploads;

    public $sub_title;
    public $roomId;
    public $files = [];
    public $images;
    public $coverIndex = null; // Menyimpan indeks file sampul yang dipilih

    public function mount()
    {

        if ($this->roomId !== null) {
            // Jika memiliki ID, kita berada dalam mode "edit"
            $room = Room::where('id', $this->roomId)->with('roomImages')->first();
            if ($room) {
                $this->images = $room->roomImages;
            }
        }
    }

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
        return view('livewire.room-media-form');
    }

    public function save()
    {
        try {
            foreach ($this->files as $index => $file) {
                if ($file) {
                    // Unggah dan kompres file ke Cloudinary
                    $response = Cloudinary::upload($file->getRealPath(), [
                        'folder' => 'compressed_images', // Folder di Cloudinary
                        'quality' => 'auto:low', // Kualitas kompresi
                    ]);

                    // Save DB
                    RoomImage::create([
                        "room_id" => $this->roomId,
                        "image" => $response->getSecurePath(),
                        "cover" => $index == 0 ? true : false
                    ]);

                    // Reset input file
                    $this->files[$index] = null;
                }
            }
            session()->flash('success', 'Berhasil upload media');
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
}
