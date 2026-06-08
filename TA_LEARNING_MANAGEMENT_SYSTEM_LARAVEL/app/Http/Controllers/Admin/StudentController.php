<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Serial;
use Illuminate\Support\Facades\Storage;
class StudentController extends Controller
{
    public const ALLOWED_ROLES = [1, 2, 3, 5];
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $students = \App\Models\Student::orderBy('id', 'desc')->get();
            return response()->json(['data' => $students]);
        }
        $students = \App\Models\Student::orderBy('id', 'desc')->get();
        $classrooms = \App\Models\Classroom::with(['serial.user'])->orderBy('name', 'desc')->get();
        return view('admin.siswa.index', compact('students', 'classrooms'));
    }
    public function create(Request $request)
    {
        $classroomId = $request->query('classroom_id');
        if ($classroomId) {
            $classroom = Classroom::with(['serial.user'])->find($classroomId);
            if (!$classroom) {
                return redirect()->route('siswa.index')->with('error', 'Kelas tidak ditemukan.');
            }
            $students = Student::where('classroom_id', $classroom->id)
                ->orderBy('id', 'desc')
                ->get();
            return view('admin.siswa.create', compact('classroom', 'students'));
        }
        $classrooms = Classroom::with(['serial.user'])->orderBy('id', 'desc')->get();
        $students = collect();
        return view('admin.siswa.create', compact('classrooms', 'students'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'serial_id' => 'required|integer',
            'user_id' => 'required|integer',
            'classroom_id' => 'required|integer',
            'name' => 'required|string|max:200',
            'username' => 'required|string|max:100|unique:students,username',
            'nis' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
        ], [
            'serial_id.required' => 'Serial wajib diisi.',
            'user_id.required' => 'User wajib diisi.',
            'classroom_id.required' => 'Kelas wajib diisi.',
            'name.required' => 'Nama siswa wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {

            // 🔥 CEK JUMLAH SISWA DALAM KELAS
            $totalSiswa = Student::where('classroom_id', $request->classroom_id)->count();

            if ($totalSiswa >= 45) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah siswa dalam kelas sudah mencapai batas maksimal (45 siswa).'
                ], 409);
            }

            $defaultPassword = 'Siswa1234';

            $student = Student::create([
                'serial_id' => $request->serial_id,
                'user_id' => $request->user_id,
                'classroom_id' => $request->classroom_id,
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($defaultPassword),
                'nis' => $request->nis,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil ditambahkan.',
                'data' => $student
            ]);

        } catch (\Exception $e) {

            \Log::error('Create Student Error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan siswa.'
            ], 500);
        }
    }
    public function edit($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan.'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $student
        ]);
    }


    public function update(Request $request, $id)
    {
        try {
            $student = Student::findOrFail($id);

            $request->validate([
                'serial_id' => 'required|integer',
                'user_id' => 'required|integer',
                'classroom_id' => 'required|integer',
                'name' => 'required|string|max:200',
                'username' => 'required|string|max:100|unique:students,username,' . $id,
                'nis' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:100',
                'phone' => 'nullable|string|max:20',

                // ✅ TAMBAHAN
                'absen_number' => 'nullable|integer',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $student->update([
                'serial_id' => $request->serial_id,
                'user_id' => $request->user_id,
                'classroom_id' => $request->classroom_id,
                'name' => $request->name,
                'username' => $request->username,
                'nis' => $request->nis,
                'email' => $request->email,
                'phone' => $request->phone,

                // ✅ TAMBAHAN
                'absen_number' => $request->absen_number,
            ]);

            // ✅ HANDLE PHOTO (upload + replace lama)
            if ($request->hasFile('photo')) {
                // hapus foto lama jika ada
                if ($student->photo && Storage::disk('public')->exists('students/' . $student->photo)) {
                    Storage::disk('public')->delete('students/' . $student->photo);
                }

                // simpan foto baru
                $path = $request->file('photo')->store('students', 'public');
                $student->photo = basename($path);
                $student->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil diperbarui.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui siswa: ' . $e->getMessage()
            ], 500);
        }
    }
    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan.'
            ], 404);
        }
        $relatedData = [];
        if (\App\Models\Report::where('student_id', $id)->exists()) {
            $relatedData[] = 'laporan';
        }
        if (\App\Models\Task::where('student_id', $id)->exists()) {
            $relatedData[] = 'tugas';
        }
        if (\App\Models\ExercisePoint::where('student_id', $id)->exists()) {
            $relatedData[] = 'nilai soal';
        }
        if (!empty($relatedData)) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak dapat dihapus karena masih terkait dengan: ' . implode(', ', $relatedData)
            ], 409);
        }
        try {
            $student->delete();
            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus siswa: ' . $e->getMessage()
            ], 500);
        }
    }
    public function resetPassword($id)
    {
        try {
            $student = Student::findOrFail($id);
            $newPassword = 'Siswa1234';
            $student->update([
                'password' => Hash::make($newPassword),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Password berhasil direset ke: ' . $newPassword,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal reset password: ' . $e->getMessage(),
            ]);
        }
    }


}

