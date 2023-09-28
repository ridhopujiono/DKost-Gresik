<?php

namespace App\Models;

use App\Jobs\LateNotificationMailJob;
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
        'late_status',
        'is_checkout',
        'user_id'
    ];
    protected $casts = [
        'emergency_info' => 'array', // Kolom 'emergency_info' akan di-cast menjadi tipe array
    ];
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function late_payment_notification()
    {
        return $this->hasMany(LatePaymentNotification::class);
    }
    public function updateLateStatus()
    {
        // Implementasi logika untuk memperbarui StatusTelat
        $current_date = Carbon::now();
        $end_date = Carbon::parse($this->contract_end);

        if ($current_date->greaterThan($end_date)) {
            if ($this->late_status == 0 && $this->is_checkout == 0) {
                $this->update(['payment_status' => 'belum_lunas']);
                $this->update(['late_status' => true]);

                LatePaymentNotification::create([
                    'resident_id' => $this->id,
                    'notification_date' => Carbon::now(),
                    'notification_content' => "Telat Pembayaran Kamar <b>" . $this->room->room_name . "</b>",
                    'read_status' => false,
                ]);
                dispatch(new LateNotificationMailJob($this->user->email, $this->room->room_name));
            }
        }
    }
}
