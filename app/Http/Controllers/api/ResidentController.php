<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Resident;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            'data' => Resident::with('room', 'room.roomImages')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get()
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
            $image = '';
            if ($request->ktp_image) {
                $response = Cloudinary::upload($request->file('ktp_image')->getRealPath(), [
                    'folder' => 'ktp_image', // Folder di Cloudinary
                    'quality' => 'auto:low', // Kualitas kompresi
                ]);
                if (!$response) {
                    return response()->json([
                        'success' => false,
                        'data' => 'Gagal unggah bukti pembayaran'
                    ], 400);
                }
                $image = $response->getSecurePath();
            } else {
                $image = Resident::find($resident_id)->ktp_image;
            }


            // Save DB
            Resident::find($resident_id)->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'contact' => $request->input('contact'),
                'emergency_info' => [
                    'contact_name' => $request->input('contact_name'),
                    'contact_number' => $request->input('contact_number'),
                ],
                'ktp_number' => $request->input('ktp_number'),
                'ktp_image' => $image,
                'job' => $request->input('job'),
                'institute' => $request->input('institute'),
                'institute_address' => $request->input('institute_address'),
                'vehicle' => $request->input('vehicle'),
                'vehicle_number' => $request->input('vehicle_number'),
            ]);
            return response()->json([
                'success' => true,
                'data' => 'Berhasil ubah profile pengguna'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data' => $e->getMessage()
            ], 500);
        }
    }
}
