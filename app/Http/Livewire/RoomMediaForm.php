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
    public $file;
    public $images;
    public $isCover = false; //

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

    public function render()
    {
        return view('livewire.room-media-form');
    }

    public function save()
    {
        try {
            if ($this->file) {
                // Unggah dan kompres file ke Cloudinary
                $response = Cloudinary::upload($this->file->getRealPath(), [
                    'folder' => 'compressed_images', // Folder di Cloudinary
                    'quality' => 'auto:low', // Kualitas kompresi
                ]);
                if (!$response) {
                    return session()->flash('error', 'Gagal upload media');
                } else {
                    // Save DB
                    RoomImage::create([
                        "room_id" => $this->roomId,
                        "image" => $response->getSecurePath(),
                        "cover" => $this->isCover === true ? true : false
                    ]);
                    session()->flash('success', 'Berhasil upload media');
                }
            }
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
    public function destroyImage()
    {
        RoomImage::where('room_id', $this->roomId)->delete();
        session()->flash('success', 'Berhasil hapus media');
    }
}
