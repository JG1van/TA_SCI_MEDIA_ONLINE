<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use App\Models\CSRoom;

use App\Models\Admin;
use App\Models\User;        // Guru
use App\Models\Student;     // Siswa

class LoginAllController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');   // view login umum
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $username = $request->username;
        $password = $request->password;

        if (Auth::guard('web')->attempt(['username' => $username, 'password' => $password])) {

            $request->session()->regenerate();

            $admin = Auth::guard('web')->user();
            $admin->login_at = now();
            $admin->save();
            // Trigger reminder setelah response selesai (tidak ganggu login)
            dispatch(function () {
                $controller = app(\App\Http\Controllers\Admin\SerialController::class);

                if (!\Cache::add('expiry-reminder-lock', true, 21600)) {
                    return;
                }

                $controller->processExpiry('Login_Admin');

            })->afterResponse();
            $roles = [
                1 => 'Super-Admin',
                2 => 'Admin',
                3 => 'Operasional',
                4 => 'Konten-Pembelajaran',
                5 => 'Layanan-Pengguna',
            ];
            $roleName = $roles[$admin->role] ?? 'Admin';

            $message = "
                <b>Berhasil login!</b><br>
                Selamat datang, <b>{$admin->username}</b><br>
                Selaku <b>{$roleName}</b>.<br>
                Selamat bekerja.
            ";

            return redirect()->route('admin.dashboard')
                ->with('success_html', $message);
        }
        // $guru = User::where('username', $username)->first();
        // if ($guru && Hash::check($password, $guru->password)) {
        //     Auth::login($guru);
        //     session(['role' => 'guru']);
        //     $message = "
        //         <b>Berhasil login!</b><br>
        //         Selamat datang, <b>{$guru->username}</b><br>
        //         <b>Siap mengajar!</b>
        //     ";
        //     return redirect()->route('guru.dashboard')
        //         ->with('success_html', $message);
        // }
        // $student = Student::where('username', $username)->first();
        // if ($student && Hash::check($password, $student->password)) {
        //     Auth::login($student);
        //     session(['role' => 'siswa']);
        //     $message = "
        //         <b>Berhasil login!</b><br>
        //         Selamat datang, <b>{$student->username}</b><br>
        //         <b>Siap belajar!</b>
        //     ";
        //     return redirect()->route('student.dashboard')
        //         ->with('success_html', $message);
        // }
        return back()->withErrors([
            'username' => 'Username atau password salah.'
        ]);
    }
    public function loginCS(Request $request)
    {
        $request->validate([
            'login_as' => 'required|in:guru,siswa',
            'username' => 'required|string',
            'password' => 'required|string',
            'room_code' => 'required|string'
        ]);

        $room = CSRoom::where('room_code', $request->room_code)->first();

        if (!$room) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room tidak ditemukan.'
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN SEBAGAI GURU
        |--------------------------------------------------------------------------
        */
        if ($request->login_as === 'guru') {

            $guru = User::where('username', $request->username)->first();

            if (!$guru || !Hash::check($request->password, $guru->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Username atau password guru salah.'
                ], 401);
            }

            /*
            |--------------------------------------------------------------------------
            | CEK EKSKLUSIVITAS FK
            |--------------------------------------------------------------------------
            */

            // Jika room sudah dimiliki siswa → tolak
            if ($room->student_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Login gagal. Akun yang digunakan tidak sesuai dengan akun sebelumnya. Silakan gunakan akun yang sama untuk mengakses room ini.'
                ], 403);
            }

            // Jika room sudah dimiliki guru lain → tolak
            if ($room->user_id && $room->user_id !== $guru->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Login gagal. Akun yang digunakan tidak sesuai dengan akun sebelumnya. Silakan gunakan akun yang sama untuk mengakses room ini.'
                ], 403);
            }

            // Login dan assign
            Auth::login($guru);
            session(['role' => 'guru']);

            $room->update([
                'user_id' => $guru->id,
                'student_id' => null,
                'admin_id' => null
            ]);

            return response()->json([
                'status' => 'success',
                'role' => 'guru',
                'username' => $guru->username
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN SEBAGAI SISWA
        |--------------------------------------------------------------------------
        */
        if ($request->login_as === 'siswa') {

            $student = Student::where('username', $request->username)->first();

            if (!$student || !Hash::check($request->password, $student->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Username atau password siswa salah.'
                ], 401);
            }

            /*
            |--------------------------------------------------------------------------
            | CEK EKSKLUSIVITAS FK
            |--------------------------------------------------------------------------
            */

            // Jika room sudah dimiliki guru → tolak
            if ($room->user_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Login gagal. Akun yang digunakan tidak sesuai dengan akun sebelumnya. Silakan gunakan akun yang sama untuk mengakses room ini.'
                ], 403);
            }

            // Jika room sudah dimiliki siswa lain → tolak
            if ($room->student_id && $room->student_id !== $student->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Login gagal. Akun yang digunakan tidak sesuai dengan akun sebelumnya. Silakan gunakan akun yang sama untuk mengakses room ini.'
                ], 403);
            }

            // Login dan assign
            Auth::login($student);
            session(['role' => 'siswa']);

            $room->update([
                'student_id' => $student->id,
                'user_id' => null,
                'admin_id' => null
            ]);

            return response()->json([
                'status' => 'success',
                'role' => 'siswa',
                'username' => $student->username
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Berhasil logout.');
    }
}
