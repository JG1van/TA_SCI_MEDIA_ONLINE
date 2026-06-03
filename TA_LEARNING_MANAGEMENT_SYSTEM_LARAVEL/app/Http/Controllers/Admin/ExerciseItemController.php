<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExerciseItem;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Competence;
use App\Models\ExerciseModel;
use App\Models\ExerciseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ExerciseItemController extends Controller
{
    public const ALLOWED_ROLES = [1, 2, 3, 4];
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index($lesson_id, $exercise_id)
    {
        $competences = Competence::where('lesson_id', $lesson_id)->get();
        $lesson = Lesson::find($lesson_id);
        $exercise = Exercise::find($exercise_id);
        if (!$lesson || !$exercise) {
            return redirect()->back()->with('error', 'Data pelajaran atau soal tidak ditemukan.');
        }
        $exerciseItems = ExerciseItem::with(['competence', 'admin', 'user'])
            ->where('exercise_id', $exercise_id)
            ->orderBy('id', 'asc')
            ->get();
        $exerciseModels = \App\Models\ExerciseModel::all();
        return view('admin.pelajaran.soal_index', compact(
            'lesson',
            'exercise',
            'competences',
            'exerciseItems',
            'exerciseModels'
        ));
    }
    public function create($lesson_id, $exercise_id)
    {
        $exercise = Exercise::findOrFail($exercise_id);
        $competences = Competence::where('lesson_id', $lesson_id)->get();
        $models = ExerciseModel::all();
        $exerciseType = \App\Models\ExerciseType::find($exercise->exercise_type_id);
        return view('admin.pelajaran.soal_create', [
            'lesson_id' => $lesson_id,
            'exercise_id' => $exercise_id,
            'exercise_type_id' => $exercise->exercise_type_id ?? null,
            'exerciseType' => $exerciseType,
            'competences' => $competences,
            'models' => $models,
        ]);
    }
    public function store(Request $request, $lesson_id, $exercise_id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'question' => 'required|string',
                'selection' => 'nullable',
                'answer' => 'required',
                'exercise_model_id' => 'required|integer|exists:exercise_models,id',
                'competence_id' => 'nullable|integer|exists:competences,id',
            ],
            [
                'question.required' => 'Pertanyaan wajib diisi.',
                'answer.required' => 'Jawaban wajib diisi.',
                'exercise_model_id.required' => 'Model soal wajib dipilih.',
                'exercise_model_id.exists' => 'Model soal tidak valid.',
                'competence_id.exists' => 'Kompetensi tidak ditemukan.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', $validator->errors()->first())
                ->withInput();
        }
        try {
            DB::transaction(function () use ($request, $lesson_id, $exercise_id) {
                $exercise = Exercise::findOrFail($exercise_id);
                $lastNumber = ExerciseItem::where('exercise_id', $exercise_id)
                    ->lockForUpdate()
                    ->max('exercise_number') ?? 0;
                $selection = $request->input('selection');
                if (is_string($selection)) {
                    $decoded = json_decode($selection, true);
                    $selection = is_array($decoded) ? json_encode($decoded) : json_encode([]);
                } elseif (is_array($selection)) {
                    $selection = json_encode($selection);
                } else {
                    $selection = json_encode([]);
                }
                $answer = $request->input('answer');
                if (is_array($answer)) {
                    $answer = json_encode($answer);
                } else {
                    $answer = json_encode([$answer]);
                }
                $hasSelection = !empty($request->input('selection')) && $request->input('selection') !== '[]';
                ExerciseItem::create([
                    'admin_id' => auth()->id() ?? 1,
                    'user_id' => null,
                    'lesson_id' => $lesson_id,
                    'exercise_id' => $exercise_id,
                    'exercise_type_id' => $exercise->exercise_type_id ?? ($request->input('exercise_type_id') ?? 1),
                    'exercise_model_id' => $request->input('exercise_model_id'),
                    'competence_id' => $request->input('competence_id'),
                    'exercise_choice' => $hasSelection ? 1 : 0,
                    'exercise_number' => $lastNumber + 1,
                    'question' => $request->input('question'),
                    'selection' => $selection,
                    'answer' => $answer,
                    'is_user' => $request->input('is_user') ?? 0,
                ]);
            });
            return redirect()->route('admin.pelajaran.judul_soal.soal.index', [
                'lesson_id' => $lesson_id,
                'exercise_id' => $exercise_id,
            ])->with('success', 'Soal berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan soal: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function edit($lesson_id, $exercise_id, $soal_id)
    {
        $lesson = Lesson::find($lesson_id);
        $exercise = Exercise::find($exercise_id);
        if (!$lesson || !$exercise) {
            return redirect()->back()->with('error', 'Data pelajaran atau soal tidak ditemukan.');
        }
        $item = ExerciseItem::with(['competence', 'admin', 'user'])
            ->findOrFail($soal_id);
        $competences = Competence::where('lesson_id', $lesson_id)->get();
        $models = ExerciseModel::all();
        $exerciseType = \App\Models\ExerciseType::find($exercise->exercise_type_id);
        if (is_string($item->selection) && $item->selection !== '') {
            $decoded = json_decode($item->selection, true);
            $item->selection = is_array($decoded) ? $decoded : [];
        } elseif (is_null($item->selection)) {
            $item->selection = [];
        }
        if (is_string($item->answer) && $item->answer !== '') {
            $decAns = json_decode($item->answer, true);
            $item->answer = is_array($decAns) ? $decAns : [$item->answer];
        } elseif (is_null($item->answer)) {
            $item->answer = [];
        }
        return view('admin.pelajaran.soal_edit', compact(
            'lesson',
            'exercise',
            'item',
            'competences',
            'models',
            'exerciseType'
        ));
    }
    public function update(Request $request, $lesson_id, $exercise_id, $soal_id)
    {
        $item = ExerciseItem::find($soal_id);
        if (!$item) {
            return redirect()->back()->with('error', 'Soal tidak ditemukan.');
        }
        $validator = Validator::make(
            $request->all(),
            [
                'question' => 'required|string',
                'selection' => 'nullable',
                'answer' => 'required',
                'exercise_model_id' => 'required|integer|exists:exercise_models,id',
                'competence_id' => 'nullable|integer|exists:competences,id',
                'exercise_number' => 'required|integer|min:1',
            ],
            [
                'question.required' => 'Pertanyaan wajib diisi.',
                'answer.required' => 'Jawaban wajib diisi.',
                'exercise_model_id.required' => 'Model soal wajib dipilih.',
                'exercise_number.required' => 'Nomor soal wajib diisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', $validator->errors()->first())
                ->withInput();
        }
        try {
            DB::transaction(function () use ($request, $item) {
                $selection = $request->input('selection');
                if (is_string($selection)) {
                    $decoded = json_decode($selection, true);
                    $selection = is_array($decoded) ? json_encode($decoded) : json_encode([]);
                } elseif (is_array($selection)) {
                    $selection = json_encode($selection);
                } else {
                    $selection = json_encode([]);
                }

                $answer = $request->input('answer');
                if (is_array($answer)) {
                    $answer = json_encode($answer);
                } else {
                    $answer = json_encode([$answer]);
                }

                // Hapus gambar lama yang tidak ada di konten baru
                preg_match_all('/storage\/soal\/([^\s"]+)/', $item->question, $oldMatches);
                $oldFiles = $oldMatches[1] ?? [];

                preg_match_all('/storage\/soal\/([^\s"]+)/', $request->question, $newMatches);
                $newFiles = $newMatches[1] ?? [];

                foreach (array_diff($oldFiles, $newFiles) as $filename) {
                    \Storage::disk('public')->delete('soal/' . $filename);
                }

                $item->question = $request->question;
                $item->selection = $selection;
                $item->answer = $answer;
                $item->exercise_model_id = $request->exercise_model_id;
                $item->exercise_number = $request->exercise_number;
                $item->exercise_choice = !empty($selection) ? 1 : 0;
                $item->admin_id = auth()->id();
                $item->competence_id = $request->filled('competence_id')
                    ? $request->competence_id
                    : null;
                $item->save();
            });
            return redirect()->route('admin.pelajaran.judul_soal.soal.index', [
                'lesson_id' => $lesson_id,
                'exercise_id' => $exercise_id,
            ])->with('success', 'Soal berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui soal: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function destroy($lesson_id, $exercise_id, $soal_id)
    {
        $item = ExerciseItem::find($soal_id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Soal tidak ditemukan.',
            ]);
        }
        try {
            $item->delete();
            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil dihapus.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus soal: ' . $e->getMessage(),
            ]);
        }
    }
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $name = time() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs('soal', $name, 'public');

            return response()->json([
                'url' => url('storage/' . $path)  // ← ganti ini saja
            ]);
        }

        return response()->json([
            'error' => 'Upload gagal'
        ], 400);
    }
}
