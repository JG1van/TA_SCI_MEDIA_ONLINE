<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public const ALLOWED_ROLES = [1, 2, 3, 4, 5];
    public function index()
    {
        $totalGuru = DB::table('users')->count();
        $totalSiswa = DB::table('students')->count();
        $totalMapel = DB::table('mapels')->count();
        $totalProduk = DB::table('products')->count();
        $totalKelas = DB::table('classrooms')->count();
        $totalSerial = DB::table('serials')->count();
        $totalMateri = DB::table('lessons')->count();
        $materiPerMapel = DB::table('lessons')
            ->join('mapels', 'lessons.mapel_id', '=', 'mapels.id')
            ->select('mapels.name as mapel', DB::raw('COUNT(lessons.id) as total'))
            ->groupBy('mapels.name')
            ->orderByDesc('total')
            ->get();
        $siswaPerKelas = DB::table('students')
            ->join('classrooms', 'students.classroom_id', '=', 'classrooms.id')
            ->select('classrooms.name as kelas', DB::raw('COUNT(students.id) as total'))
            ->groupBy('classrooms.name')
            ->orderByDesc('total')
            ->get();
        $now = Carbon::now();
        $thisMonth = $now->month;
        $thisYear = $now->year;
        $rooms = DB::table('cs_rooms')->count();
        $logs = DB::table('cs_logs')->count();
        $totalRooms = $rooms + $logs;
        $roomsThisMonth = DB::table('cs_rooms')
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $logsThisMonth = DB::table('cs_logs')
            ->whereMonth('completion_time', $thisMonth)
            ->whereYear('completion_time', $thisYear)
            ->count();
        $totalRoomsThisMonth = $roomsThisMonth + $logsThisMonth;
        $totalActiveCategories = DB::table('question_categories')
            ->where('category_status', 'Aktif')
            ->count();
        $totalUnanswered = DB::table('unanswered_questions')->count();
        $rooms = DB::table('cs_rooms')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"))
            ->where('created_at', '>=', Carbon::now()->subYear());
        $logs = DB::table('cs_logs')
            ->select(DB::raw("DATE_FORMAT(completion_time, '%Y-%m') as month"))
            ->where('completion_time', '>=', Carbon::now()->subYear());
        $trendChart = DB::query()
            ->fromSub(
                $rooms->unionAll($logs),
                'combined'
            )
            ->select('month', DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $resolutionChart = DB::table('cs_logs')
            ->select('resolution_by', DB::raw('COUNT(*) as total'))
            ->groupBy('resolution_by')
            ->get();
        $topCategories = DB::table(function ($query) {
            $query->select('question_categories_id')
                ->from('cs_rooms')
                ->whereNotNull('question_categories_id')
                ->unionAll(
                    DB::table('cs_logs')
                        ->select('question_categories_id')
                        ->whereNotNull('question_categories_id')
                );
        }, 'combined')
            ->join('question_categories', 'combined.question_categories_id', '=', 'question_categories.id')
            ->select('question_categories.name', DB::raw('COUNT(*) as total'))
            ->groupBy('question_categories.id', 'question_categories.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        $topUnanswered = DB::table('unanswered_questions')
            ->select('keyword', 'count')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
        $notes = DB::table('cs_logs')
            ->whereNotNull('notes')
            ->pluck('notes');
        $topPelaporWords = $this->analyzePelaporWords($notes);
        return view('admin.dashboard', compact(
            'totalGuru',
            'totalSiswa',
            'totalMapel',
            'totalProduk',
            'totalKelas',
            'totalSerial',
            'totalMateri',
            'materiPerMapel',
            'siswaPerKelas',
            'totalRooms',
            'totalRoomsThisMonth',
            'totalActiveCategories',
            'totalUnanswered',
            'trendChart',
            'resolutionChart',
            'topCategories',
            'topUnanswered',
            'topPelaporWords'
        ));
    }
    private function analyzePelaporWords($notesCollection)
    {
        $path = storage_path('app/stopwords/id.stopwords.txt');
        $stopwords = file_exists($path)
            ? array_map('trim', file($path))
            : [];
        $allText = '';
        foreach ($notesCollection as $note) {
            if (!$note)
                continue;
            $note = str_replace('<br>', "\n", $note);
            $lines = explode("\n", $note);
            foreach ($lines as $line) {
                if (strpos($line, 'Pelanggan:') !== false) {
                    $text = explode('Pelanggan:', $line)[1] ?? '';
                    $allText .= ' ' . trim($text);
                }
            }
        }
        $allText = strtolower($allText);
        $allText = preg_replace('/[^a-z0-9\s]/', '', $allText);
        $words = explode(' ', $allText);
        $freq = [];
        foreach ($words as $word) {
            if (strlen($word) > 3 && !in_array($word, $stopwords)) {
                $freq[$word] = ($freq[$word] ?? 0) + 1;
            }
        }
        arsort($freq);
        return array_slice($freq, 0, 50, true);
    }
}
