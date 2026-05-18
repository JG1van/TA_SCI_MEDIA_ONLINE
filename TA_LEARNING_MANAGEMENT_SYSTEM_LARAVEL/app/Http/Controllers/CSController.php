<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Throwable;

use App\Models\QuestionCategory;
use App\Models\CSRoom;
use App\Models\CSLog;
use App\Models\CSMessage;
use App\Models\Student;

use App\Services\FirebaseService;
use Illuminate\Support\Facades\Auth;
use App\Models\CSFile;
use Illuminate\Support\Facades\Validator;
class CSController extends Controller
{
    protected FirebaseService $firebase;
    private const STATUS_QNA = 'QnA';
    private const STATUS_CHATBOT = 'ChatBot';
    private const STATUS_ADMIN = 'Admin';
    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }
    private function generateCode(): string
    {
        return Carbon::now()->format('dm-Y') . '-' .
            Str::upper(Str::random(4)) . '-' .
            Str::upper(Str::random(4));
    }
    private function checkOwner(Request $request, CSRoom $room): bool
    {
        $user = auth()->user();
        if ($room->user_id && $user && $user->id == $room->user_id)
            return true;
        if ($room->student_id && session('student_id') == $room->student_id)
            return true;
        if (session()->get('public_room_' . $room->room_code))
            return true;
        return false;
    }
    public function showCreateForm()
    {
        return view('layanan-pelanggan.index');
    }
    public function createRoom(Request $request)
    {
        DB::beginTransaction();
        try {
            $room = CSRoom::create([
                'room_code' => $this->generateCode(),
                'question_categories_id' => null,
                'student_id' => session('student_id'),
                'user_id' => auth()->user()?->id,
                'admin_id' => null,
                'chat_status' => self::STATUS_QNA,
            ]);
            if (!auth()->check() && !session('student_id')) {
                session()->put('public_room_' . $room->room_code, true);
            }
            DB::commit();
            return redirect()->route('layanan-pelanggan.ruang_pesan', $room->room_code);
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("createRoom: " . $e->getMessage());
            return back()->with('error', 'Gagal membuat ruang Layanan Pelanggan.');
        }
    }
    public function assignCategory(Request $request, $code)
    {
        $request->validate([
            'category_id' => 'required|exists:question_categories,id'
        ]);
        $room = CSRoom::where('room_code', $code)->firstOrFail();
        if (!$this->checkOwner($request, $room)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak memiliki akses.'
            ], 403);
        }
        DB::beginTransaction();
        try {
            $room->update([
                'question_categories_id' => $request->category_id,
                'chat_status' => self::STATUS_QNA,
                'updated_at' => Carbon::now('Asia/Jakarta')
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dipilih.'
            ], 200);
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("assignCategory: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menetapkan kategori.'
            ], 500);
        }
    }
    public function userChat(Request $request, $code)
    {
        $requireLogin = $request->get('_require_login', false);
        $room = CSRoom::where('room_code', $code)->firstOrFail();
        if (!$this->checkOwner($request, $room)) {
            return back()->with('error', 'Tidak memiliki akses.');
        }
        $role = session('role');
        $tabUmum = QuestionCategory::where('category_status', 'Aktif')->where('level', 'Umum')->get();
        $tabSiswa = $role === 'guru' ? collect() : QuestionCategory::where('category_status', 'Aktif')->where('level', 'Siswa')->get();
        $tabGuru = $role === 'siswa' ? collect() : QuestionCategory::where('category_status', 'Aktif')->where('level', 'Guru')->get();
        return view('layanan-pelanggan.ruang_pesan', compact(
            'room',
            'tabUmum',
            'tabSiswa',
            'tabGuru',
            'requireLogin',
        ));
    }
    public function sendTelegram($message)
    {
        $token = config('telegram.bot_token');
        $chat_id = config('telegram.chat_id');
        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        $response = Http::asForm()->post($url, [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true
        ]);
        if ($response->failed()) {
            Log::error("Telegram Send Failed: " . $response->body());
        }
        return $response->json();
    }
    public function startAI($roomId)
    {
        $room = CSRoom::findOrFail($roomId);
        $room->update([
            'chat_status' => self::STATUS_CHATBOT,
            'updated_at' => now('Asia/Jakarta')
        ]);
        $this->firebase->pushMessage($room->id, [
            'id' => time(),
            'sender' => 'Sistem',
            'message' => 'Terima kasih telah menghubungi layanan ini.<br> 
            Silakan jelaskan masalah Anda. ChatBot akan mencoba menjawab secara otomatis.',
            'time' => now('Asia/Jakarta')->format("H:i"),
            'ts' => now('Asia/Jakarta')->timestamp * 1000,
            'files' => []
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Chatbot aktif.'
        ]);
    }
    public function setAdminStatus($id)
    {
        $room = CSRoom::findOrFail($id);
        $room->update([
            'chat_status' => self::STATUS_ADMIN,
            'updated_at' => Carbon::now('Asia/Jakarta')
        ]);
        try {
            $this->firebase->pushMessage($room->id, [
                'id' => time(),
                'sender' => 'Sistem',
                'message' => 'Permintaan Anda telah diteruskan kepada Admin. Mohon menunggu respons.
Jika dalam 5 menit belum ada tanggapan, Anda dapat menekan tombol ini kembali. Gunakan fitur ini dengan bijak.',
                'time' => now('Asia/Jakarta')->format("H:i"),
                'ts' => now('Asia/Jakarta')->timestamp * 1000,
                'files' => []
            ]);
        } catch (Throwable $e) {
            Log::error("Firebase auto-admin message failed: " . $e->getMessage());
        }
        try {
            $this->sendTelegram("
🔔 <b>PANGGILAN MASUK</b>

<b>Kode Ruangan:</b> {$room->room_code}
<b>Kepada:</b> Semua Admin
<b>Waktu:</b> " . now('Asia/Jakarta')->format('d-m-Y H:i') . "

Pelanggan menghubungi karena tidak menemukan jawaban di QnA dan ChatBot.
Mohon segera ditinjau dan direspons oleh admin.
");
        } catch (Throwable $e) {
            Log::error("Telegram notification failed: " . $e->getMessage());
        }
        return response()->json([
            'success' => true,
            'message' => 'Status admin aktif.'
        ]);
    }
    public function panggilLagi($roomId)
    {
        $room = CSRoom::findOrFail($roomId);      // Ambil nama admin (jika ada relasi)
        $adminName = $room->admin ? $room->admin->name : 'Semua Admin';
        try {
            $this->sendTelegram("
🔔 <b>PANGGILAN ULANG</b>

<b>Kode Ruangan:</b> {$room->room_code}
<b>Kepada:</b> {$adminName}
<b>Waktu:</b> " . now('Asia/Jakarta')->format('d-m-Y H:i') . "

Pelanggan kembali menghubungi karena belum mendapat tanggapan atau percakapan sebelumnya terputus.
Mohon admin segera menindaklanjuti agar permasalahan pengguna dapat segera diselesaikan.
        ");
        } catch (Throwable $e) {
            Log::error("Telegram 'Panggil Lagi' failed: " . $e->getMessage());
        }
        return response()->json([
            'status' => 'ok',
            'message' => 'Notifikasi panggilan ulang terkirim.'
        ]);
    }
    public function upload(Request $request, $roomId)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required|mimes:jpg,jpeg,png,webp|max:5000',
            ],
            [
                'file.required' => 'File wajib diupload.',
                'file.mimes' => 'Format file harus JPG, JPEG, PNG, atau WEBP.',
                'file.max' => 'Ukuran file maksimal 5MB.',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $room = CSRoom::find($roomId);
        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Room tidak ditemukan.'
            ], 404);
        }
        try {
            $ext = $request->file('file')->getClientOriginalExtension();
            $nextNumber = CSFile::where('room_id', $room->id)->count() + 1;
            $newName = 'gambar_' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT) . '.' . $ext;
            $folder = "CS/room_{$room->id}";
            $path = $request->file('file')->storeAs($folder, $newName, 'public');
            $file = CSFile::create([
                'room_id' => $room->id,
                'file_path' => $newName
            ]);
            $nowWIB = now('Asia/Jakarta');
            $this->firebase->pushMessage($room->id, [
                'id' => time(),
                'sender' => 'Pelanggan',
                'type' => 'image',
                'image_url' => asset("storage/$folder/$newName"),
                'message' => 'Gambar',
                'full_time' => $nowWIB->format("Y-m-d H:i:s"),
                'ts' => $nowWIB->timestamp * 1000,
            ]);
            return response()->json([
                'success' => true,
                'url' => asset("storage/$folder/$newName"),
                'file' => [
                    'id' => $file->id,
                    'name' => $newName,
                    'time' => $file->created_at->format('Y-m-d H:i')
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function listFiles($roomId)
    {
        $files = CSFile::where('room_id', $roomId)
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function ($f) use ($roomId) {
                $folder = "CS/room_$roomId";
                return [
                    'id' => $f->id,
                    'url' => asset("storage/$folder/" . $f->file_path),
                    'name' => $f->file_path,
                    'ext' => strtolower(pathinfo($f->file_path, PATHINFO_EXTENSION)),
                ];
            });
        return response()->json([
            'success' => true,
            'files' => $files
        ]);
    }
    public function userFinish(Request $request, $code)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string'
        ]);
        $room = CSRoom::where('room_code', $code)->firstOrFail();
        DB::beginTransaction();
        try {
            $nowWIB = Carbon::now('Asia/Jakarta');
            try {
                $this->firebase->pushMessage($room->id, [
                    'id' => time(),
                    'sender' => 'Sistem',
                    'message' => 'Layanan ini telah diselesaikan oleh Pelanggan.',
                    'time' => $nowWIB->format("Y-m-d H:i:s"),
                    'ts' => $nowWIB->timestamp * 1000,
                    'files' => []
                ]);
            } catch (\Throwable $e) {
                Log::error('Firebase push final gagal', [
                    'room_id' => $room->id,
                    'error' => $e->getMessage()
                ]);
            }
            try {
                $chat = $this->firebase->getChatHistory($room->id);
            } catch (\Throwable $e) {
                Log::error('Ambil chat gagal', [
                    'room_id' => $room->id,
                    'error' => $e->getMessage()
                ]);
                $chat = ['hasChat' => false, 'messages' => []];
            }
            $messages = $chat['messages'] ?? [];
            usort($messages, fn($a, $b) => ($a['ts'] ?? 0) <=> ($b['ts'] ?? 0));
            if (!empty($messages)) {
                $logText = [];
                foreach ($messages as $msg) {
                    if (!empty($msg['ts'])) {
                        $msgTime = Carbon::createFromTimestamp($msg['ts'] / 1000)
                            ->timezone('Asia/Jakarta')
                            ->format('d/m/Y H:i');
                    } elseif (!empty($msg['time'])) {
                        try {
                            $msgTime = Carbon::parse($msg['time'])
                                ->timezone('Asia/Jakarta')
                                ->format('d/m/Y H:i');
                        } catch (\Throwable) {
                            $msgTime = '-';
                        }
                    } else {
                        $msgTime = '-';
                    }
                    $sender = $msg['sender'] ?? 'Unknown';
                    $message = $msg['message'] ?? '';
                    $logText[] = "[{$msgTime}] {$sender}: {$message}";
                }
                $notes = implode("\n", $logText);
            } else {
                $notes = "Tidak ada percakapan.";
            }
            switch ($room->chat_status) {
                case 'Admin':
                    $resolutionBy = 'Admin';
                    break;
                case 'ChatBot':
                    $resolutionBy = 'ChatBot';
                    break;
                default:
                    $resolutionBy = 'QnA';
                    $notes = "Terselesaikan otomatis oleh QnA.";
                    break;
            }
            $log = new CSLog();
            $log->room_code = $room->room_code;
            $log->question_categories_id = $room->question_categories_id;
            $log->admin_id = $room->admin_id;
            $log->completion_time = $nowWIB;
            $log->resolution_by = $resolutionBy;
            $log->rating = $request->rating;
            $log->review = $request->review;
            $log->notes = $notes;
            $log->created_at = $room->created_at;
            $log->updated_at = $room->updated_at;
            $log->timestamps = false;
            $log->save();
            try {
                $dir = "CS/room_{$room->id}";
                $basePath = public_path("storage/$dir");
                $files = CSFile::where('room_id', $room->id)->get();
                foreach ($files as $f) {
                    $relativePath = str_contains($f->file_path, 'CS/')
                        ? $f->file_path
                        : "$dir/{$f->file_path}";
                    $fullPath = public_path("storage/" . $relativePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
                CSFile::where('room_id', $room->id)->delete();
                if (is_dir($basePath)) {
                    rmdir($basePath);
                }
            } catch (\Throwable $e) {
                Log::error('Gagal hapus file', [
                    'room_id' => $room->id,
                    'error' => $e->getMessage()
                ]);
            }
            try {
                $this->firebase->deleteRoom($room->id);
            } catch (\Throwable $e) {
                Log::error('Gagal hapus firebase room', [
                    'room_id' => $room->id,
                    'error' => $e->getMessage()
                ]);
            }
            $room->delete();
            DB::commit();
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect()->route('layanan-pelanggan.index')
                ->with('success', 'Layanan telah selesai. Terima kasih.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal finish layanan', [
                'room_code' => $code,
                'error' => $e->getMessage()
            ]);
            return back()->with(
                'error',
                app()->environment('local')
                ? 'Error: ' . $e->getMessage()
                : 'Terjadi kesalahan saat menyelesaikan layanan.'
            );
        }
    }
    public function continueCS(Request $request)
    {
        $request->validate([
            'room_code' => 'required|string'
        ]);
        $room = CSRoom::where('room_code', $request->room_code)->first();
        if (!$room) {
            return back()->with('error', 'Kode ruangan tidak ditemukan.');
        }
        session()->put('public_room_' . $room->room_code, true);
        return redirect()->route('layanan-pelanggan.ruang_pesan', $room->room_code);
    }
}
