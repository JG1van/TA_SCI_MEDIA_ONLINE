@php
    // ROLE USER SEKARANG
    $role = $userRole ?? (Auth::user()->role_id ?? null);

    // DEFINISI MENU
    // Referensi role:
    // 1 = Super-Admin | 2 = Admin | 3 = Operasional
    // 4 = Konten-Pembelajaran | 5 = Layanan-Pelanggan
    $menus = [
        [
            'route' => 'admin.dashboard',
            'match' => ['admin.dashboard'],
            'label' => 'Dashboard',
            'icon' => 'bi bi-speedometer2',
            'roles' => [1, 2, 3, 4, 5],
        ],
        [
            'route' => 'admin.mapel.index',
            'match' => ['admin.mapel.*'],
            'label' => 'Mata Pelajaran',
            'icon' => 'bi bi-book',
            'roles' => [1, 2, 3, 4],
        ],
        [
            'route' => 'admin.pelajaran.index',
            'match' => ['admin.pelajaran.*'],
            'label' => 'Pelajaran',
            'icon' => 'bi bi-journal-text',
            'roles' => [1, 2, 3, 4],
        ],
        [
            'route' => 'admin.daftar-isi.index',
            'match' => ['admin.daftar-isi.*'],
            'label' => 'Daftar Isi Materi',
            'icon' => 'bi bi-list-ul',
            'roles' => [1, 2, 3, 4],
        ],
        [
            'route' => 'admin.kompetensi-dasar.index',
            'match' => ['admin.kompetensi-dasar.*'],
            'label' => 'Kompetensi Dasar',
            'icon' => 'bi bi-patch-check',
            'roles' => [1, 2, 3, 4],
        ],
        [
            'route' => 'admin.soal.index',
            'match' => ['admin.soal.*'],
            'label' => 'Soal',
            'icon' => 'bi bi-question-circle',
            'roles' => [1, 2, 3, 4],
        ],
        [
            'route' => 'admin.tipe-soal.index',
            'match' => ['admin.tipe-soal.*'],
            'label' => 'Tipe Soal',
            'icon' => 'bi bi-ui-checks',
            'roles' => [1, 2, 4],
        ],
        [
            'route' => 'admin.model-soal.index',
            'match' => ['admin.model-soal.*'],
            'label' => 'Model Soal',
            'icon' => 'bi bi-layout-text-window',
            'roles' => [1, 2, 4],
        ],
        [
            'route' => 'admin.produk.index',
            'match' => ['admin.produk.*'],
            'label' => 'Produk',
            'icon' => 'bi bi-box-seam',
            'roles' => [1, 2, 3, 5],
        ],
        [
            'route' => 'admin.guru.index',
            'match' => ['admin.guru.*'],
            'label' => 'Guru',
            'icon' => 'fas fa-chalkboard-teacher',
            'roles' => [1, 2, 3, 5],
        ],
        [
            'route' => 'admin.serial.index',
            'match' => ['admin.serial.*'],
            'label' => 'Serial',
            'icon' => 'bi bi-key',
            'roles' => [1, 2, 3, 5],
        ],
        [
            'route' => 'admin.layanan-pelanggan.index',
            'match' => ['admin.layanan-pelanggan.*'],
            'label' => 'Layanan Pelanggan',
            'icon' => 'bi bi-chat-left-text',
            'roles' => [1, 2, 5],
        ],
        [
            'route' => 'admin.kategori-pertanyaan.index',
            'match' => ['admin.kategori-pertanyaan.*'],
            'label' => 'Kategori Pertanyaan',
            'icon' => 'bi bi-tags',
            'roles' => [1, 2, 5],
        ],
        [
            'route' => 'admin.kelas.index',
            'match' => ['admin.kelas.*'],
            'label' => 'Manajemen Kelas',
            'icon' => 'bi bi-building',
            'roles' => [1, 2, 3, 5],
        ],
        [
            'route' => 'admin.siswa.index',
            'match' => ['admin.siswa.*'],
            'label' => 'Manajemen Siswa',
            'icon' => 'bi bi-people',
            'roles' => [1, 2, 3, 5],
        ],
        [
            'route' => 'admin.admin.index',
            'match' => ['admin.admin.*'],
            'label' => 'Manajemen Admin',
            'icon' => 'bi bi-shield-lock',
            'roles' => [1], // Super-Admin only
        ],
        [
            'route' => 'admin.server.index',
            'match' => ['admin.server.*'],
            'label' => 'Informasi Server',
            'icon' => 'bi bi-hdd-rack',
            'roles' => [1, 2, 3, 4, 5],
        ],
        [
            'route' => 'admin.n8n.index',
            'match' => ['admin.n8n.*'],
            'label' => 'N8N Automation',
            'icon' => 'bi bi-diagram-3',
            'roles' => [1, 2],
        ],
        [
            'route' => 'admin.database.index',
            'match' => ['admin.database.*'],
            'label' => 'Database Manager',
            'icon' => 'bi bi-database',
            'roles' => [1, 2],
        ],
        [
            'route' => 'admin.profil.index',
            'match' => ['admin.profil.*'],
            'label' => 'Profil',
            'icon' => 'bi bi-person-circle',
            'roles' => [1, 2, 3, 4, 5],
        ],
    ];
@endphp


<ul class="menu-inner py-1">

    {{-- LOOP MENU --}}
    @foreach ($menus as $m)
        @php
            $isActive = request()->routeIs($m['match']);
            $allowed = in_array($role, $m['roles']);
        @endphp

        {{-- Hanya tampilkan menu yang diizinkan --}}
        @if ($allowed)
            <li class="menu-item {{ $isActive ? 'active' : '' }}">
                <a href="{{ route($m['route']) }}" class="menu-link">
                    <i class="menu-icon tf-icons {{ $m['icon'] }}"></i>
                    <div>{{ $m['label'] }}</div>
                </a>
            </li>
        @endif
    @endforeach

    {{-- TOMBOL KELUAR --}}
    <li class="menu-item">
        <form action="{{ route('logout') }}" method="POST" class="m-0 p-0 w-100">
            @csrf
            <button type="submit" class="menu-link border-0 bg-transparent w-100 text-start">
                <i class="menu-icon tf-icons fas fa-sign-out-alt"></i>
                <div>Keluar</div>
            </button>
        </form>
    </li>

</ul>
