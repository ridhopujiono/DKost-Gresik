<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'payment_date',
        'amount',
        'payment_proof',
        'verification_status'
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }
}
