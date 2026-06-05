@extends('admin.layouts.app')

@section('title', 'Pengaturan')
@section('page_title', 'Pengaturan')
<style>
    .setting-card {
        min-height: 250px;
        /* silakan sesuaikan */
        display: flex;
        flex-direction: column;
    }

    .setting-card .card-body {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .setting-card .btn,
    .setting-card form {
        margin-top: auto;
    }
</style>
@section('content')

    @php
        // Role user
        $role = $userRole ?? (Auth::user()->role ?? 0);

        // Fungsi helper disable
        if (!function_exists('btnDisable')) {
            function btnDisable($role, $allowed)
            {
                $isDisabled = !in_array($role, $allowed);

                return [
                    'style' => $isDisabled ? 'cursor:not-allowed; opacity:0.5;' : '',
                    'class' => $isDisabled ? 'disabled' : '',
                ];
            }
        }
    @endphp


    <div class="row g-4">

        {{-- PROFIL AKUN --}}
        <div class="col-md-12">
            <div class="card shadow text-center setting-card">
                <div class="card-body">
                    {{-- Biru (primary) --}}
                    <i class="fas fa-user-circle fs-1 mb-3 text-primary"></i>
                    <h5 class="fw-bold">Profil Akun</h5>
                    <p class="text-muted mb-3">Lihat dan perbarui informasi akun Anda</p>
                    <a href="{{ route('admin.profil.index') }}" class="btn btn-primary w-100">
                        Pilih
                    </a>
                </div>
            </div>
        </div>

        {{-- MANAJEMEN ADMIN --}}
        @php $btn = btnDisable($role, [1]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card" style="{{ $btn['style'] }}">
                <div class="card-body">
                    {{-- Ungu --}}
                    <i class="fas fa-users-cog fs-1 mb-3" style="color:#6f42c1;"></i>
                    <h5 class="fw-bold">Manajemen Admin</h5>
                    <p class="text-muted mb-3">Kelola akun admin & role lainnya</p>
                    <a href="{{ route('admin.admin.index') }}" class="btn btn-primary w-100 {{ $btn['class'] }}">Pilih</a>
                </div>
            </div>
        </div>

        {{-- MANAJEMEN KELAS --}}
        @php $btn = btnDisable($role, [1,2,3,5]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card" style="{{ $btn['style'] }}">
                <div class="card-body">
                    {{-- Hijau (success) --}}
                    <i class="bi bi-people-fill fs-1 mb-3 text-success"></i>
                    <h5 class="fw-bold">Manajemen Kelas</h5>
                    <p class="text-muted mb-3">Kelola data kelas dan siswa</p>
                    <a href="{{ route('admin.kelas.index') }}" class="btn btn-primary w-100 {{ $btn['class'] }}">Pilih</a>
                </div>
            </div>
        </div>

        {{-- MANAJEMEN SISWA --}}
        {{-- fa-children diganti fa-child agar lebih kompatibel & tidak aneh --}}
        @php $btn = btnDisable($role, [1,2,3,5]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card" style="{{ $btn['style'] }}">
                <div class="card-body">
                    {{-- Kuning (warning) --}}
                    <i class="fas fa-child fs-1 mb-3 text-warning"></i>
                    <h5 class="fw-bold">Manajemen Siswa</h5>
                    <p class="text-muted mb-3">Kelola data akun siswa</p>
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-primary w-100 {{ $btn['class'] }}">Pilih</a>
                </div>
            </div>
        </div>

        {{-- TIPE SOAL --}}
        @php $btn = btnDisable($role, [1,2,4]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card" style="{{ $btn['style'] }}">
                <div class="card-body">
                    {{-- Merah gelap / Crimson --}}
                    <i class="fas fa-brain fs-1 mb-3" style="color:#c0392b;"></i>
                    <h5 class="fw-bold">Tipe Soal</h5>
                    <p class="text-muted mb-3">Kelola tipe soal</p>
                    <a href="{{ route('admin.pra-soal.tipe.index') }}"
                        class="btn btn-primary w-100 {{ $btn['class'] }}">Pilih</a>
                </div>
            </div>
        </div>

        {{-- MODEL SOAL --}}
        @php $btn = btnDisable($role, [1,2,4]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card" style="{{ $btn['style'] }}">
                <div class="card-body">
                    {{-- Teal --}}
                    <i class="fas fa-shapes fs-1 mb-3" style="color:#20c997;"></i>
                    <h5 class="fw-bold">Model Soal</h5>
                    <p class="text-muted mb-3">Kelola model soal</p>
                    <a href="{{ route('admin.pra-soal.model.index') }}"
                        class="btn btn-primary w-100 {{ $btn['class'] }}">Pilih</a>
                </div>
            </div>
        </div>

        {{-- KATEGORI Pertanyaan --}}
        @php $btn = btnDisable($role, [1,2,5]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card" style="{{ $btn['style'] }}">
                <div class="card-body">
                    {{-- Oranye --}}
                    <i class="fas fa-list-alt fs-1 mb-3" style="color:#fd7e14;"></i>
                    <h5 class="fw-bold">Kategori Pertanyaan</h5>
                    <p class="text-muted mb-3">Kelola daftar kategori Pertanyaan</p>
                    <a href="{{ route('admin.kategori-pertanyaan.index') }}"
                        class="btn btn-primary w-100 {{ $btn['class'] }}">Pilih</a>
                </div>
            </div>
        </div>

        {{-- PERTANYAAN TIDAK TERJAWAB --}}
        {{-- @php $btn = btnDisable($role, [1,2,5]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card h-100" style="{{ $btn['style'] }}">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="mb-3"> <i class="fas fa-question-circle fs-1" style="color:#d63384;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Pertanyaan Tidak Terjawab</h5>
                        <p class="text-muted mb-4">
                            Kelola daftar pertanyaan belum memiliki jawaban
                        </p>
                    </div>
                    <a href="{{ route('admin.pertanyaan-tidak-terjawab.index') }}"
                        class="btn btn-primary w-100 {{ $btn['class'] }}">
                        Pilih
                    </a>
                </div>
            </div>
        </div> --}}

        {{-- INFORMASI SERVER --}}
        @php $btn = btnDisable($role, [1,2,3,4,5]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card" style="{{ $btn['style'] }}">
                <div class="card-body">
                    <i class="fas fa-server fs-1 mb-3 text-info"></i>
                    <h5 class="fw-bold">Informasi Server</h5>
                    <p class="text-muted mb-3">Pantau kondisi dan status server saat ini</p>

                    <button class="btn btn-primary w-100 {{ $btn['class'] }}" data-bs-toggle="modal"
                        data-bs-target="#memoryModal" {{ $btn['class'] ? 'disabled' : '' }}>
                        Pilih
                    </button>
                </div>
            </div>
        </div>

        {{-- RIWAYAT AKTIVITAS --}}
        {{-- @php $btn = btnDisable($role, [1,2,3,4,5]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card" style="{{ $btn['style'] }}">
                <div class="card-body">
                    <i class="fas fa-history fs-1 mb-3 text-secondary"></i>
                    <h5 class="fw-bold">Riwayat Aktivitas</h5>
                    <p class="text-muted mb-3">Lihat aktivitas admin terbaru</p>

                    <button class="btn btn-primary w-100 {{ $btn['class'] }}" data-bs-toggle="modal"
                        data-bs-target="#activityModal" {{ $btn['class'] ? 'disabled' : '' }}>
                        Pilih
                    </button>
                </div>
            </div>
        </div> --}}

        {{-- BACKUP & RESTORE DATABASE --}}
        {{-- @php $btn = btnDisable($role, [1]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card" style="{{ $btn['style'] }}">
                <div class="card-body">
                    <i class="fas fa-database fs-1 mb-3" style="color:#6610f2;"></i>
                    <h5 class="fw-bold">Backup & Restore DB</h5>
                    <p class="text-muted mb-3">Kelola backup database sistem</p>

                    <button class="btn btn-primary w-100 {{ $btn['class'] }}" data-bs-toggle="modal"
                        data-bs-target="#backupModal" {{ $btn['class'] ? 'disabled' : '' }}>
                        Pilih
                    </button>
                </div>
            </div>
        </div> --}}

        {{-- N8N AUTOMATION --}}
        @php $btn = btnDisable($role, [1,2]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card" style="{{ $btn['style'] }}">
                <div class="card-body">
                    <i class="fas fa-project-diagram fs-1 mb-3" style="color:#3d5a80;"></i>
                    <h5 class="fw-bold">N8N Automation</h5>
                    <p class="text-muted mb-3">Akses panel otomasi N8N</p>
                    <a href="https://n8n.tak-scimediaonline.my.id/" target="_blank"
                        class="btn btn-primary w-100 {{ $btn['class'] }}">
                        Pilih
                    </a>
                </div>
            </div>
        </div>

        {{-- DATABASE MANAGER --}}
        @php $btn = btnDisable($role, [1,2]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card" style="{{ $btn['style'] }}">
                <div class="card-body">
                    <i class="fas fa-database fs-1 mb-3" style="color:#795548;"></i>
                    <h5 class="fw-bold">Database Manager</h5>
                    <p class="text-muted mb-3">Akses panel manajemen database</p>
                    <a href="https://db.tak-scimediaonline.my.id/" target="_blank"
                        class="btn btn-primary w-100 {{ $btn['class'] }}">
                        Pilih
                    </a>
                </div>
            </div>
        </div>
        {{-- KELUAR --}}
        {{-- <div class="col-md-12">
            <div class="card shadow text-center setting-card border-danger">
                <div class="card-body">
                    <i class="fas fa-sign-out-alt fs-1 mb-3 text-danger"></i>
                    <h5 class="fw-bold">Keluar</h5>
                    <p class="text-muted mb-3">Logout dari sistem</p>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">
                            Keluar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div> --}}
    </div>

    {{-- MODAL RIWAYAT AKTIVITAS --}}
    @php
        use App\Models\AdminActivityLog;

        $logs = AdminActivityLog::with('admin')->latest()->take(20)->get();
    @endphp
    <div class="modal fade" id="activityModal" tabindex="-1">
        <div class="modal-dialog custom-modal modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Riwayat Aktivitas Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="table-responsive" style="max-height:500px; overflow:auto;">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Admin</th>
                                    <th>Aksi</th>
                                    <th>Model</th>
                                    <th>Deskripsi</th>
                                    <th>Waktu</th>
                                    <th>IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $log->admin->name ?? '-' }}</td>

                                        <td>
                                            @if ($log->action == 'CREATE')
                                                <span class="badge bg-success">CREATE</span>
                                            @elseif($log->action == 'UPDATE')
                                                <span class="badge bg-warning text-dark">UPDATE</span>
                                            @elseif($log->action == 'DELETE')
                                                <span class="badge bg-danger">DELETE</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $log->action }}</span>
                                            @endif
                                        </td>

                                        <td>{{ $log->model }}</td>
                                        <td class="text-start">{{ $log->description }}</td>
                                        <td>{{ $log->created_at->format('d-m-Y H:i') }}</td>
                                        <td>{{ $log->ip_address }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">Belum ada aktivitas</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
    @php
        // ───────────────────────────────────────
        // SUMBER DAYA HARDWARE
        // ───────────────────────────────────────
        $drive = '/';
        $totalSpace = disk_total_space($drive);
        $freeSpace = disk_free_space($drive);
        $totalGB = round($totalSpace / 1024 / 1024 / 1024, 2);
        $freeGB = round($freeSpace / 1024 / 1024 / 1024, 2);
        $usedGB = round($totalGB - $freeGB, 2);
        $diskPercent = round(($usedGB / $totalGB) * 100);

        $cpuLoad = sys_getloadavg();
        $cpuPercent = round(($cpuLoad[0] * 100) / (int) shell_exec('nproc'), 1);

        $ramInfo = [];
        if (file_exists('/proc/meminfo')) {
            foreach (file('/proc/meminfo') as $line) {
                [$key, $val] = explode(':', $line);
                $ramInfo[trim($key)] = (int) trim(str_replace(' kB', '', $val));
            }
            $ramTotal = round($ramInfo['MemTotal'] / 1024 / 1024, 2);
            $ramFree = round($ramInfo['MemAvailable'] / 1024 / 1024, 2);
            $ramUsed = round($ramTotal - $ramFree, 2);
            $ramPercent = round(($ramUsed / $ramTotal) * 100);
        } else {
            $ramTotal = $ramFree = $ramUsed = $ramPercent = 'N/A';
        }

        $uptime = 'N/A';
        if (file_exists('/proc/uptime')) {
            $uptimeSec = (int) explode(' ', file_get_contents('/proc/uptime'))[0];
            $days = floor($uptimeSec / 86400);
            $hours = floor(($uptimeSec % 86400) / 3600);
            $minutes = floor(($uptimeSec % 3600) / 60);
            $uptime = "{$days} hari {$hours} jam {$minutes} menit";
        }

        // ───────────────────────────────────────
        // STATUS LAYANAN
        // ───────────────────────────────────────

        // 1. Cek PM2 laravel-scheduler → aktif/tidak
        try {
            $pm2Output = shell_exec('pm2 jlist 2>/dev/null');
            $pm2Data = json_decode($pm2Output, true);
            $schedulerStatus = false;
            if (is_array($pm2Data)) {
                foreach ($pm2Data as $proc) {
                    if (($proc['name'] ?? '') === 'laravel-scheduler') {
                        $schedulerStatus = ($proc['pm2_env']['status'] ?? '') === 'online';
                        break;
                    }
                }
            }
        } catch (\Exception $e) {
            $schedulerStatus = false;
        }

        // 2. Baca jadwal dari file Kernel.php (parse regex)
        try {
            $kernelContent = file_get_contents(app_path('Console/Kernel.php'));
            preg_match_all(
                '/->command\([\'"]([^\'"]+)[\'"]\)\s*->(dailyAt\([\'"]([^\'"]+)[\'"]\)|cron\([\'"]([^\'"]+)[\'"]\)|everyMinute\(\)|hourly\(\)|daily\(\)|weekly\(\)|monthly\(\))/s',
                $kernelContent,
                $matches,
            );

            $scheduledEvents = collect();
            foreach ($matches[1] as $i => $cmd) {
                $method = $matches[2][$i];
                $timeAt = $matches[3][$i] ?? '';
                $cronExpr = $matches[4][$i] ?? '';

                if (str_starts_with($method, 'dailyAt') && $timeAt) {
                    $label = 'Setiap hari ' . $timeAt . ' WIB';
                    $expression = 'dailyAt(' . $timeAt . ')';
                } elseif (str_starts_with($method, 'cron') && $cronExpr) {
                    $label = $cronExpr;
                    $expression = $cronExpr;
                } elseif (str_starts_with($method, 'everyMinute')) {
                    $label = 'Setiap menit';
                    $expression = '* * * * *';
                } elseif (str_starts_with($method, 'hourly')) {
                    $label = 'Setiap jam';
                    $expression = '0 * * * *';
                } elseif (str_starts_with($method, 'daily')) {
                    $label = 'Setiap hari 00:00 WIB';
                    $expression = '0 0 * * *';
                } elseif (str_starts_with($method, 'weekly')) {
                    $label = 'Setiap minggu';
                    $expression = '0 0 * * 0';
                } elseif (str_starts_with($method, 'monthly')) {
                    $label = 'Setiap bulan';
                    $expression = '0 0 1 * *';
                } else {
                    $label = $method;
                    $expression = '-';
                }

                $scheduledEvents->push([
                    'command' => $cmd,
                    'expression' => $expression,
                    'label' => $label,
                ]);
            }
        } catch (\Exception $e) {
            $scheduledEvents = collect();
        }

        // 3. Database
        try {
            DB::connection()->getPdo();
            $dbStatus = true;
        } catch (\Exception $e) {
            $dbStatus = false;
        }

        // 4. N8N
        try {
            $socket = @fsockopen('127.0.0.1', 5679, $errno, $errstr, 2);
            if ($socket) {
                $n8nStatus = true;
                fclose($socket);
            } else {
                $n8nStatus = false;
            }
        } catch (\Exception $e) {
            $n8nStatus = false;
        }

        // 5. Versi software
        $nodeVersion = trim(shell_exec('node -v 2>/dev/null') ?? 'N/A');
        $phpVersion = phpversion();
        $laravelVersion = app()->version();
    @endphp

    <div class="modal fade" id="memoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg custom-modal">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-server me-2"></i>Informasi Server
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- ═══ KELOMPOK 1 · Sumber Daya Hardware ═══ --}}
                    <p class="text-uppercase fw-semibold small text-muted mb-2"
                        style="letter-spacing:.6px;border-bottom:1px solid #e5e7eb;padding-bottom:6px;">
                        Sumber Daya Hardware
                    </p>
                    <div class="row g-2 mb-3">

                        {{-- 1. Kapasitas Disk — Biru Baja --}}
                        <div class="col-4">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#E6F1FB;border:1px solid #B5D4F4;">
                                <i class="fas fa-hdd fs-4 mb-2" style="color:#0C447C;"></i>
                                <div class="small fw-semibold" style="color:#185FA5;">Kapasitas Disk</div>
                                <div class="fw-bold fs-5" style="color:#0C447C;">{{ $totalGB }} GB</div>
                            </div>
                        </div>

                        {{-- 2. Disk Terpakai — Merah Bata --}}
                        <div class="col-4">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#FAECE7;border:1px solid #F5C4B3;">
                                <i class="fas fa-database fs-4 mb-2" style="color:#993C1D;"></i>
                                <div class="small fw-semibold" style="color:#D85A30;">Disk Terpakai</div>
                                <div class="fw-bold fs-5" style="color:#993C1D;">{{ $usedGB }} GB</div>
                                <div class="progress mt-2" style="height:4px;background:#F5C4B3;">
                                    <div class="progress-bar" style="width:{{ $diskPercent }}%;background:#D85A30;">
                                    </div>
                                </div>
                                <div class="small mt-1" style="color:#993C1D;">{{ $diskPercent }}%</div>
                            </div>
                        </div>

                        {{-- 3. Disk Tersedia — Hijau Daun --}}
                        <div class="col-4">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#EAF3DE;border:1px solid #C0DD97;">
                                <i class="fas fa-hdd fs-4 mb-2" style="color:#3B6D11;"></i>
                                <div class="small fw-semibold" style="color:#639922;">Disk Tersedia</div>
                                <div class="fw-bold fs-5" style="color:#3B6D11;">{{ $freeGB }} GB</div>
                            </div>
                        </div>

                        {{-- 4. Penggunaan CPU — Kuning Amber --}}
                        <div class="col-4">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#FAEEDA;border:1px solid #FAC775;">
                                <i class="fas fa-microchip fs-4 mb-2" style="color:#854F0B;"></i>
                                <div class="small fw-semibold" style="color:#BA7517;">Penggunaan CPU</div>
                                <div class="fw-bold fs-5" style="color:#854F0B;">{{ $cpuPercent }}%</div>
                                <div class="progress mt-2" style="height:4px;background:#FAC775;">
                                    <div class="progress-bar" style="width:{{ $cpuPercent }}%;background:#BA7517;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 5. Penggunaan RAM — Ungu Lavender --}}
                        <div class="col-4">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#EEEDFE;border:1px solid #CECBF6;">
                                <i class="fas fa-memory fs-4 mb-2" style="color:#3C3489;"></i>
                                <div class="small fw-semibold" style="color:#534AB7;">Penggunaan RAM</div>
                                <div class="fw-bold fs-5" style="color:#3C3489;">{{ $ramUsed }} /
                                    {{ $ramTotal }} GB</div>
                                <div class="progress mt-2" style="height:4px;background:#CECBF6;">
                                    <div class="progress-bar" style="width:{{ $ramPercent }}%;background:#7F77DD;">
                                    </div>
                                </div>
                                <div class="small mt-1" style="color:#3C3489;">{{ $ramPercent }}%</div>
                            </div>
                        </div>

                        {{-- 6. Lama Berjalan — Cokelat --}}
                        <div class="col-4">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#F5F0E8;border:1px solid #D4C9B0;">
                                <i class="fas fa-clock fs-4 mb-2" style="color:#6B4F1A;"></i>
                                <div class="small fw-semibold" style="color:#8B6524;">Lama Berjalan</div>
                                <div class="fw-bold fs-5" style="color:#6B4F1A;">{{ $uptime }}</div>
                            </div>
                        </div>

                    </div>

                    {{-- ═══ KELOMPOK 2 · Status Layanan ═══ --}}
                    <p class="text-uppercase fw-semibold small text-muted mb-2"
                        style="letter-spacing:.6px;border-bottom:1px solid #e5e7eb;padding-bottom:6px;">
                        Status Layanan
                    </p>
                    <div class="row g-2 mb-3">

                        {{-- 7. Penjadwal Tugas — Teal --}}
                        <div class="col-4">
                            @if ($schedulerStatus)
                                <div class="p-3 rounded-3 text-center h-100"
                                    style="background:#E0F7F4;border:1px solid #80D8CF;">
                                    <i class="fas fa-calendar-check fs-4 mb-2" style="color:#00695C;"></i>
                                    <div class="small fw-semibold mb-1" style="color:#00897B;">Penjadwal Tugas</div>
                                    @if ($scheduledEvents->isNotEmpty())
                                        @foreach ($scheduledEvents as $ev)
                                            <div class="fw-bold" style="color:#00695C;font-size:.82rem;">
                                                {{ $ev['command'] }}
                                            </div>
                                            <div class="small my-1">
                                                <code
                                                    style="background:#B2DFDB;color:#00695C;padding:1px 5px;border-radius:3px;font-size:.75rem;">
                                                    {{ $ev['label'] }}
                                                </code>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="fw-bold fs-6 mt-1" style="color:#00695C;">Aktif</div>
                                        <div class="small" style="color:#00897B;">Tidak ada jadwal terdaftar</div>
                                    @endif
                                </div>
                            @else
                                <div class="p-3 rounded-3 text-center h-100"
                                    style="background:#FCEBEB;border:1px solid #F7C1C1;">
                                    <i class="fas fa-calendar-check fs-4 mb-2" style="color:#A32D2D;"></i>
                                    <div class="small fw-semibold" style="color:#E24B4A;">Penjadwal Tugas</div>
                                    <div class="fw-bold fs-5" style="color:#A32D2D;">Tidak Aktif</div>
                                </div>
                            @endif
                        </div>

                        {{-- 8. Basis Data — Pink Rose --}}
                        <div class="col-4">
                            @if ($dbStatus)
                                <div class="p-3 rounded-3 text-center h-100"
                                    style="background:#FCE4EC;border:1px solid #F48FB1;">
                                    <i class="fas fa-database fs-4 mb-2" style="color:#880E4F;"></i>
                                    <div class="small fw-semibold" style="color:#AD1457;">Basis Data</div>
                                    <div class="fw-bold fs-5" style="color:#880E4F;">Aktif</div>
                                </div>
                            @else
                                <div class="p-3 rounded-3 text-center h-100"
                                    style="background:#FCEBEB;border:1px solid #F7C1C1;">
                                    <i class="fas fa-database fs-4 mb-2" style="color:#A32D2D;"></i>
                                    <div class="small fw-semibold" style="color:#E24B4A;">Basis Data</div>
                                    <div class="fw-bold fs-5" style="color:#A32D2D;">Tidak Aktif</div>
                                </div>
                            @endif
                        </div>

                        {{-- 9. Otomasi N8N — Biru Navy --}}
                        <div class="col-4">
                            @if ($n8nStatus)
                                <div class="p-3 rounded-3 text-center h-100"
                                    style="background:#E8EAF6;border:1px solid #9FA8DA;">
                                    <i class="fas fa-project-diagram fs-4 mb-2" style="color:#1A237E;"></i>
                                    <div class="small fw-semibold" style="color:#283593;">Otomasi N8N</div>
                                    <div class="fw-bold fs-5" style="color:#1A237E;">Aktif</div>
                                </div>
                            @else
                                <div class="p-3 rounded-3 text-center h-100"
                                    style="background:#FCEBEB;border:1px solid #F7C1C1;">
                                    <i class="fas fa-project-diagram fs-4 mb-2" style="color:#A32D2D;"></i>
                                    <div class="small fw-semibold" style="color:#E24B4A;">Otomasi N8N</div>
                                    <div class="fw-bold fs-5" style="color:#A32D2D;">Tidak Aktif</div>
                                </div>
                            @endif
                        </div>

                    </div>

                    {{-- ═══ KELOMPOK 3 · Versi Perangkat Lunak ═══ --}}
                    <p class="text-uppercase fw-semibold small text-muted mb-2"
                        style="letter-spacing:.6px;border-bottom:1px solid #e5e7eb;padding-bottom:6px;">
                        Versi Perangkat Lunak
                    </p>
                    <div class="row g-2 mb-3">

                        {{-- 10. Node.js — Hijau Emerald --}}
                        <div class="col-4">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#E8F5E9;border:1px solid #A5D6A7;">
                                <i class="fab fa-node-js fs-4 mb-2" style="color:#1B5E20;"></i>
                                <div class="small fw-semibold" style="color:#2E7D32;">Node.js</div>
                                <div class="fw-bold fs-5" style="color:#1B5E20;">{{ $nodeVersion }}</div>
                            </div>
                        </div>

                        {{-- 11. PHP — Indigo --}}
                        <div class="col-4">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#EDE7F6;border:1px solid #B39DDB;">
                                <i class="fab fa-php fs-4 mb-2" style="color:#1A0070;"></i>
                                <div class="small fw-semibold" style="color:#311B92;">PHP</div>
                                <div class="fw-bold fs-5" style="color:#1A0070;">{{ $phpVersion }}</div>
                            </div>
                        </div>

                        {{-- 12. Laravel — Oranye Merah --}}
                        <div class="col-4">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#FBE9E7;border:1px solid #FFAB91;">
                                <i class="fab fa-laravel fs-4 mb-2" style="color:#BF360C;"></i>
                                <div class="small fw-semibold" style="color:#D84315;">Laravel</div>
                                <div class="fw-bold fs-5" style="color:#BF360C;">v{{ $laravelVersion }}</div>
                            </div>
                        </div>

                    </div>

                    {{-- ═══ KELOMPOK 4 · Daftar Jadwal Tugas dari Kernel.php ═══ --}}
                    @if ($scheduledEvents->isNotEmpty())
                        <p class="text-uppercase fw-semibold small text-muted mb-2"
                            style="letter-spacing:.6px;border-bottom:1px solid #e5e7eb;padding-bottom:6px;">
                            Daftar Jadwal Tugas (dari Kernel.php)
                        </p>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0" style="font-size:.85rem;">
                                <thead>
                                    <tr style="background:#E0F7F4;">
                                        <th class="fw-semibold text-muted ps-2">Command</th>
                                        <th class="fw-semibold text-muted">Jadwal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scheduledEvents as $ev)
                                        <tr>
                                            <td class="ps-2" style="color:#00695C;font-weight:500;">
                                                <i class="fas fa-terminal me-1 small"></i>
                                                {{ $ev['command'] }}
                                            </td>
                                            <td>
                                                <code
                                                    style="background:#B2DFDB;color:#00695C;padding:2px 6px;border-radius:4px;font-size:.8rem;">
                                                    {{ $ev['label'] }}
                                                </code>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>{{-- /.modal-body --}}
            </div>
        </div>
    </div>
    {{-- MODAL BACKUP DATABASE --}}
    <div class="modal fade" id="backupModal" tabindex="-1">
        <div class="modal-dialog custom-modal modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Backup & Restore Database</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">

                    <form action="{{ route('admin.backup.create') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mb-3">
                            Backup Sekarang
                        </button>
                    </form>

                    <hr>

                    <form action="{{ route('admin.backup.restore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="sql_file" class="form-control mb-2" required>
                        <button type="submit" class="btn btn-danger w-100">
                            Restore Database
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
