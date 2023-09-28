<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Resident;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function getResidentByResidentId($resident_id)
    {
        return response()->json([
            'success' => true,
            'data' => Resident::find($resident_id)
        ], 200);
    }
    public function getResidentByUserId($user_id)
    {
        return response()->json([
            'success' => true,
            'data' => Resident::with('room')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get()
        ], 200);
    }
    public function getResidentPaymentHistoriesByResidentId($resident_id)
    {
        return response()->json([
            'success' => true,
            'data' => Payment::where('resident_id', $resident_id)->orderBy('created_at', 'desc')->get()
        ], 200);
    }
    public function postResidentPayment(Request $request, $resident_id)
    {
        try {
            $response = Cloudinary::upload($request->file('file')->getRealPath(), [
                'folder' => 'payment_proof', // Folder di Cloudinary
                'quality' => 'auto:low', // Kualitas kompresi
            ]);

            // Save DB
            Payment::create([
                'resident_id' => $resident_id,
                'payment_date' => Carbon::now(),
                'amount' => '0',
                'payment_proof' => $response->getSecurePath(),
                'verification_status' => 'menunggu'
            ]);
            return response()->json([
                'success' => true,
                'data' => 'Berhasil unggah bukti pembayaran'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data' => "Gagal unggah bukti pembayaran. Error: " . $e->getMessage()
            ], 500);
        }
    }
    public function postResidentProfile(Request $request, $resident_id)
    {
        try {

            // Save DB
            Resident::find($resident_id)->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'contact' => $request->input('contact'),
                'emergency_info' => $request->input('emergency_info'),
            ]);
            return response()->json([
                'success' => true,
                'data' => 'Berhasil unggah bukti pembayaran'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data' => "Gagal unggah bukti pembayaran. Error: " . $e->getMessage()
            ], 500);
        }
    }
}
