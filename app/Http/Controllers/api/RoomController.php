<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationBookingRoomJob;
use App\Models\GuestWaitingList;
use App\Models\Room;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function getAll(Request $request)
    {
        try {
            $perPage = $request->input('perPage', 20); // Menentukan jumlah data per halaman, 20 adalah nilai default
            $query = Room::query()->with(['roomFacilities.facility', 'location', 'roomImages']);

            if ($request->has('search')) {
                if ($request->input('room_type') == '') {
                    $query->where('room_name', 'like', '%' . $request->input('search') . '%');
                } else {
                    $query->where('room_name', 'like', '%' . $request->input('search') . '%')->where('room_type', $request->input('room_type'));
                }
            }
            // Menambahkan orderBy
            $query->orderBy('created_at', 'desc'); // Mengurutkan berdasarkan 'created_at' secara menurun

            $rooms = $query->paginate($perPage);

            return response()->json($rooms);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "data" => $e->getMessage()
            ]);
        }
    }
    public function getById($id)
    {
        try {
            $room = Room::with(['roomFacilities.facility', 'location', 'roomImages'])->where('id', $id)->first();

            return response()->json($room);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "data" => $e->getMessage()
            ]);
        }
    }
    public function reservation(Request $request, $room_id, $user_id, $type = "booking") // $type = "booking", "full_booked"
    {
        try {

            $user = User::find($user_id);

            if ($user->email_verified_at == NULL) {
                return response()->json([
                    "success" => false,
                    "data" => "Maaf email anda belum terverifikasi"
                ]);
            }

            $guest_waiting_lists = GuestWaitingList::where('user_id', $user_id)
                ->where('room_id', $room_id)
                ->whereIn('status', ['menunggu', 'full_booked'])
                ->get();

            if (count($guest_waiting_lists) > 0) {
                return response()->json([
                    "success" => false,
                    "data" => "Maaf anda sudah mengajukan pemesanan kamar ini"
                ]);
            } else {
                $save = GuestWaitingList::create([
                    'user_id' => $user_id,
                    'room_id' => $room_id,
                    'guest_name' => $request->input('guest_name'),
                    'guest_contact' => $request->input('phone'),
                    'request_date' => $request->input('request_date'),
                    'status' => $type == "booking" ? "menunggu" : "full_booked"
                ]);

                $email_argument = [
                    'email' => env('MAIL_USERNAME'),
                    'subject' => 'Permintaan Booking Kamar ' . ($type == "booking" ? "(Kamar Tersedia)" : "(Kamar Penuh)"),
                    'body' => 'Halo Admin, ada permintaan Booking Kamar, ' . ($type == "booking" ? "dengan status : Tersedia" : "namun status kamar : Penuh"),
                ];
                dispatch(new SendNotificationBookingRoomJob($email_argument['email'], $email_argument['subject'], $email_argument['body']));

                return response()->json([
                    "success" => true,
                    "data" => $type == "booking" ? "Berhasil mengajukan kamar. Anda dapat melihat status pengajuan kamar di menu Kamar Saya" : "Terimakasih, Anda akan dihubungi jika kamar sudah tersedia"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => "Gagal memesan, Mohon pesan sekali lagi"
            ]);
        }
    }
}
