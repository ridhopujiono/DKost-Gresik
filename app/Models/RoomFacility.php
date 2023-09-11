<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomFacility extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'facility_id'];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
