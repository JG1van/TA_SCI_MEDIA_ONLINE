@extends('admin.layouts.app')

@section('title', 'Manajemen Admin')
@section('page_title', 'Manajemen Admin')

@section('content')
    <div class="row g-3 align-items-end mb-3">
        <div class="col-md-8">
            <label class="form-label">Pencarian</label>
            <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" id="searchInput" type="text"
                class="form-control" placeholder="Cari Nama Admin...">
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus me-2"></i>Tambah Admin
            </button>
        </div>
    </div>
    {{-- INFO ROLE — collapsible --}}
    <div class="mb-3">
        <div class="border rounded-3 overflow-hidden">

            {{-- Trigger --}}
            <div class="d-flex align-items-center justify-content-between px-3 py-2 bg-light" style="cursor:pointer;"
                data-bs-toggle="collapse" data-bs-target="#roleInfoPanel" aria-expanded="false"
                aria-controls="roleInfoPanel" id="roleInfoTrigger">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-shield-alt text-secondary" style="font-size:13px;"></i>
                    <span class="fw-semibold small">Informasi Role &amp; Hak Akses</span>
                    <span class="text-muted" style="font-size:11px;">5 role tersedia</span>
                </div>
                <i class="fas fa-chevron-down text-muted" id="roleInfoChevron"
                    style="font-size:12px;transition:transform .3s;"></i>
            </div>

            {{-- Body --}}
            <div class="collapse" id="roleInfoPanel">
                <div class="p-3 border-top">
                    <div class="row g-2">

                        @php
                            $roleList = [
                                1 => [
                                    'label' => 'Super-Admin',
                                    'color' => 'dark',
                                    'topColor' => '#212529',
                                    'menus' => [
                                        'Dashboard',
                                        'Mata Pelajaran',
                                        'Pelajaran',
                                        'Produk',
                                        'Guru',
                                        'Serial',
                                        'Layanan Pelanggan',
                                        'Profil',
                                        'Manajemen Admin',
                                        'Manajemen Kelas',
                                        'Manajemen Siswa',
                                        'Tipe Soal',
                                        'Model Soal',
                                        'Kategori Pertanyaan',
                                        'Informasi Server',
                                        'N8N Automation',
                                        'Database Manager',
                                    ],
                                ],
                                2 => [
                                    'label' => 'Admin',
                                    'color' => 'primary',
                                    'topColor' => '#0d6efd',
                                    'menus' => [
                                        'Dashboard',
                                        'Mata Pelajaran',
                                        'Pelajaran',
                                        'Produk',
                                        'Guru',
                                        'Serial',
                                        'Layanan Pelanggan',
                                        'Profil',
                                        'Manajemen Kelas',
                                        'Manajemen Siswa',
                                        'Tipe Soal',
                                        'Model Soal',
                                        'Kategori Pertanyaan',
                                        'Informasi Server',
                                        'N8N Automation',
                                        'Database Manager',
                                    ],
                                ],
                                3 => [
                                    'label' => 'Operasional',
                                    'color' => 'success',
                                    'topColor' => '#198754',
                                    'menus' => [
                                        'Dashboard',
                                        'Produk',
                                        'Guru',
                                        'Serial',
                                        'Profil',
                                        'Manajemen Kelas',
                                        'Manajemen Siswa',
                                        'Informasi Server',
                                    ],
                                ],
                                4 => [
                                    'label' => 'Konten-Pembelajaran',
                                    'color' => 'warning',
                                    'topColor' => '#f59e0b',
                                    'menus' => [
                                        'Dashboard',
                                        'Mata Pelajaran',
                                        'Pelajaran',
                                        'Profil',
                                        'Tipe Soal',
                                        'Model Soal',
                                        'Informasi Server',
                                    ],
                                ],
                                5 => [
                                    'label' => 'Layanan-Pengguna',
                                    'color' => 'info',
                                    'topColor' => '#0dcaf0',
                                    'menus' => [
                                        'Dashboard',
                                        'Serial',
                                        'Layanan Pelanggan',
                                        'Profil',
                                        'Kategori Pertanyaan',
                                        'Informasi Server',
                                    ],
                                ],
                            ];
                        @endphp

                        @foreach ($roleList as $roleNum => $r)
                            <div class="col-md">
                                <div class="p-2 rounded-3 h-100 bg-white border"
                                    style="border-top: 3px solid {{ $r['topColor'] }} !important;">
                                    <div class="d-flex align-items-center gap-1 mb-2">
                                        <span
                                            class="badge bg-{{ $r['color'] }} {{ in_array($r['color'], ['warning', 'info']) ? 'text-dark' : '' }}"
                                            style="font-size:10px;">
                                            {{ $r['label'] }}
                                        </span>
                                        <span class="text-muted" style="font-size:10px;">Role {{ $roleNum }}</span>
                                    </div>
                                    <div class="d-flex flex-column" style="gap:1px;">
                                        @foreach ($r['menus'] as $m)
                                            <span class="text-muted"
                                                style="font-size:11px;padding:2px 0;border-bottom:0.5px solid #f0f0f0;">
                                                {{ $m }}
                                            </span>
                                        @endforeach
                                    </div>
                                    <div class="mt-2 text-center rounded-2 py-1"
                                        style="font-size:10px;font-weight:600;background:#f8f9fa;color:#555;">
                                        {{ count($r['menus']) }} akses
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            (function() {
                const el = document.getElementById('roleInfoPanel');
                const chevron = document.getElementById('roleInfoChevron');
                if (!el || !chevron) return;
                el.addEventListener('show.bs.collapse', () => chevron.style.transform = 'rotate(180deg)');
                el.addEventListener('hide.bs.collapse', () => chevron.style.transform = 'rotate(0deg)');
            })();
        </script>
    @endpush
    {{-- Tabel Admin --}}
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover align-middle text-center" id="adminTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role / Status</th>
                    <th style="width:130px; white-space:nowrap;">Statistik</th>
                    <th style="width:200px; white-space:nowrap;">Aksi</th>
                </tr>
            </thead>
            <tbody id="adminBody">
                @forelse ($admins as $admin)
                    <tr id="row{{ $admin->id }}">
                        <td>{{ $admin->id }}</td>
                        <td class="admin-name">{{ $admin->name }}</td>
                        <td>{{ $admin->username }}</td>
                        <td class="text-center align-middle">
                            @switch($admin->role)
                                @case(1)
                                    <span class="badge bg-dark d-flex justify-content-center align-items-center">Super-Admin</span>
                                @break

                                @case(2)
                                    <span class="badge bg-primary d-flex justify-content-center align-items-center">Admin</span>
                                @break

                                @case(3)
                                    <span
                                        class="badge bg-success d-flex justify-content-center align-items-center">Operasional</span>
                                @break

                                @case(4)
                                    <span
                                        class="badge bg-warning text-dark d-flex justify-content-center align-items-center">Konten-Pembelajaran</span>
                                @break

                                @case(5)
                                    <span
                                        class="badge bg-info text-dark d-flex justify-content-center align-items-center">Layanan-Pengguna</span>
                                @break

                                @default
                                    <span class="badge bg-secondary d-flex justify-content-center align-items-center">Tidak
                                        Aktif</span>
                            @endswitch
                        </td>

                        {{-- Kolom Statistik — selalu tampil untuk semua --}}
                        <td class="text-center align-middle">
                            <button class="btn btn-sm btn-success"
                                onclick="lihatStatistik('{{ $admin->id }}', '{{ $admin->name }}', '{{ $admin->position ?? $admin->username }}', {{ $admin->role }})">
                                <i class="fas fa-chart-bar me-1"></i>Statistik
                            </button>
                        </td>

                        {{-- Kolom Aksi — hanya untuk admin lain --}}
                        <td class="text-center align-middle">
                            <div class="d-flex justify-content-center gap-2">
                                @if (auth()->user()->id !== $admin->id)
                                    <button class="btn btn-warning btn-sm" style="white-space:nowrap;"
                                        onclick="editAdmin('{{ $admin->id }}')">
                                        Detail / Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="hapusAdmin('{{ $admin->id }}', '{{ $admin->name }}')">
                                        Hapus
                                    </button>
                                @else
                                    <span class="text-muted small fst-italic">Akun Anda</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted text-center">Belum ada data admin.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6"></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- ══════════════════════════════════════════
         MODAL STATISTIK KINERJA ADMIN
    ══════════════════════════════════════════ --}}
        <div class="modal fade" id="modalStatistik" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
                style="max-width:900px; margin:1rem auto;">
                <div class="modal-content">

                    <div class="modal-header modal-statistik-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-modal-avatar" id="statAvatar">AS</div>
                            <div>
                                <div class="stat-modal-name" id="statName">Nama Admin</div>
                                <div class="stat-modal-role" id="statRoleLabel">Role · ID #0</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="stat-modal-badge" id="statBadge">—</span>
                        </div>
                    </div>

                    <div class="modal-body p-3" id="statModalBody">

                        <div id="statLoading" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2 text-muted small">Memuat statistik...</p>
                        </div>

                        <div id="statContent" style="display:none;">

                            {{-- Row 1: 3 Hero + Kinerja CS + Detail Konten (5 kolom total, pakai grid 3+2) --}}
                            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;" class="mb-3">
                                <div class="stat-hero-card stat-hero-purple">
                                    <div class="stat-hero-label">Total Materi</div>
                                    <div class="stat-hero-value" id="statTotalMateri">—</div>
                                    <div class="stat-hero-sub">Materi</div>
                                </div>
                                <div class="stat-hero-card stat-hero-teal">
                                    <div class="stat-hero-label">Total Soal</div>
                                    <div class="stat-hero-value" id="statTotalSoal">—</div>
                                    <div class="stat-hero-sub">Soal</div>
                                </div>
                                <div class="stat-hero-card stat-hero-amber">
                                    <div class="stat-hero-label">CS Ditangani</div>
                                    <div class="stat-hero-value" id="statTotalCS">—</div>
                                    <div class="stat-hero-sub">Percakapan</div>
                                </div>
                            </div>

                            {{-- Row 2: Kinerja CS | Detail Konten | Distribusi Rating CS --}}
                            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;" class="mb-3">
                                <div class="stat-block">
                                    <div class="stat-block-title">Kinerja CS</div>
                                    <div class="stat-kv-grid">
                                        <div>
                                            <div class="stat-kv-label">Total Bintang</div>
                                            <div class="stat-kv-val" id="statTotalBintang">—</div>
                                        </div>
                                        <div>
                                            <div class="stat-kv-label">Rata-rata</div>
                                            <div class="stat-kv-val" id="statRataRating">—</div>
                                        </div>
                                        <div>
                                            <div class="stat-kv-label">Tertinggi</div>
                                            <div class="stat-kv-val" id="statMaxRating">—</div>
                                        </div>
                                        <div>
                                            <div class="stat-kv-label">Terendah</div>
                                            <div class="stat-kv-val" id="statMinRating">—</div>
                                        </div>
                                    </div>
                                    <div class="stat-star-row" id="statStarRow"></div>
                                </div>
                                <div class="stat-block">
                                    <div class="stat-block-title">Detail Konten</div>
                                    <div class="stat-kv-grid">
                                        <div>
                                            <div class="stat-kv-label">Total Materi</div>
                                            <div class="stat-kv-val" id="statMateriDetail">—</div>
                                        </div>
                                        <div>
                                            <div class="stat-kv-label">Total Soal</div>
                                            <div class="stat-kv-val" id="statSoalDetail">—</div>
                                        </div>
                                        <div>
                                            <div class="stat-kv-label">Log Aktivitas</div>
                                            <div class="stat-kv-val" id="statLogAktivitas">—</div>
                                        </div>
                                        <div>
                                            <div class="stat-kv-label">Total CS Log</div>
                                            <div class="stat-kv-val" id="statCSLogDetail">—</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="stat-block">
                                    <div class="stat-block-title">Distribusi Rating CS</div>
                                    <div id="statRatingBars">
                                        @foreach ([5, 4, 3, 2, 1] as $r)
                                            <div class="stat-bar-item">
                                                <div class="stat-bar-label-row">
                                                    <span>{{ $r }} ★</span>
                                                    <span id="statR{{ $r }}Count">0 Percakapan</span>
                                                </div>
                                                <div class="stat-bar-track">
                                                    <div class="stat-bar-fill" id="statR{{ $r }}Bar"
                                                        style="width:0%;background:{{ $r == 5 ? '#0F6E56' : ($r == 4 ? '#1D9E75' : ($r == 3 ? '#EF9F27' : ($r == 2 ? '#D85A30' : '#E24B4A'))) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Row 3: Radar Chart | Materi per Bulan | Aktivitas Terbaru --}}
                            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
                                <div class="stat-block stat-radar-wrap">
                                    <div class="stat-block-title">Profil Kinerja</div>
                                    <div style="display:flex;justify-content:center;position:relative;">
                                        <svg id="statRadarSvg" width="190" height="175" viewBox="0 0 240 220"
                                            role="img" aria-label="Radar chart profil kinerja admin">
                                            <title>Profil kinerja admin</title>
                                            <g transform="translate(120,115)">
                                                <polygon points="0,-80 69,-40 69,40 0,80 -69,40 -69,-40" fill="none"
                                                    stroke="#e0e0e0" stroke-width="0.5" />
                                                <polygon points="0,-60 52,-30 52,30 0,60 -52,30 -52,-30" fill="none"
                                                    stroke="#e0e0e0" stroke-width="0.5" />
                                                <polygon points="0,-40 35,-20 35,20 0,40 -35,20 -35,-20" fill="none"
                                                    stroke="#e0e0e0" stroke-width="0.5" />
                                                <polygon points="0,-20 17,-10 17,10 0,20 -17,10 -17,-10" fill="none"
                                                    stroke="#e0e0e0" stroke-width="0.5" />
                                                <line x1="0" y1="0" x2="0" y2="-80"
                                                    stroke="#ccc" stroke-width="0.5" />
                                                <line x1="0" y1="0" x2="69" y2="-40"
                                                    stroke="#ccc" stroke-width="0.5" />
                                                <line x1="0" y1="0" x2="69" y2="40"
                                                    stroke="#ccc" stroke-width="0.5" />
                                                <line x1="0" y1="0" x2="0" y2="80"
                                                    stroke="#ccc" stroke-width="0.5" />
                                                <line x1="0" y1="0" x2="-69" y2="40"
                                                    stroke="#ccc" stroke-width="0.5" />
                                                <line x1="0" y1="0" x2="-69" y2="-40"
                                                    stroke="#ccc" stroke-width="0.5" />
                                                <polygon id="radarPolygon" points="0,0 0,0 0,0 0,0 0,0 0,0" fill="#696CFF"
                                                    fill-opacity="0.25" stroke="#696CFF" stroke-width="1.5" />
                                                <circle id="rd0" cx="0" cy="0" r="3" fill="#696CFF" />
                                                <circle id="rd1" cx="0" cy="0" r="3" fill="#696CFF" />
                                                <circle id="rd2" cx="0" cy="0" r="3" fill="#696CFF" />
                                                <circle id="rd3" cx="0" cy="0" r="3" fill="#696CFF" />
                                                <circle id="rd4" cx="0" cy="0" r="3" fill="#696CFF" />
                                                <circle id="rd5" cx="0" cy="0" r="3" fill="#696CFF" />
                                                <text font-size="10" fill="#8592A3" font-family="inherit"
                                                    text-anchor="middle" x="0" y="-88">Materi</text>
                                                <text font-size="10" fill="#8592A3" font-family="inherit"
                                                    text-anchor="start" x="74" y="-42">Soal</text>
                                                <text font-size="10" fill="#8592A3" font-family="inherit"
                                                    text-anchor="start" x="74" y="46">CS</text>
                                                <text font-size="10" fill="#8592A3" font-family="inherit"
                                                    text-anchor="middle" x="0" y="96">Rating</text>
                                                <text font-size="10" fill="#8592A3" font-family="inherit" text-anchor="end"
                                                    x="-74" y="46">Aktivitas</text>
                                                <text font-size="10" fill="#8592A3" font-family="inherit" text-anchor="end"
                                                    x="-74" y="-42">Konsistensi</text>
                                            </g>
                                        </svg>
                                        <div id="radarTooltip"
                                            style="
    display:none;
    position:absolute;
    background:#2b2b3b;
    color:#fff;
    font-size:12px;
    padding:7px 11px;
    border-radius:8px;
    pointer-events:none;
    z-index:99;
    max-width:180px;
    line-height:1.5;
    box-shadow:0 4px 12px rgba(0,0,0,0.2);
