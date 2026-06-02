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
        @php $btn = btnDisable($role, [1,2,3]); @endphp
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
        @php $btn = btnDisable($role, [1,2,3]); @endphp
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
    {{-- MODAL SISA MEMORI --}}
    @php
        $drive = '/';
        $totalSpace = disk_total_space($drive);
        $freeSpace = disk_free_space($drive);
        $totalGB = round($totalSpace / 1024 / 1024 / 1024, 2);
        $freeGB = round($freeSpace / 1024 / 1024 / 1024, 2);
        $usedGB = round($totalGB - $freeGB, 2);
        $diskPercent = round(($usedGB / $totalGB) * 100);

        // Penggunaan CPU
        $cpuLoad = sys_getloadavg();
        $cpuPercent = round(($cpuLoad[0] * 100) / (int) shell_exec('nproc'), 1);

        // Penggunaan RAM
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

        // Lama Berjalan
        $uptime = 'N/A';
        if (file_exists('/proc/uptime')) {
            $uptimeSec = (int) explode(' ', file_get_contents('/proc/uptime'))[0];
            $days = floor($uptimeSec / 86400);
            $hours = floor(($uptimeSec % 86400) / 3600);
            $minutes = floor(($uptimeSec % 3600) / 60);
            $uptime = "{$days} hari {$hours} jam {$minutes} menit";
        }

        // Versi Node.js
        $nodeVersion = trim(shell_exec('node -v 2>/dev/null') ?? 'N/A');

        // Status Penjadwal Laravel
        try {
            $schedulerOutput = shell_exec('pm2 jlist 2>/dev/null');
            $schedulerData = json_decode($schedulerOutput, true);
            $schedulerStatus = false;
            if (is_array($schedulerData)) {
                foreach ($schedulerData as $proc) {
                    if (isset($proc['name']) && $proc['name'] === 'laravel-scheduler') {
                        $schedulerStatus = ($proc['pm2_env']['status'] ?? '') === 'online';
                        break;
                    }
                }
            }
        } catch (\Exception $e) {
            $schedulerStatus = false;
        }

        // Status Basis Data
        try {
            DB::connection()->getPdo();
            $dbStatus = true;
        } catch (\Exception $e) {
            $dbStatus = false;
        }

        // Status Otomasi N8N
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

        // Versi PHP & Laravel
        $phpVersion = phpversion();
        $laravelVersion = app()->version();
    @endphp

    <div class="modal fade" id="memoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg custom-modal">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-server me-2"></i>Informasi Server</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        {{-- BARIS 1: Hardware Server --}}

                        {{-- 1. Kapasitas Disk --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#f0f4ff;border:1px solid #d0d9ff;">
                                <i class="fas fa-hdd fs-4 mb-2 text-primary"></i>
                                <div class="small text-muted fw-semibold">Kapasitas Disk</div>
                                <div class="fw-bold fs-5 text-primary">{{ $totalGB }} GB</div>
                            </div>
                        </div>

                        {{-- 2. Disk Terpakai --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#fff4f4;border:1px solid #ffd0d0;">
                                <i class="fas fa-database fs-4 mb-2 text-danger"></i>
                                <div class="small text-muted fw-semibold">Disk Terpakai</div>
                                <div class="fw-bold fs-5 text-danger">{{ $usedGB }} GB</div>
                                <div class="progress mt-2" style="height:5px;">
                                    <div class="progress-bar bg-danger" style="width:{{ $diskPercent }}%"></div>
                                </div>
                                <div class="small text-muted mt-1">{{ $diskPercent }}%</div>
                            </div>
                        </div>

                        {{-- 3. Disk Tersedia --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#f0fff8;border:1px solid #b6f0d8;">
                                <i class="fas fa-hdd fs-4 mb-2 text-success"></i>
                                <div class="small text-muted fw-semibold">Disk Tersedia</div>
                                <div class="fw-bold fs-5 text-success">{{ $freeGB }} GB</div>
                            </div>
                        </div>

                        {{-- 4. Penggunaan CPU --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#fffbf0;border:1px solid #ffe5a0;">
                                <i class="fas fa-microchip fs-4 mb-2 text-warning"></i>
                                <div class="small text-muted fw-semibold">Penggunaan CPU</div>
                                <div class="fw-bold fs-5 text-warning">{{ $cpuPercent }}%</div>
                                <div class="progress mt-2" style="height:5px;">
                                    <div class="progress-bar bg-warning" style="width:{{ $cpuPercent }}%"></div>
                                </div>
                            </div>
                        </div>

                        {{-- BARIS 2: Kondisi Server --}}

                        {{-- 5. Penggunaan RAM --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#f8f0ff;border:1px solid #e0b6f0;">
                                <i class="fas fa-memory fs-4 mb-2" style="color:#6f42c1;"></i>
                                <div class="small text-muted fw-semibold">Penggunaan RAM</div>
                                <div class="fw-bold fs-5" style="color:#6f42c1;">{{ $ramUsed }} /
                                    {{ $ramTotal }} GB</div>
                                <div class="progress mt-2" style="height:5px;">
                                    <div class="progress-bar" style="width:{{ $ramPercent }}%;background:#6f42c1;">
                                    </div>
                                </div>
                                <div class="small text-muted mt-1">{{ $ramPercent }}%</div>
                            </div>
                        </div>

                        {{-- 6. Lama Berjalan --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#f0faff;border:1px solid #b0e0ff;">
                                <i class="fas fa-clock fs-4 mb-2 text-info"></i>
                                <div class="small text-muted fw-semibold">Lama Berjalan</div>
                                <div class="fw-bold fs-5 text-info">{{ $uptime }}</div>
                            </div>
                        </div>

                        {{-- 7. Versi Node.js --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#f0fdf4;border:1px solid #86efac;">
                                <i class="fab fa-node-js fs-4 mb-2 text-success"></i>
                                <div class="small text-muted fw-semibold">Versi Node.js</div>
                                <div class="fw-bold fs-5 text-success">{{ $nodeVersion }}</div>
                            </div>
                        </div>

                        {{-- 8. Penjadwal Tugas --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:{{ $schedulerStatus ? '#f0fff8' : '#fff4f4' }};border:1px solid {{ $schedulerStatus ? '#b6f0d8' : '#ffd0d0' }};">
                                <i
                                    class="fas fa-calendar-check fs-4 mb-2 {{ $schedulerStatus ? 'text-success' : 'text-danger' }}"></i>
                                <div class="small text-muted fw-semibold">Penjadwal Tugas</div>
                                <div class="fw-bold fs-5 {{ $schedulerStatus ? 'text-success' : 'text-danger' }}">
                                    {{ $schedulerStatus ? 'Aktif' : 'Tidak Aktif' }}
                                </div>
                            </div>
                        </div>

                        {{-- BARIS 3: Status Layanan & Versi --}}

                        {{-- 9. Status Basis Data --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:{{ $dbStatus ? '#f0fff8' : '#fff4f4' }};border:1px solid {{ $dbStatus ? '#b6f0d8' : '#ffd0d0' }};">
                                <i class="fas fa-database fs-4 mb-2 {{ $dbStatus ? 'text-success' : 'text-danger' }}"></i>
                                <div class="small text-muted fw-semibold">Status Basis Data</div>
                                <div class="fw-bold fs-5 {{ $dbStatus ? 'text-success' : 'text-danger' }}">
                                    {{ $dbStatus ? 'Aktif' : 'Tidak Aktif' }}
                                </div>
                            </div>
                        </div>

                        {{-- 10. Otomasi N8N --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:{{ $n8nStatus ? '#f0fff8' : '#fff4f4' }};border:1px solid {{ $n8nStatus ? '#b6f0d8' : '#ffd0d0' }};">
                                <i
                                    class="fas fa-project-diagram fs-4 mb-2 {{ $n8nStatus ? 'text-success' : 'text-danger' }}"></i>
                                <div class="small text-muted fw-semibold">Otomasi N8N</div>
                                <div class="fw-bold fs-5 {{ $n8nStatus ? 'text-success' : 'text-danger' }}">
                                    {{ $n8nStatus ? 'Aktif' : 'Tidak Aktif' }}
                                </div>
                            </div>
                        </div>

                        {{-- 11. Versi PHP --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#f5f0ff;border:1px solid #c8b6f0;">
                                <i class="fab fa-php fs-4 mb-2" style="color:#4f46e5;"></i>
                                <div class="small text-muted fw-semibold">Versi PHP</div>
                                <div class="fw-bold fs-5" style="color:#4f46e5;">{{ $phpVersion }}</div>
                            </div>
                        </div>

                        {{-- 12. Versi Laravel --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3 text-center h-100"
                                style="background:#fff5f0;border:1px solid #ffc8b0;">
                                <i class="fab fa-laravel fs-4 mb-2 text-danger"></i>
                                <div class="small text-muted fw-semibold">Versi Laravel</div>
                                <div class="fw-bold fs-5 text-danger">v{{ $laravelVersion }}</div>
                            </div>
                        </div>

                    </div>
                </div>

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
