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
        @php $btn = btnDisable($role, [1,2,5]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card h-100" style="{{ $btn['style'] }}">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="mb-3">
                            {{-- Pink / Magenta --}}
                            <i class="fas fa-question-circle fs-1" style="color:#d63384;"></i>
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
        </div>

        {{-- SISA MEMORI SERVER --}}
        @php $btn = btnDisable($role, [1,2,3,4,5]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card" style="{{ $btn['style'] }}">
                <div class="card-body">
                    {{-- Cyan (info) --}}
                    <i class="fas fa-memory fs-1 mb-3 text-info"></i>
                    <h5 class="fw-bold">Sisa Memori Server</h5>
                    <p class="text-muted mb-3">penggunaan Penyimpanan saat ini</p>

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
        {{-- PANEL DEVELOPER --}}
        @php $btn = btnDisable($role, [1,2]); @endphp
        <div class="col-md-4">
            <div class="card shadow text-center setting-card" style="{{ $btn['style'] }}">
                <div class="card-body">
                    <i class="fas fa-terminal fs-1 mb-3" style="color:#6610f2;"></i>
                    <h5 class="fw-bold">Panel Developer</h5>
                    <p class="text-muted mb-3">Akses tools developer sistem</p>
                    <button class="btn btn-primary w-100 {{ $btn['class'] }}" data-bs-toggle="modal"
                        data-bs-target="#devPanelModal" {{ $btn['class'] ? 'disabled' : '' }}>
                        Pilih
                    </button>
                </div>
            </div>
        </div>
        {{-- KELUAR --}}
        <div class="col-md-12">
            <div class="card shadow text-center setting-card border-danger">
                <div class="card-body">
                    {{-- Merah (danger) --}}
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
        </div>
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
        $drive = '/'; // sesuaikan drive server kamu

        $totalSpace = disk_total_space($drive);
        $freeSpace = disk_free_space($drive);

        $totalGB = round($totalSpace / 1024 / 1024 / 1024, 2);
        $freeGB = round($freeSpace / 1024 / 1024 / 1024, 2);
        $usedGB = round($totalGB - $freeGB, 2);
        $percent = round(($usedGB / $totalGB) * 100);
    @endphp
    <div class="modal fade" id="memoryModal" tabindex="-1">
        <div class="modal-dialog custom-modal modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Informasi Memori Server</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <div class="mb-3">
                        <h6>Total Space</h6>
                        <h4 class="text-primary">{{ $totalGB }} GB</h4>
                    </div>

                    <div class="mb-3">
                        <h6>Used Space</h6>
                        <h4 class="text-danger">{{ $usedGB }} GB</h4>
                    </div>

                    <div class="mb-3">
                        <h6>Free Space</h6>
                        <h4 class="text-success">{{ $freeGB }} GB</h4>
                    </div>

                    <div class="progress mt-3" style="height:20px;">
                        <div class="progress-bar bg-danger" style="width: {{ $percent }}%">
                            {{ $percent }}%
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
    {{-- MODAL PANEL DEVELOPER --}}
    <div class="modal fade" id="devPanelModal" tabindex="-1">
        <div class="modal-dialog modal-md custom-modal mt-5">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Panel Developer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-grid gap-3">
                        <a href="https://n8n.tak-scimediaonline.my.id/" target="_blank"
                            class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-project-diagram"></i>
                            N8N Automation
                        </a>
                        <a href="https://db.tak-scimediaonline.my.id/" target="_blank"
                            class="btn btn-success btn w-100 mb-3">
                            <i class="fas fa-database"></i>
                            Database Manager
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
