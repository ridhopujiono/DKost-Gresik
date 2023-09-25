<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestWaitingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'guest_name',
        'guest_contact',
        'request_date',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
