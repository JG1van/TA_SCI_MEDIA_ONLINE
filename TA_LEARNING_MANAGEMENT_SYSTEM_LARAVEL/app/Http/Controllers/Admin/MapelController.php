<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use Illuminate\Database\QueryException;

class MapelController extends Controller
{
    public const ALLOWED_ROLES = [1, 2, 3, 4];
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $mapels = Mapel::orderBy('id', 'desc')->get();
            return response()->json(['data' => $mapels]);
        }
        $data = Mapel::orderBy('id', 'desc')->get();
        return view('admin.mapel.index', compact('data'));
    }
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:20|unique:mapels,name',
            ],
            [
                'name.required' => 'Nama Mata Pelajaran wajib diisi.',
                'name.unique' => 'Nama Mata Pelajaran sudah digunakan, silakan pilih nama lain.',
                'name.max' => 'Nama Mata Pelajaran maksimal 20 karakter.',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        try {
            $mapel = Mapel::create([
                'name' => $request->name,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Mata Pelajaran berhasil ditambahkan.',
                'data' => $mapel
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan Mata Pelajaran: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function edit($id)
    {
        $mapel = Mapel::find($id);
        if (!$mapel) {
            return response()->json([
                'success' => false,
                'message' => 'Mata Pelajaran tidak ditemukan.',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $mapel,
        ]);
    }
    public function update(Request $request, $id)
    {
        $mapel = Mapel::find($id);
        if (!$mapel) {
            return response()->json([
                'success' => false,
                'message' => 'Mata Pelajaran tidak ditemukan.',
            ], 404);
        }
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:20|unique:mapels,name,' . $id,
            ],
            [
                'name.required' => 'Nama Mata Pelajaran wajib diisi.',
                'name.unique' => 'Nama Mata Pelajaran sudah digunakan oleh Mata Pelajaran lain.',
                'name.max' => 'Nama Mata Pelajaran maksimal 20 karakter.',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        try {
            $mapel->update(['name' => $request->name]);
            return response()->json([
                'success' => true,
                'message' => 'Mata Pelajaran berhasil diperbarui.',
                'data' => $mapel
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui Mata Pelajaran: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function destroy($id)
    {
        $mapel = Mapel::find($id);
        if (!$mapel) {
            return response()->json([
                'success' => false,
                'message' => 'Mata Pelajaran tidak ditemukan.',
            ], 404);
        }
        $relatedData = [];
        if (\App\Models\Lesson::where('mapel_id', $id)->exists()) {
            $relatedData[] = 'pelajaran';
        }
        if (\App\Models\Competence::where('mapel_id', $id)->exists()) {
            $relatedData[] = 'kompetensi';
        }
        if (\App\Models\Post::where('mapel_id', $id)->exists()) {
            $relatedData[] = 'postingan';
        }
        if (!empty($relatedData)) {
            $list = implode(', ', $relatedData);
            return response()->json([
                'success' => false,
                'message' => "Mata Pelajaran ini tidak dapat dihapus karena masih digunakan pada data: {$list}.",
            ], 409);
        }
        try {
            $mapel->delete();
            return response()->json([
                'success' => true,
                'message' => 'Mata Pelajaran berhasil dihapus.',
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json([
                    'success' => false,
                    'message' => 'Mata Pelajaran tidak dapat dihapus karena masih terhubung dengan data lain.',
                ], 409);
            }
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus Mata Pelajaran: ' . $e->getMessage(),
            ], 500);
        }
    }
}
