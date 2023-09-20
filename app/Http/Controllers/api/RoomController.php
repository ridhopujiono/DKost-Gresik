<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Room;
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
}
