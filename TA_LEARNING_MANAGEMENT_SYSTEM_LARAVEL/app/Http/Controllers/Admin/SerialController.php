<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Serial;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\SerialLog;
use Illuminate\Support\Facades\DB;
use App\Models\EmailLog;
class SerialController extends Controller
{
    public const ALLOWED_ROLES = [1, 2, 3, 5];
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Serial::with(['product', 'user'])
                ->orderBy('id', 'desc')
                ->get();
            return response()->json(['data' => $data]);
        }
        // Controller - index()
        $data = Serial::with(['product', 'user'])
            ->withCount([
                'serial_logs as serial_logs_count' => function ($q) {
                    $q->where('status', 'Perpanjang');
                }
            ])
            ->orderBy('id', 'desc')
            ->get();
        $products = Product::orderBy('id', 'desc')->get();
        $users = User::orderBy('id', 'desc')->get();
        $expiredSerials = Serial::with('user')
            ->whereNotNull('expired_at')
            ->whereDate('expired_at', '<=', now())
            ->orderBy('expired_at', 'desc')
            ->get();
        $expiredMoreThan14Months = Serial::with('user')
            ->whereNotNull('expired_at')
            ->whereDate('expired_at', '<=', now()->subMonths(14))
            ->orderBy('expired_at', 'desc')
            ->get();
        $expiringSoonSerials = Serial::with('user')
            ->whereNotNull('expired_at')
            ->whereDate('expired_at', '>', now())
            ->whereDate('expired_at', '<=', now()->addDays(30))
            ->orderBy('expired_at', 'desc')
            ->get();
        $notificationSerials = $expiredSerials
            ->merge($expiringSoonSerials)
            ->sortBy('expired_at');
        return view('admin.serial.index', compact(
            'data',
            'products',
            'users',
            'expiredSerials',
            'expiredMoreThan14Months',
            'expiringSoonSerials',
            'notificationSerials'
        ));
    }
    public function store(Request $request)
    {
        try {
            $validator = \Validator::make(
                $request->all(),
                [
                    'product_id' => 'required|exists:products,id',
                    'paket' => 'required|integer|min:1|max:9',
                    'active' => 'required|integer|min:1|max:3650',
                    'user_id' => 'nullable|exists:users,id',
                ]
            );
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }
            $user = null;
            $email = null;      // Ambil email user jika ada
            if ($request->user_id) {
                $user = User::find($request->user_id);
                $email = $user?->email;
            }
            \DB::beginTransaction();
            $serialCode = $this->generateSerial();
            $serial = Serial::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'serial' => $serialCode,
                'paket' => $request->paket, // <-- isi jumlah kelas
                'active' => $request->active,
                'expired_at' => null,
            ]);
            SerialLog::create([
                'serial_id' => $serial->id,
                'active' => $serial->active,
                'status' => 'Baru',
            ]);
            if ($email) {
                $this->sendSerialEmailAuto($serial, $email);
            }
            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Serial berhasil dibuat.',
                'data' => $serial,
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan serial: ' . $e->getMessage(),
            ], 500);
        }
    }
    private function sendSerialEmailAuto($serial, $email, $type = 'baru')
    {
        try {
            $fromName = config('mail.from.name');
            $fromEmail = config('mail.from.address');
            $apiKey = config('services.brevo.key');
            $productName = $serial->product->name ?? '-';

            if ($type === 'perpanjang') {
                $subject = 'Perpanjangan Serial Produk Anda';
                $infoMessage = <<<HTML
<p>Masa aktif serial Anda telah berhasil diperpanjang.</p>
<p>Berikut adalah informasi terbaru mengenai serial Anda.</p>
HTML;
                $detailTambahan = <<<HTML
    <li><b>Expired Baru:</b> {$serial->expired_at}</li>
HTML;
            } else {
                $subject = 'Informasi Serial Produk Anda';
                $infoMessage = <<<HTML
<p>Serial Anda telah berhasil ditambahkan ke dalam sistem dan sudah terhubung dengan akun Anda.</p>
<p>Anda dapat langsung menggunakan layanan tanpa perlu memasukkan kode serial secara manual.</p>
HTML;
                $detailTambahan = '';
            }

            $html = <<<HTML
<h3>Informasi Serial Produk Anda</h3>
<p>Terima kasih telah menggunakan layanan kami.</p>
{$infoMessage}

<p><b>Kode Serial Anda:</b></p>
<h2 style="letter-spacing:3px; margin-top:5px;">{$serial->serial}</h2>

<br>

<p><b>Detail Produk:</b></p>
<ul>
    <li><b>Nama Produk:</b> {$productName}</li>
    <li><b>Paket Kelas:</b> {$serial->paket} kelas</li>
    <li><b>Durasi Langganan:</b> {$serial->active} bulan</li>
    <li><b>Email Terdaftar:</b> {$email}</li>
    {$detailTambahan}
</ul>

<br>

<p>Untuk memperpanjang masa aktif serial, silakan menghubungi admin melalui layanan yang telah disediakan.</p>

<p><b>⚠️ Penting:</b><br>
Tanggal kedaluwarsa akan mulai dihitung setelah Anda pertama kali membuat kelas. 
Setelah masa aktif berakhir, layanan tidak dapat digunakan dan harus diperpanjang.</p>

<p>Apabila serial tidak diperpanjang hingga 14 bulan setelah tanggal kedaluwarsa, maka:</p>
<ul>
    <li>Serial akan dihapus secara permanen</li>
    <li>Seluruh data kelas dan murid akan terhapus</li>
    <li>Data nilai serta riwayat pembelajaran tidak dapat dipulihkan</li>
</ul>

<p>Kami sangat menyarankan agar Anda melakukan perpanjangan sebelum batas waktu tersebut.</p>

<br>

<p>Jika Anda memerlukan bantuan atau ingin melakukan perpanjangan, silakan hubungi admin kami.</p>

<br>

<p>Hormat kami,<br>
<b>{$fromName}</b></p>
HTML;

            $payload = [
                'sender' => ['name' => $fromName, 'email' => $fromEmail],
                'to' => [['email' => $email]],
                'subject' => $subject,
                'htmlContent' => $html,
            ];

            $response = Http::timeout(10)->withHeaders([
                'api-key' => $apiKey,
                'accept' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', $payload);

            EmailLog::create([
                'serial_id' => $serial->id,
                'email_to' => $email,
                'subject' => $subject,
                'email_type' => 'Serial',
                'status' => $response->successful() ? 'Berhasil' : 'Gagal',
                'source' => 'Manual',
            ]);

        } catch (\Exception $e) {
            \Log::error('Send Serial Auto Email Error', [
                'serial_id' => $serial->id,
                'error' => $e->getMessage(),
            ]);

            EmailLog::create([
                'serial_id' => $serial->id,
                'email_to' => $email,
                'subject' => $subject ?? 'Informasi Serial',
                'email_type' => 'Serial',
                'status' => 'Gagal',
                'source' => 'Manual',
            ]);
        }
    }
    private function generateSerial()
    {
        do {
            $code = strtoupper(
                Str::random(4) . '-' .
                Str::random(4) . '-' .
                Str::random(4) . '-' .
                Str::random(4)
            );
        } while (Serial::where('serial', $code)->exists());
        return $code;
    }
    public function edit($id)
    {
        $serial = Serial::with(['product', 'user'])->find($id);
        if (!$serial) {
            return response()->json([
                'success' => false,
                'message' => 'Serial tidak ditemukan.',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $serial,
        ]);
    }
    public function update(Request $request, $id)
    {
        $serial = Serial::find($id);
        if (!$serial) {
            return response()->json([
                'success' => false,
                'message' => 'Serial tidak ditemukan.'
            ], 404);
        }
        $validator = \Validator::make(
            $request->all(),
            [
                'product_id' => 'required|exists:products,id',
                'paket' => 'required|regex:/^[1-9]{1}$/',
                'active' => 'sometimes|regex:/^[0-9]{1,3}$/',
                'user_id' => 'nullable|exists:users,id',
            ],
            [
                'product_id.required' => 'Produk wajib dipilih.',
                'product_id.exists' => 'Produk tidak valid.',
                'paket.required' => 'Jumlah paket wajib diisi.',
                'active.regex' => 'Masa aktif harus berupa angka (1-999).',
                'user_id.exists' => 'User tidak valid.',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }
        try {
            $serial->update([
                'product_id' => $request->product_id,
                'paket' => $request->paket,
                'active' => $request->active ?? $serial->active,
                'user_id' => $request->user_id,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Serial berhasil diperbarui.',
                'data' => $serial
            ]);
        } catch (\Exception $e) {
            \Log::error('Update Serial Error', [
                'serial_id' => $id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui serial'
            ], 500);
        }
    }
    public function destroy($id)
    {
        $serial = Serial::find($id);
        if (!$serial) {
            return response()->json([
                'success' => false,
                'message' => 'Serial tidak ditemukan.',
            ], 404);
        }
        $relatedData = [];
        if (\App\Models\Classroom::where('serial_id', $id)->exists()) {
            $relatedData[] = 'kelas';
        }
        if (\App\Models\Student::where('serial_id', $id)->exists()) {
            $relatedData[] = 'siswa';
        }
        if (\App\Models\Report::where('serial_id', $id)->exists()) {
            $relatedData[] = 'laporan';
        }
        if (\App\Models\Task::where('serial_id', $id)->exists()) {
            $relatedData[] = 'tugas';
        }
        if (\App\Models\Exercise::where('serial_id', $id)->exists()) {
            $relatedData[] = 'soal';
        }
        if (!empty($relatedData)) {
            return response()->json([
                'success' => false,
                'message' => 'Serial tidak dapat dihapus karena masih digunakan pada: ' . implode(', ', $relatedData),
            ], 409);
        }
        try {
            $serial->delete();
            return response()->json([
                'success' => true,
                'message' => 'Serial berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus serial: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function extend(Request $request, $id)
    {
        $serial = Serial::with(['user', 'product'])->find($id);
        if (!$serial) {
            return response()->json([
                'success' => false,
                'message' => 'Serial tidak ditemukan.',
            ], 404);
        }
        $validator = \Validator::make(
            $request->all(),
            [
                'extend_months' => 'required|integer|min:1|max:120',
            ],
            [
                'extend_months.required' => 'Jumlah bulan perpanjangan wajib diisi.',
                'extend_months.integer' => 'Perpanjangan harus berupa angka.',
                'extend_months.min' => 'Minimal perpanjangan 1 bulan.',
                'extend_months.max' => 'Maksimal perpanjangan 120 bulan (batas maksimal tipe TIMESTAMP adalah 19 Januari 2038).',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        try {
            $now = Carbon::now();
            if (is_null($serial->expired_at)) {
                $newExpired = $now->copy()->addMonths($request->extend_months);
            } else {
                $expired = Carbon::parse($serial->expired_at);
                if ($expired->isPast()) {
                    $newExpired = $now->copy()->addMonths($request->extend_months);
                } else {
                    $newExpired = $expired->copy()->addMonths($request->extend_months);
                }
            }
            $maxTimestamp = Carbon::create(2038, 1, 19, 3, 14, 7);
            if ($newExpired->greaterThan($maxTimestamp)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Perpanjangan gagal karena tanggal kedaluwarsa melebihi batas sistem.',
                ], 422);
            }
            $serial->expired_at = $newExpired;
            $serial->active = (int) $serial->active + (int) $request->extend_months;
            $serial->notif = 'Tidak_ada';
            $serial->save();
            SerialLog::create([
                'serial_id' => $serial->id,
                'active' => $request->extend_months,
                'status' => 'Perpanjang',
            ]);
            if ($serial->user && $serial->user->email) {
                $this->sendSerialEmailAuto($serial, $serial->user->email, 'perpanjang');
            }
            return response()->json([
                'success' => true,
                'message' => 'Masa aktif serial berhasil diperpanjang.',
                'expired_at' => $serial->expired_at,
                'active' => $serial->active,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperpanjang serial: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function riwayat()
    {
        $logs = SerialLog::with('serial')->latest()->get();
        return view('admin.serial.riwayat', compact('logs'));
    }
    public function emailLogs()
    {
        $emails = EmailLog::with('serial')
            ->latest()
            ->limit(500)
            ->get();
        return view('admin.serial.email', compact('emails'));
    }
    public function sendSerialEmail(Request $request)
    {
        $request->validate([
            'serial_id' => 'required|exists:serials,id',
            'email' => 'required|email'
        ]);
        try {
            $serial = Serial::with('product')->findOrFail($request->serial_id);
            $fromName = config('mail.from.name');
            $fromEmail = config('mail.from.address');
            $apiKey = config('services.brevo.key');
            $email = $request->email;
            $productName = $serial->product->name ?? '-';
            $infoMessage = <<<HTML
<p>Serial produk Anda telah berhasil dibuat.</p>

<p>Silakan salin (copy) kode serial di bawah ini dan masukkan (paste) pada halaman aktivasi yang telah disediakan.</p>

<p>Pastikan Anda menyimpan kode serial ini dengan baik.</p>
HTML;
            $html = <<<HTML
<h3>Informasi Serial Produk Anda</h3>

<p>Terima kasih telah menggunakan layanan kami.</p>
{$infoMessage}

<p><b>Kode Serial Anda:</b></p>
<h2 style="letter-spacing:3px; margin-top:5px;">{$serial->serial}</h2>

<br>

<p><b>Detail Produk:</b></p>
<ul>
    <li><b>Nama Produk:</b> {$productName}</li>
    <li><b>Paket Kelas:</b> {$serial->paket} kelas</li>
    <li><b>Durasi Langganan:</b> {$serial->active} bulan</li>
    <li><b>Email Tujuan:</b> {$email}</li>
</ul>

<br>

<p>Untuk memperpanjang masa aktif serial, silakan menghubungi admin melalui layanan yang telah disediakan.</p>

<p><b>⚠️ Penting:</b><br>
Tanggal kedaluwarsa akan mulai dihitung setelah Anda pertama kali membuat kelas. 
Setelah masa aktif berakhir, layanan tidak dapat digunakan dan harus diperpanjang.</p>

<p>Apabila serial tidak diperpanjang hingga 14 bulan setelah tanggal kedaluwarsa, maka:</p>

<ul>
    <li>Serial akan dihapus secara permanen</li>
    <li>Seluruh data kelas dan murid akan terhapus</li>
    <li>Data nilai serta riwayat pembelajaran tidak dapat dipulihkan</li>
</ul>

<p>Kami sangat menyarankan agar Anda melakukan perpanjangan sebelum batas waktu tersebut.</p>

<br>

<p>Jika Anda memerlukan bantuan atau ingin melakukan perpanjangan, silakan hubungi admin kami.</p>

<br>

<p>Hormat kami,<br>
<b>{$fromName}</b></p>
HTML;
            $payload = [
                'sender' => [
                    'name' => $fromName,
                    'email' => $fromEmail,
                ],
                'to' => [
                    ['email' => $email]
                ],
                'subject' => 'Informasi Serial Produk Anda',
                'htmlContent' => $html
            ];
            $response = Http::timeout(10)->withHeaders([
                'api-key' => $apiKey,
                'accept' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', $payload);
            EmailLog::create([
                'serial_id' => $serial->id,
                'email_to' => $email,
                'subject' => 'Informasi Serial Produk Anda',
                'email_type' => 'Serial',
                'status' => $response->successful() ? 'Berhasil' : 'Gagal',
                'source' => 'Manual'
            ]);
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Email berhasil dikirim'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => $response->json()['message'] ?? 'Gagal mengirim email'
            ], 500);
        } catch (\Exception $e) {
            \Log::error('Send Manual Serial Email Error', [
                'serial_id' => $request->serial_id,
                'error' => $e->getMessage()
            ]);
            EmailLog::create([
                'serial_id' => $request->serial_id,
                'email_to' => $request->email,
                'subject' => 'Informasi Serial Produk Anda',
                'email_type' => 'Serial',
                'status' => 'Gagal',
                'source' => 'Manual'
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim email'
            ], 500);
        }
    }
    public function bulkSendExpiryWarning(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:serials,id',
        ]);
        $serials = Serial::with(['user', 'product'])
            ->whereIn('id', $request->ids)
            ->get();
        $sent = 0;
        $skipped = 0;
        foreach ($serials as $serial) {
            if (!$serial->user || !$serial->user->email) {
                $skipped++;
                continue;
            }
            $result = $this->sendExpiryEmail($serial, 'Manual');
            if ($result['success']) {
                $sent++;
            } else {
                $skipped++;
            }
        }
        return response()->json([
            'success' => true,
            'sent' => $sent,
            'skipped' => $skipped,
            'total' => $serials->count(),
        ]);
    }
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:serials,id',
        ]);
        $serials = Serial::whereIn('id', $request->ids)
            ->where('expired_at', '<=', Carbon::now()->subMonths(14))
            ->get();
        foreach ($serials as $serial) {
            $serial->delete();
        }
        return response()->json([
            'success' => true,
            'message' => $serials->count() . ' serial berhasil dihapus.'
        ]);
    }
    public function sendExpiryEmail($serial, $source = 'Manual')
    {
        if (!$serial->user || !$serial->user->email) {
            return ['success' => false, 'message' => 'User atau email tidak tersedia'];
        }
        if (!$serial->expired_at) {
            return ['success' => false, 'message' => 'Tanggal expired tidak tersedia'];
        }
        $expiredAt = Carbon::parse($serial->expired_at)->startOfDay();
        $today = Carbon::today();
        $isExpired = $expiredAt->lte($today);
        $fromName = config('mail.from.name');
        $fromEmail = config('mail.from.address');
        $apiKey = config('services.brevo.key');
        if ($isExpired) {
            if ($serial->notif === 'Kedaluwarsa') {
                return ['success' => false, 'message' => 'Notifikasi kedaluwarsa sudah pernah dikirim'];
            }
            $newStatus = 'Kedaluwarsa';
            $subject = 'Serial Anda Telah Kedaluwarsa';
            $title = '❌ Masa Aktif Serial Telah Berakhir';
            $message = "
<p>Halo,</p>

<p>Kami ingin menginformasikan bahwa masa aktif serial Anda telah berakhir.</p>

<hr>

<p><strong>Detail Serial:</strong></p>
<ul>
    <li><strong>Kode Serial:</strong> {$serial->serial}</li>
    <li><strong>Nama Produk:</strong> {$serial->product->name}</li>
    <li><strong>Tanggal Kedaluwarsa:</strong> {$expiredAt->format('d M Y')}</li>
</ul>

<hr>

<p>Untuk kembali menggunakan layanan, silakan melakukan perpanjangan serial Anda.</p>

<p><strong>⚠️ Penting:</strong><br>
Apabila serial tidak diperpanjang hingga 14 bulan setelah tanggal kedaluwarsa 
(<strong>{$expiredAt->copy()->addMonths(14)->format('d M Y')}</strong>), maka:</p>

<ul>
    <li>Serial akan dihapus secara permanen</li>
    <li>Seluruh data kelas dan murid akan terhapus</li>
    <li>Data nilai serta riwayat pembelajaran tidak dapat dipulihkan</li>
</ul>

<p>Kami sangat menyarankan agar Anda melakukan perpanjangan sebelum batas waktu tersebut.</p>

<br>

<p>Hormat kami,<br><strong>{$fromName}</strong></p>
";
        } else {
            if ($serial->notif === 'Peringatan') {
                return ['success' => false, 'message' => 'Notifikasi peringatan sudah pernah dikirim'];
            }
            $newStatus = 'Peringatan';
            $subject = 'Serial Anda Akan Kedaluwarsa';
            $title = '⏰ Masa Aktif Serial Akan Berakhir';
            $message = "
<p>Halo,</p>

<p>Kami ingin mengingatkan bahwa masa aktif serial Anda akan segera berakhir.</p>

<hr>

<p><strong>Detail Serial:</strong></p>
<ul>
    <li><strong>Kode Serial:</strong> {$serial->serial}</li>
    <li><strong>Nama Produk:</strong> {$serial->product->name}</li>
    <li><strong>Tanggal Kedaluwarsa:</strong> {$expiredAt->format('d M Y')}</li>
</ul>

<hr>

<p>Silakan lakukan perpanjangan sebelum masa aktif berakhir agar layanan tetap dapat digunakan tanpa gangguan.</p>

<p>Melakukan perpanjangan lebih awal akan membantu Anda menghindari penghentian layanan serta risiko kehilangan akses data.</p>

<br>

<p>Hormat kami,<br><strong>{$fromName}</strong></p>
";
        }
        $html = "
<h3>{$title}</h3>
<p>Kode Serial:</p>
<h2>{$serial->serial}</h2>
{$message}
";
        $payload = [
            'sender' => [
                'name' => $fromName,
                'email' => $fromEmail,
            ],
            'to' => [
                ['email' => $serial->user->email]
            ],
            'subject' => $subject,
            'htmlContent' => $html
        ];
        $response = Http::withHeaders([
            'api-key' => $apiKey,
            'accept' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', $payload);
        if ($response->successful()) {
            $serial->notif = $newStatus;
            $serial->save();
            EmailLog::create([
                'serial_id' => $serial->id,
                'email_to' => $serial->user->email,
                'subject' => $subject,
                'email_type' => $newStatus,
                'status' => 'Berhasil',
                'source' => $source
            ]);
            return ['success' => true];
        }
        EmailLog::create([
            'serial_id' => $serial->id,
            'email_to' => $serial->user->email,
            'subject' => $subject,
            'email_type' => $newStatus,
            'status' => 'Gagal',
            'source' => $source
        ]);
        return [
            'success' => false,
            'message' => $response->json()['message'] ?? 'Gagal kirim email'
        ];
    }
    public function processExpiry($source)
    {
        $today = \Carbon\Carbon::today();
        $serials = \App\Models\Serial::with(['user', 'product'])
            ->whereNotNull('expired_at')
            ->where(function ($query) use ($today) {
                $query->whereDate('expired_at', '<=', $today)
                    ->orWhereBetween('expired_at', [
                        $today,
                        $today->copy()->addDays(30)
                    ]);
            })
            ->get();
        foreach ($serials as $serial) {
            $this->sendExpiryEmail($serial, $source);
        }
        return $serials->count();
    }
}

