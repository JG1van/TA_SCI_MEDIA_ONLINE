<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\ExerciseType;
use App\Models\Serial;

class ExerciseController extends Controller
{
    public const ALLOWED_ROLES = [1, 2, 4];
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(Request $request, $lesson_id)
    {
        $lesson = Lesson::find($lesson_id);
        if (!$lesson) {
            return response()->json([
                'success' => false,
                'message' => 'Pelajaran tidak ditemukan.',
            ], 404);
        }
        if ($request->ajax()) {
            $data = Exercise::with(['exercise_type', 'serial', 'lesson'])
                ->where('lesson_id', $lesson_id)
                ->orderBy('id', 'asc')
                ->get();
            return response()->json(['success' => true, 'data' => $data]);
        }
        $data = Exercise::with(['exercise_type', 'serial'])
            ->where('lesson_id', $lesson_id)
            ->orderBy('id', 'asc')
            ->get();
        $types = ExerciseType::orderBy('id', 'asc')->get();
        $serials = Serial::orderBy('id', 'asc')->get();
        return view('admin.pelajaran.judul_soal', compact('lesson', 'data', 'types', 'serials'));
    }
    public function store(Request $request, $lesson_id)
    {
        try {
            $validator = \Validator::make(
                $request->all(),
                [
                    'exercise_type_id' => 'required|exists:exercise_types,id',
                    'title' => 'required|string|max:200|unique:exercises,title',
                    'serial_id' => 'nullable|exists:serials,id',
                    'time_limit' => 'nullable|integer|min:1|max:999',
                ],
                [
                    'exercise_type_id.required' => 'Tipe soal wajib dipilih.',
                    'exercise_type_id.exists' => 'Tipe soal tidak ditemukan.',
                    'title.required' => 'Judul soal wajib diisi.',
                    'title.unique' => 'Judul soal sudah digunakan, silakan pilih judul lain.',
                    'title.max' => 'Judul soal maksimal 200 karakter.',
                    'serial_id.exists' => 'Serial tidak valid.',
                    'time_limit.integer' => 'Waktu pengerjaan harus berupa angka.',
                    'time_limit.min' => 'Waktu pengerjaan minimal 1 menit.',
                    'time_limit.max' => 'Waktu pengerjaan maksimal 999 menit.',
                ]
            );
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }
            $exercise = Exercise::create([
                'lesson_id' => $lesson_id,
                'exercise_type_id' => $request->exercise_type_id,
                'serial_id' => $request->serial_id,
                'title' => $request->title,
                'time_limit' => $request->time_limit,
                'is_admin' => 1,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil ditambahkan.',
                'data' => $exercise,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan soal: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function edit($lesson_id, $id)
    {
        $exercise = Exercise::with(['exercise_type', 'serial'])->where('lesson_id', $lesson_id)->find($id);
        if (!$exercise) {
            return response()->json([
                'success' => false,
                'message' => 'Soal tidak ditemukan.',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $exercise,
        ]);
    }
    public function update(Request $request, $lesson_id, $id)
    {
        $exercise = Exercise::where('lesson_id', $lesson_id)->find($id);
        if (!$exercise) {
            return response()->json([
                'success' => false,
                'message' => 'Soal tidak ditemukan.',
            ], 404);
        }
        $validator = \Validator::make(
            $request->all(),
            [
                'exercise_type_id' => 'required|exists:exercise_types,id',
                'title' => 'required|string|max:200|unique:exercises,title,' . $id,
                'serial_id' => 'nullable|exists:serials,id',
                'time_limit' => 'nullable|integer|min:1|max:999',
            ],
            [
                'exercise_type_id.required' => 'Tipe soal wajib dipilih.',
                'exercise_type_id.exists' => 'Tipe soal tidak ditemukan.',
                'title.required' => 'Judul soal wajib diisi.',
                'title.unique' => 'Judul soal sudah digunakan oleh soal lain.',
                'title.max' => 'Judul soal maksimal 200 karakter.',
                'serial_id.exists' => 'Serial tidak valid.',
                'time_limit.integer' => 'Waktu pengerjaan harus berupa angka.',
                'time_limit.min' => 'Waktu pengerjaan minimal 1 menit.',
                'time_limit.max' => 'Waktu pengerjaan maksimal 999 menit.',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        try {
            $exercise->update($request->only([
                'exercise_type_id',
                'title',
                'serial_id',
                'time_limit',
            ]));
            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil diperbarui.',
                'data' => $exercise,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui soal: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function destroy($lesson_id, $id)
    {
        $exercise = Exercise::where('lesson_id', $lesson_id)->find($id);
        if (!$exercise) {
            return response()->json([
                'success' => false,
                'message' => 'Soal tidak ditemukan.',
            ], 404);
        }
        try {
            $exercise->delete();
            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil dihapus.',
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json([
                    'success' => false,
                    'message' => 'Soal tidak dapat dihapus karena masih terhubung dengan data lain.',
                ], 409);
            }
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus soal: ' . $e->getMessage(),
            ], 500);
        }
    }
}
