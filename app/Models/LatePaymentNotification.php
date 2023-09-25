<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatePaymentNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'notification_date',
        'notification_content',
        'read_status'
    ];
}
