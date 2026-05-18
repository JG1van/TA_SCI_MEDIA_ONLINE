<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\CSRoom;

class CheckRoomOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil parameter route secara fleksibel
        |--------------------------------------------------------------------------
        */
        $roomIdentifier = $request->route('code')
            ?? $request->route('room')
            ?? $request->route('id');

        if (!$roomIdentifier) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Cari room berdasarkan room_code atau id
        |--------------------------------------------------------------------------
        */
        $room = CSRoom::where('room_code', $roomIdentifier)
            ->orWhere('id', $roomIdentifier)
            ->first();

        if (!$room) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Jika room sudah memiliki owner → wajib login
        |--------------------------------------------------------------------------
        */
        if (!is_null($room->user_id) || !is_null($room->student_id)) {

            if (!Auth::check()) {

                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => 'unauthorized'
                    ], 401);
                }

                // Jangan abort
                $request->merge(['_require_login' => true]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Lanjutkan request
        |--------------------------------------------------------------------------
        */
        return $next($request);
    }
}
