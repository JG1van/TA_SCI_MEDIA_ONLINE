<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Competence;
use App\Models\Lesson;

class CompetenceController extends Controller
{
    public const ALLOWED_ROLES = [1, 2, 4];
    public function index($lesson_id)
    {
        $lesson = Lesson::with('mapel')->findOrFail($lesson_id);
        $competences = Competence::where('lesson_id', $lesson_id)->orderBy('point')->get();
        return view('admin.pelajaran.kd', compact('lesson', 'competences'));
    }
    public function store(Request $request, $lesson_id)
    {
        try {

            $validator = \Validator::make(
                $request->all(),
                [
                    'point' => 'required|string|max:20|unique:competences,point,NULL,id,lesson_id,' . $lesson_id,
                    'description' => 'required|string',
                ],
                [
                    'point.unique' => 'Kode KD sudah digunakan.',
                    'point.required' => 'Kode KD wajib diisi.',
                    'point.max' => 'Kode KD maksimal 20 karakter.',

                    'description.required' => 'Deskripsi KD wajib diisi.',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $lesson = Lesson::find($lesson_id);

            if (!$lesson) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pelajaran tidak ditemukan.',
                ], 404);
            }

            $competence = Competence::create([
                'lesson_id' => $lesson_id,
                'mapel_id' => $lesson->mapel_id,
                'point' => $request->point,
                'description' => $request->description,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kompetensi berhasil ditambahkan.',
                'data' => $competence,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kompetensi: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function edit($lesson_id, $id)
    {
        $competence = Competence::where('id', $id)
            ->where('lesson_id', $lesson_id)
            ->first();
        if (!$competence) {
            return response()->json([
                'success' => false,
                'message' => 'Kompetensi tidak ditemukan.',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $competence,
        ]);
    }
    public function update(Request $request, $lesson_id, $id)
    {
        $competence = Competence::where('id', $id)
            ->where('lesson_id', $lesson_id)
            ->first();
        if (!$competence) {
            return response()->json([
                'success' => false,
                'message' => 'Kompetensi tidak ditemukan atau tidak sesuai pelajaran.',
            ], 404);
        }
        $validator = \Validator::make(
            $request->all(),
            [
                'point' => 'required|string|max:20|unique:competences,point,' . $id . ',id,lesson_id,' . $lesson_id,
                'description' => 'required|string',
            ],
            [
                'point.unique' => 'Kode KD sudah digunakan.',
                'point.required' => 'Kode KD wajib diisi.',
                'point.max' => 'Kode KD maksimal 20 karakter.',

                'description.required' => 'Deskripsi KD wajib diisi.',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        try {
            // 🔹 Update kedua field
            $competence->update([
                'point' => $request->point,
                'description' => $request->description,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Kompetensi berhasil diperbarui.',
                'data' => $competence,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui kompetensi: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function destroy($lesson_id, $id)
    {
        $competence = Competence::where('id', $id)
            ->where('lesson_id', $lesson_id)
            ->first();
        if (!$competence) {
            return response()->json([
                'success' => false,
                'message' => 'Kompetensi tidak ditemukan.',
            ], 404);
        }    // Cek apakah kompetensi masih digunakan di tabel lain
        $relatedData = [];
        if (\App\Models\ExerciseItem::where('competence_id', $id)->exists()) {
            $relatedData[] = 'soal';
        }    // Jika masih dipakai di tabel lain
        if (!empty($relatedData)) {
            $list = implode(', ', $relatedData);
            return response()->json([
                'success' => false,
                'message' => "Kompetensi ini tidak dapat dihapus karena masih terhubung dengan data: {$list}.",
            ], 409);
        }
        try {
            $competence->delete();
            return response()->json([
                'success' => true,
                'message' => 'Kompetensi berhasil dihapus.',
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json([
                    'success' => false,
                    'message' => 'Kompetensi tidak dapat dihapus karena masih terhubung dengan data lain.',
                ], 409);
            }
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kompetensi: ' . $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

}
