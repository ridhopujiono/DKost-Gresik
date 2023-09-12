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
        $current_date = Carbon::now();
        $end_date = Carbon::parse($this->contract_end);

        if ($current_date->greaterThan($end_date)) {
            if ($this->late_status == 0) {
                $this->update(['payment_status' => 'belum_lunas']);
                $this->update(['late_status' => true]);
            }
        }
    }
}
