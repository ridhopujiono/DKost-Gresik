<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestWaitingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'guest_name',
        'guest_contact',
        'request_date',
        'status'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
