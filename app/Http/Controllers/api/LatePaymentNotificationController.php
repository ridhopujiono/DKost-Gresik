<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\LatePaymentNotification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class LatePaymentNotificationController extends Controller
{
    public function getNotificationByUserId($user_id)
    {
        try {
            $user = User::find($user_id);
            $resident_ids = $user->resident->pluck('id');

            return response()->json([
                'success' => true,
                'data' => LatePaymentNotification::select('*')->whereIn('resident_id', $resident_ids)->get()
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data' => $e->getMessage()
            ], 500);
        }
    }
}