">
                                        </div>
                                    </div>
                                </div>

                                {{-- Materi per Bulan — max 5 bar --}}
                                <div class="stat-block">
                                    <div class="stat-block-title">Materi Dibuat per Bulan</div>
                                    <div id="statMateriBars" style="max-height:200px;overflow-y:auto;">
                                        <p class="text-muted small text-center py-2">Memuat...</p>
                                    </div>
                                </div>

                                {{-- Aktivitas Terbaru — max 5 item --}}
                                <div class="stat-block">
                                    <div class="stat-block-title">Aktivitas Terbaru</div>
                                    <div id="statTimeline" style="max-height:200px;overflow-y:auto;">
                                        <p class="text-muted small text-center py-2">Belum ada aktivitas.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div class="modal fade p-5" id="modalTambah" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md mt-5 custom-modal">
                <form id="formTambah" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Nama</label>
                            <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                                type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Username</label>
                            <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                                type="text" name="username" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" name="date_in" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="0" selected>— Pilih Role —</option>
                                <option value="1">Super-Admin</option>
                                <option value="2">Admin</option>
                                <option value="3">Operasional</option>
                                <option value="4">Konten-Pembelajaran</option>
                                <option value="5">Layanan-Pengguna</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Edit --}}
        <div class="modal fade p-5" id="modalEdit" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md mt-5 custom-modal">
                <form id="formEdit" class="modal-content border-0 shadow-lg rounded-4" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-light border-bottom-0">
                        <h5 class="modal-title fw-bold">Detail / Edit Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row align-items-center g-4">
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="bg-light rounded-4 shadow p-4 d-flex flex-column align-items-center justify-content-center"
                                    style="min-height:250px;">
                                    <div class="position-relative">
                                        <img id="editImgPreview" src="{{ asset('images/logo.webp') }}"
                                            class="rounded-circle border shadow bg-white" width="120" height="120"
                                            style="object-fit:cover;">
                                        <button type="button"
                                            class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0 translate-middle"
                                            id="btnEditPhoto" style="width:35px;height:35px;">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </div>
                                    <input type="file" id="editImgInput" name="photo" accept="image/*" hidden>
                                    <h6 class="fw-bold mb-0 mt-3" id="editNameCard">Nama Admin</h6>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <input type="hidden" id="editId" name="id">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama</label>
                                        <input autocomplete="off" type="text" id="editName" name="name"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Username</label>
                                        <input autocomplete="off" type="text" id="editUsername" name="username"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tanggal Masuk</label>
                                        <input type="date" id="editDateIn" name="date_in" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jabatan / Posisi</label>
                                        <input autocomplete="off" type="text" id="editPosition" name="position"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">No. Telepon</label>
                                        <input type="number" id="editPhone" name="phone" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Login Terakhir</label>
                                        <input type="text" id="editLoginAt" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Password</label>
                                        <input type="text" id="editPassword" class="form-control" value="********"
                                            readonly>
                                        <button type="button" class="btn btn-outline-danger w-100 mt-2"
                                            id="btnResetPassword">
                                            <i class="fas fa-undo me-1"></i> Reset Password
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Role / Status</label>
                                        <select id="editRole" name="role" class="form-select" required>
                                            <option value="0">Tidak Aktif</option>
                                            <option value="1">Super-Admin</option>
                                            <option value="2">Admin</option>
                                            <option value="3">Operasional</option>
                                            <option value="4">Konten-Pembelajaran</option>
                                            <option value="5">Layanan-Pengguna</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    @endsection

    @section('js')
        <script>
            // ==== Notifikasi ====
            function notifSuccess(msg) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: msg,
                    timer: 1800,
                    showConfirmButton: false
                });
            }

            function notifError(msg) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: msg,
                    confirmButtonText: 'Tutup'
                });
            }

            const roleLabel = {
                1: 'Super-Admin',
                2: 'Admin',
                3: 'Operasional',
                4: 'Konten-Pembelajaran',
                5: 'Layanan-Pengguna',
                0: 'Tidak Aktif'
            };

            // ════════════════════════════════════
            // STATISTIK
            // ════════════════════════════════════
            function lihatStatistik(id, nama, posisi, role) {
                document.getElementById('statLoading').style.display = 'block';
                document.getElementById('statContent').style.display = 'none';

                const inisial = nama.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
                document.getElementById('statAvatar').textContent = inisial;
                document.getElementById('statName').textContent = nama;
                document.getElementById('statRoleLabel').textContent = (posisi || roleLabel[role]) + ' · ID #' + id;
                document.getElementById('statBadge').textContent = roleLabel[role] || '—';

                new bootstrap.Modal(document.getElementById('modalStatistik')).show();

                fetch(`/admin/admin/${id}/statistik`)
                    .then(res => {
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        return res.json();
                    })
                    .then(data => {
                        if (!data.success) {
                            notifError(data.message || 'Gagal memuat statistik.');
                            return;
                        }
                        renderStatistik(data.stats);
                    })
                    .catch(err => notifError('Error: ' + err.message));
            }

            function renderStatistik(s) {
                // Hero
                document.getElementById('statTotalMateri').textContent = (s.total_materi ?? 0);
                document.getElementById('statTotalSoal').textContent = (s.total_soal ?? 0);
                document.getElementById('statTotalCS').textContent = (s.total_cs ?? 0);

                // Detail konten
                document.getElementById('statMateriDetail').textContent = (s.total_materi ?? 0) + ' Materi';
                document.getElementById('statSoalDetail').textContent = (s.total_soal ?? 0) + ' Soal';
                document.getElementById('statLogAktivitas').textContent = (s.total_log ?? 0) + ' Aktivitas';
                document.getElementById('statCSLogDetail').textContent = (s.total_cs ?? 0) + ' Percakapan';

                // Kinerja CS
                const rata = s.rata_rating ?? 0;
                document.getElementById('statTotalBintang').textContent = (s.total_bintang ?? 0) + ' ⭐';
                document.getElementById('statRataRating').textContent = parseFloat(rata).toFixed(1) + ' / 5';
                document.getElementById('statMaxRating').textContent = 'nilai ' + (s.max_rating ?? 0) + ' ⭐';
                document.getElementById('statMinRating').textContent = 'nilai ' + (s.min_rating ?? 0) + ' ⭐';

                // Bintang visual
                const starRow = document.getElementById('statStarRow');
                starRow.innerHTML = '';
                const rataInt = Math.round(parseFloat(rata));
                for (let i = 1; i <= 5; i++) {
                    const span = document.createElement('span');
                    span.textContent = '★';
                    span.className = i <= rataInt ? 'stat-star' : 'stat-star-empty';
                    starRow.appendChild(span);
                }

                // Bar distribusi rating
                const dist = s.distribusi_rating ?? {};
                const maxTiket = Math.max(...[5, 4, 3, 2, 1].map(r => dist[r] ?? 0), 1);
                [5, 4, 3, 2, 1].forEach(r => {
                    const count = dist[r] ?? 0;
                    document.getElementById(`statR${r}Count`).textContent = count + ' Percakapan';
                    document.getElementById(`statR${r}Bar`).style.width = ((count / maxTiket) * 100) + '%';
                });

                // Materi per bulan
                const materiBulan = s.materi_per_bulan ?? [];
                const maxMateriBar = Math.max(...materiBulan.map(m => m.total), 1);
                const materiBarsEl = document.getElementById('statMateriBars');
                if (materiBulan.length === 0) {
                    materiBarsEl.innerHTML = '<p class="text-muted small text-center py-2">Belum ada data.</p>';
                } else {
                    materiBarsEl.innerHTML = materiBulan.map(m => `
            <div class="stat-bar-item">
                <div class="stat-bar-label-row">
                    <span>${m.label}</span><span>${m.total}</span>
                </div>
                <div class="stat-bar-track">
                    <div class="stat-bar-fill"
                        style="width:${Math.round((m.total/maxMateriBar)*100)}%;background:#696CFF">
                    </div>
                </div>
            </div>`).join('');
                }

                // Radar chart
                const maxVal = 80;

                function toR(val, maxPossible) {
                    if (!maxPossible || maxPossible === 0) return 0;
                    return Math.min(maxVal, Math.round((val / maxPossible) * maxVal));
                }

                const rMateri = toR(s.total_materi ?? 0, s.max_materi ?? Math.max(s.total_materi ?? 1, 1));
                const rSoal = toR(s.total_soal ?? 0, s.max_soal ?? Math.max(s.total_soal ?? 1, 1));
                const rCS = toR(s.total_cs ?? 0, s.max_cs ?? Math.max(s.total_cs ?? 1, 1));
                const rRating = toR(parseFloat(s.rata_rating ?? 0), 5);
                const rAktivitas = toR(s.total_log ?? 0, s.max_log ?? Math.max(s.total_log ?? 1, 1));
                const rKonsistensi = toR(s.bulan_aktif ?? 0, s.max_bulan_aktif ?? 12);

                function radarPoint(value, angle) {
                    const rad = (angle - 90) * (Math.PI / 180);
                    return [Math.round(value * Math.cos(rad)), Math.round(value * Math.sin(rad))];
                }

                const angles = [0, 60, 120, 180, 240, 300];
                const values = [rMateri, rSoal, rCS, rRating, rAktivitas, rKonsistensi];
                const pts = values.map((v, i) => radarPoint(v, angles[i]));

                document.getElementById('radarPolygon').setAttribute('points', pts.map(p => p.join(',')).join(' '));

                const radarMeta = [{
                        label: 'Materi',
                        desc: 'Jumlah materi pembelajaran yang dibuat',
                        val: () => (s.total_materi ?? 0) + ' materi'
                    },
                    {
                        label: 'Soal',
                        desc: 'Jumlah soal latihan yang dibuat',
                        val: () => (s.total_soal ?? 0) + ' soal'
                    },
                    {
                        label: 'CS',
                        desc: 'Jumlah percakapan layanan pelanggan yang ditangani',
                        val: () => (s.total_cs ?? 0) + ' Percakapan'
                    },
                    {
                        label: 'Rating',
                        desc: 'Rata-rata penilaian dari pengguna atas pelayanan CS',
                        val: () => parseFloat(s.rata_rating ?? 0).toFixed(1) + ' / 5'
                    },
                    {
                        label: 'Aktivitas',
                        desc: 'Total aktivitas yang tercatat di log sistem',
                        val: () => (s.total_log ?? 0) + ' aktivitas'
                    },
                    {
                        label: 'Konsistensi',
                        desc: 'Jumlah bulan aktif admin membuat materi pembelajaran',
                        val: () => (s.bulan_aktif ?? 0) + ' bulan aktif'
                    },
                ];

                const tooltip = document.getElementById('radarTooltip');

                pts.forEach((p, i) => {
                    const el = document.getElementById('rd' + i);
                    if (!el) return;
                    el.setAttribute('cx', p[0]);
                    el.setAttribute('cy', p[1]);
                    el.setAttribute('r', '4');
                    el.style.cursor = 'pointer';

                    el.onmouseenter = () => {
                        const m = radarMeta[i];
                        tooltip.innerHTML =
                            `<strong style="font-size:12px;">${m.label}</strong><br>${m.desc}<br><span style="color:#a5a8ff;font-weight:700;">${m.val()}</span>`;
                        tooltip.style.display = 'block';
                    };

                    el.onmousemove = (e) => {
                        const svg = document.getElementById('statRadarSvg');
                        const rect = svg.getBoundingClientRect();
                        tooltip.style.left = (e.clientX - rect.left + 10) + 'px';
                        tooltip.style.top = (e.clientY - rect.top - 10) + 'px';
                    };

                    el.onmouseleave = () => {
                        tooltip.style.display = 'none';
                    };
                });

                // Timeline aktivitas terbaru
                const timeline = s.aktivitas_terbaru ?? [];
                const timelineEl = document.getElementById('statTimeline');
                if (timeline.length === 0) {
                    timelineEl.innerHTML = '<p class="text-muted small text-center py-2">Belum ada aktivitas.</p>';
                } else {
                    const dotColors = {
                        materi: '#696CFF',
                        cs: '#0F6E56',
                        soal: '#BA7517',
                        log: '#8592A3',
                        default: '#8592A3'
                    };
                    timelineEl.innerHTML = timeline.map(t => {
                        const color = dotColors[t.type] ?? dotColors.default;
                        return `
                <div class="stat-tl-row">
                    <div class="stat-tl-dot" style="background:${color}"></div>
                    <div>
                        <div class="stat-tl-action">${t.action}</div>
                        <div class="stat-tl-time">${t.time}</div>
                    </div>
                </div>`;
                    }).join('');
                }

                document.getElementById('statLoading').style.display = 'none';
                document.getElementById('statContent').style.display = 'block';
            }

            // ════════════════════════════════════
            // DOM READY
            // ════════════════════════════════════
            document.addEventListener("DOMContentLoaded", () => {

                // Pencarian
                document.getElementById("searchInput").addEventListener("keyup", function() {
                    const keyword = this.value.toLowerCase();
                    document.querySelectorAll("#adminBody tr").forEach(row => {
                        const nama = row.querySelector(".admin-name")?.textContent.toLowerCase() ?? '';
                        row.style.display = nama.includes(keyword) ? "" : "none";
                    });
                });

                // Reset form tambah saat modal dibuka
                document.getElementById('modalTambah').addEventListener('show.bs.modal', () => {
                    document.getElementById('formTambah').reset();
                });

                // ==== Tambah Admin ====
                document.getElementById("formTambah").addEventListener("submit", async function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const btn = this.querySelector("button[type='submit']");
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                    try {
                        const res = await fetch("{{ route('admin.admin.store') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: formData
                        });
                        const result = await res.json();
                        if (result.success) {
                            bootstrap.Modal.getInstance(document.getElementById('modalTambah')).hide();
                            this.reset();
                            notifSuccess(result.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            notifError(result.message || 'Gagal menyimpan data.');
                        }
                    } catch (err) {
                        notifError(err.message);
                    } finally {
                        btn.disabled = false;
                        btn.innerHTML = 'Simpan';
                    }
                });

                // ==== Edit Admin ====
                document.getElementById("formEdit").addEventListener("submit", async function(e) {
                    e.preventDefault();
                    const id = document.getElementById("editId").value;
                    const formData = new FormData(this);
                    const btn = this.querySelector("button[type='submit']");
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                    try {
                        const res = await fetch(`/admin/admin/${id}`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "X-HTTP-Method-Override": "PUT"
                            },
                            body: formData
                        });
                        const result = await res.json();
                        if (result.success) {
                            bootstrap.Modal.getInstance(document.getElementById("modalEdit")).hide();
                            notifSuccess(result.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            notifError(result.message || 'Gagal memperbarui data.');
                        }
                    } catch (err) {
                        notifError(err.message);
                    } finally {
                        btn.disabled = false;
                        btn.innerHTML = 'Simpan Perubahan';
                    }
                });

                // ==== Reset Password ====
                document.getElementById("btnResetPassword").addEventListener("click", function() {
                    const id = document.getElementById("editId").value;
                    Swal.fire({
                        title: 'Reset Password?',
                        text: 'Password admin akan dikembalikan ke default (Admin1234).',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Reset',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#696CFF',
                        cancelButtonColor: '#8592A3',
                        reverseButtons: true
                    }).then(result => {
                        if (result.isConfirmed) {
                            fetch(`/admin/admin/${id}/reset-password`, {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    }
                                })
                                .then(res => res.json())
                                .then(result => {
                                    if (result.success) notifSuccess(result.message);
                                    else notifError(result.message);
                                })
                                .catch(() => notifError('Gagal mereset password.'));
                        }
                    });
                });

                // ==== Upload Foto ====
                document.getElementById("btnEditPhoto").addEventListener("click", () =>
                    document.getElementById("editImgInput").click());

                document.getElementById("editImgInput").addEventListener("change", (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (ev) => {
                            document.getElementById("editImgPreview").src = ev.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });

            }); // ← tutup DOMContentLoaded

            // ==== Load data ke modal edit ====
            function editAdmin(id) {
                fetch(`/admin/admin/${id}/edit`)
                    .then(res => res.json())
                    .then(result => {
                        if (result.success) {
                            const a = result.data;
                            document.getElementById("editId").value = a.id;
                            document.getElementById("editName").value = a.name;
                            document.getElementById("editUsername").value = a.username;
                            document.getElementById("editDateIn").value = a.date_in ?? '';
                            document.getElementById("editPosition").value = a.position ?? '';
                            document.getElementById("editPhone").value = a.phone ?? '';
                            document.getElementById("editLoginAt").value = a.login_at ?? '';
                            document.getElementById("editRole").value = a.role ?? 0;
                            document.getElementById("editNameCard").innerText = a.name ?? "Tanpa Nama";
                            document.getElementById("editImgPreview").src =
                                a.img ? `/storage/admins/${a.img}` : `/images/logo.webp`;
                            new bootstrap.Modal(document.getElementById("modalEdit")).show();
                        } else {
                            notifError('Data admin tidak ditemukan.');
                        }
                    })
                    .catch(() => notifError('Gagal memuat data admin.'));
            }

            // ==== Hapus Admin ====
            function hapusAdmin(id, nama) {
                Swal.fire({
                    title: 'Hapus Admin?',
                    text: `Yakin ingin menghapus "${nama}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#696CFF',
                    cancelButtonColor: '#8592A3',
                    reverseButtons: true
                }).then(result => {
                    if (result.isConfirmed) {
                        fetch(`/admin/admin/${id}`, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                }
                            })
                            .then(res => res.json())
                            .then(result => {
                                if (result.success) {
                                    document.getElementById(`row${id}`).remove();
                                    notifSuccess(result.message);
                                } else {
                                    notifError(result.message || 'Gagal menghapus data.');
                                }
                            })
                            .catch(() => notifError('Terjadi kesalahan saat menghapus.'));
                    }
                });
            }
        </script>
    @endsection
