<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'address',
        'contact',
        'emergency_info',
        'contract_start',
        'contract_end',
        'payment_status',
        'late_status'
    ];
    protected $casts = [
        'emergency_info' => 'array', // Kolom 'emergency_info' akan di-cast menjadi tipe array
    ];
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function updateLateStatus()
    {
        // Implementasi logika untuk memperbarui StatusTelat
        $start_date = new Carbon($this->contract_start);
        $end_date = new Carbon($this->contract_end);

        if ($start_date->greaterThan($end_date)) {
            if ($this->payment_status == 'belum_lunas' && $this->late_status == 0) {
                $this->update(['late_status' => true]);
            }
        }
    }
}
