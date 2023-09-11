<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'room_name',
        'room_type',
        'capacity',
        'price',
        'stock',
        'room_status'
    ];
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    public function roomFacilities()
    {
        return $this->hasMany(RoomFacility::class);
    }
}
