<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Admin;

class AdminController extends Controller
{
    public const ALLOWED_ROLES = [1];
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $admins = Admin::orderBy('id', 'asc')->get();
            return response()->json(['data' => $admins]);
        }
        $admins = Admin::orderBy('id', 'asc')->get();
        return view('admin.admin.index', compact('admins'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:admins,username',
            'role' => 'nullable|integer|min:0|max:9',
            'date_in' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        try {
            $imgPath = null;
            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('public/admins');
                $imgPath = str_replace('public/', '', $imgPath);
            }
            $admin = Admin::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make('Admin1234'),
                'role' => $request->role ?? 0,
                'date_in' => $request->date_in,
                'position' => $request->position,
                'phone' => $request->phone,
                'img' => $imgPath,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil ditambahkan.',
                'data' => $admin,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan admin: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function edit($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin tidak ditemukan.',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $admin,
        ]);
    }
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:100',
                'username' => 'required|string|max:50|unique:admins,username,' . $id,
                'role' => 'nullable|integer|min:0|max:9',
                'date_in' => 'nullable|date',
                'position' => 'nullable|string|max:50',
                'phone' => 'nullable|string|max:20',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'username.required' => 'Username wajib diisi.',
                'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
                'role.integer' => 'Role harus berupa angka.',
                'role.min' => 'Role tidak boleh kurang dari 0.',
                'role.max' => 'Role tidak boleh lebih dari 9.',
                'date_in.date' => 'Format tanggal tidak valid.',
                'position.max' => 'Jabatan maksimal 50 karakter.',
                'phone.max' => 'Nomor telepon maksimal 20 karakter.',
                'photo.image' => 'File foto harus berupa gambar.',
                'photo.mimes' => 'Format foto harus jpeg, png, jpg, atau webp.',
                'photo.max' => 'Ukuran foto maksimal 2MB.',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        $admin->update([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role ?? 0,
            'date_in' => $request->date_in,
            'position' => $request->position,
            'phone' => $request->phone,
        ]);
        if ($request->hasFile('photo')) {
            if ($admin->img && Storage::disk('public')->exists('admins/' . $admin->img)) {
                Storage::disk('public')->delete('admins/' . $admin->img);
            }
            $path = $request->file('photo')->store('admins', 'public');
            $admin->img = basename($path);
            $admin->save();
        }
        return response()->json(['success' => true, 'message' => 'Data admin berhasil diperbarui.']);
    }
    public function destroy($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin tidak ditemukan.',
            ], 404);
        }
        $relations = [
            ['model' => \App\Models\LessonItem::class, 'column' => 'admin_id', 'label' => 'materi'],
            ['model' => \App\Models\ExerciseItem::class, 'column' => 'admin_id', 'label' => 'soal'],
        ];
        $relatedData = [];
        foreach ($relations as $relation) {
            if ($relation['model']::where($relation['column'], $id)->exists()) {
                $relatedData[] = $relation['label'];
            }
        }
        if (!empty($relatedData)) {
            $list = implode(', ', $relatedData);
            return response()->json([
                'success' => false,
                'message' => "Admin ini tidak dapat dihapus karena masih terhubung dengan data: {$list}.",
            ], 409);
        }
        try {
            if ($admin->img) {
                if ($admin->img && Storage::disk('public')->exists('admins/' . $admin->img)) {
                    Storage::disk('public')->delete('admins/' . $admin->img);
                }
            }
            $admin->delete();
            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil dihapus.',
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin tidak dapat dihapus karena masih terhubung dengan data lain.',
                ], 409);
            }
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus admin: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function resetPassword($id)
    {
        try {
            $admin = Admin::find($id);
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data admin tidak ditemukan.',
                ]);
            }
            $admin->password = bcrypt('Admin1234');
            $admin->save();
            return response()->json([
                'success' => true,
                'message' => 'Password berhasil direset menjadi: Admin1234',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mereset password. ' . $e->getMessage(),
            ]);
        }
    }
    public function statistik($id)
    {
        try {
            $admin = \App\Models\Admin::find($id);
            if (!$admin) {
                return response()->json(['success' => false, 'message' => 'Admin tidak ditemukan.'], 404);
            }

            // ── 1. TOTAL MATERI ────────────────────────────
            $totalMateri = \DB::table('lesson_items')
                ->where('admin_id', $id)
                ->count();

            // ── 2. TOTAL SOAL ───────────────────────────
            $totalSoal = \DB::table('exercise_items')
                ->where('admin_id', $id)
                ->count();

            // ── 3. CS LOGS — query terpisah masing-masing ────
            $totalCS = \DB::table('cs_logs')->where('admin_id', $id)->count();
            $totalBintang = \DB::table('cs_logs')->where('admin_id', $id)->sum('rating');
            $rataRating = $totalCS > 0 ? round(\DB::table('cs_logs')->where('admin_id', $id)->avg('rating'), 2) : 0;
            $maxRating = $totalCS > 0 ? \DB::table('cs_logs')->where('admin_id', $id)->max('rating') : 0;
            $minRating = $totalCS > 0 ? \DB::table('cs_logs')->where('admin_id', $id)->min('rating') : 0;

            // Distribusi rating 1–5
            $distribusiRaw = \DB::table('cs_logs')
                ->where('admin_id', $id)
                ->selectRaw('rating, COUNT(*) as total')
                ->groupBy('rating')
                ->pluck('total', 'rating');

            $distribusiRating = [];
            foreach ([5, 4, 3, 2, 1] as $r) {
                $distribusiRating[$r] = $distribusiRaw[$r] ?? 0;
            }

            // ── 4. LOG AKTIVITAS ─────────────────────────────
            $totalLog = \DB::table('admin_activity_logs')
                ->where('admin_id', $id)
                ->count();

            // ── 5. MATERI PER BULAN ──────────────────────────
            $materiBulan = \DB::table('lesson_items')
                ->where('admin_id', $id)
                ->where('created_at', '>=', now()->subMonths(12)->startOfMonth())
                ->selectRaw("DATE_FORMAT(created_at, '%b %Y') as label, DATE_FORMAT(created_at, '%Y-%m') as sort_key, COUNT(*) as total")
                ->groupBy('label', 'sort_key')
                ->orderBy('sort_key', 'asc')
                ->get()
                ->map(fn($row) => ['label' => $row->label, 'total' => (int) $row->total])
                ->values()
                ->toArray();

            // ── 6. AKTIVITAS TERBARU ─────────────────────────
            $logsAktivitas = \DB::table('admin_activity_logs')
                ->where('admin_id', $id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(fn($row) => [
                    'type' => 'log',
                    'action' => $row->action,
                    'time' => \Carbon\Carbon::parse($row->created_at)->locale('id')->isoFormat('DD MMM YYYY · HH:mm'),
                    'sort' => $row->created_at,
                ]);

            $logsMateri = \DB::table('lesson_items')
                ->where('admin_id', $id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(fn($row) => [
                    'type' => 'materi',
                    'action' => 'Upload materi "' . \Str::limit($row->title ?? 'Tanpa Judul', 40) . '"',
                    'time' => \Carbon\Carbon::parse($row->created_at)->locale('id')->isoFormat('DD MMM YYYY · HH:mm'),
                    'sort' => $row->created_at,
                ]);

            $logsCS = \DB::table('cs_logs')
                ->where('admin_id', $id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(fn($row) => [
                    'type' => 'cs',
                    'action' => 'Selesaikan tiket CS (rating ' . $row->rating . ' ★)',
                    'time' => \Carbon\Carbon::parse($row->created_at)->locale('id')->isoFormat('DD MMM YYYY · HH:mm'),
                    'sort' => $row->created_at,
                ]);

            $aktivitasTerbaru = $logsAktivitas
                ->concat($logsMateri)
                ->concat($logsCS)
                ->sortByDesc('sort')
                ->take(5)
                ->values()
                ->map(fn($item) => ['type' => $item['type'], 'action' => $item['action'], 'time' => $item['time']])
                ->toArray();

            // ── 7. MAX VALUES untuk radar ─────────────────────
            $maxMateri = \DB::table('lesson_items')
                ->selectRaw('COUNT(*) as total')
                ->whereNotNull('admin_id')
                ->groupBy('admin_id')
                ->orderByDesc('total')
                ->value('total') ?? 1;

            $maxSoal = \DB::table('exercise_items')
                ->selectRaw('COUNT(*) as total')
                ->whereNotNull('admin_id')
                ->groupBy('admin_id')
                ->orderByDesc('total')
                ->value('total') ?? 1;

            $maxCS = \DB::table('cs_logs')
                ->selectRaw('COUNT(*) as total')
                ->whereNotNull('admin_id')
                ->groupBy('admin_id')
                ->orderByDesc('total')
                ->value('total') ?? 1;

            $maxLog = \DB::table('admin_activity_logs')
                ->selectRaw('COUNT(*) as total')
                ->whereNotNull('admin_id')
                ->groupBy('admin_id')
                ->orderByDesc('total')
                ->value('total') ?? 1;
            // ── 5. KONSISTENSI: jumlah bulan aktif upload materi ─────────
            $bulanAktif = \DB::table('lesson_items')
                ->where('admin_id', $id)
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as bulan")
                ->groupBy('bulan')
                ->count();

            $maxBulanAktif = \DB::select("
    SELECT MAX(cnt) as total FROM (
        SELECT COUNT(DISTINCT DATE_FORMAT(created_at, '%Y-%m')) as cnt
        FROM lesson_items
        WHERE admin_id IS NOT NULL
        GROUP BY admin_id
    ) as sub
")[0]->total ?? 1;
            return response()->json([
                'success' => true,
                'stats' => [
                    'total_materi' => $totalMateri,
                    'total_soal' => $totalSoal,
                    'total_cs' => $totalCS,
                    'total_bintang' => $totalBintang,
                    'rata_rating' => $rataRating,
                    'max_rating' => $maxRating,
                    'min_rating' => $minRating,
                    'distribusi_rating' => $distribusiRating,
                    'total_log' => $totalLog,
                    'materi_per_bulan' => $materiBulan,
                    'aktivitas_terbaru' => $aktivitasTerbaru,
                    'max_materi' => $maxMateri,
                    'max_soal' => $maxSoal,
                    'max_cs' => $maxCS,
                    'max_log' => $maxLog,
                    'bulan_aktif' => $bulanAktif,
                    'max_bulan_aktif' => $maxBulanAktif,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
