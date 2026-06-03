@php
    // ROLE USER SEKARANG
    $role = $userRole ?? (Auth::user()->role_id ?? null);

    // DEFINISI MENU
    $menus = [
        [
            'route' => 'admin.dashboard',
            'match' => 'admin.dashboard',
            'label' => 'Dashboard',
            'icon' => 'bi bi-speedometer2',
            'roles' => [1, 2, 3, 4, 5],
        ],
        [
            'route' => 'admin.mapel.index',
            'match' => 'admin.mapel.*',
            'label' => 'Mata Pelajaran',
            'icon' => 'bi bi-book',
            'roles' => [1, 2, 3, 4],
        ],
        [
            'route' => 'admin.pelajaran.index',
            'match' => 'admin.pelajaran.*',
            'label' => 'Pelajaran',
            'icon' => 'bi bi-journal-text',
            'roles' => [1, 2, 3, 5],
        ],
        [
            'route' => 'admin.produk.index',
            'match' => 'admin.produk.*',
            'label' => 'Produk',
            'icon' => 'bi bi-box-seam',
            'roles' => [1, 2, 3, 5],
        ],
        [
            'route' => 'admin.guru.index',
            'match' => 'admin.guru.*',
            'label' => 'Guru',
            'icon' => 'fas fa-chalkboard-teacher',
            'roles' => [1, 2, 3, 5],
        ],
        [
            'route' => 'admin.serial.index',
            'match' => 'admin.serial.*',
            'label' => 'Serial',
            'icon' => 'bi bi-key',
            'roles' => [1, 2, 3, 5],
        ],
        [
            'route' => 'admin.layanan-pelanggan.index',
            'match' => 'admin.layanan-pelanggan.*',
            'label' => 'Layanan Pelanggan',
            'icon' => 'bi bi-chat-left-text',
            'roles' => [1, 2, 5],
        ],
        [
            'route' => 'admin.pengaturan.index',
            'match' => [
                'admin.pengaturan.*',
                'admin.admin.*',
                'admin.siswa.*',
                'admin.profil.*',
                'admin.pra-latihan.*',
                'admin.kategori_pertanyaan.*',
                'admin.pertanyaan-tidak-terjawab.*',
                'admin.kelas.*',
            ],
            'label' => 'Pengaturan',
            'icon' => 'bi bi-gear-fill',
            'roles' => [0, 1, 2, 3, 4, 5],
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

        <li class="menu-item {{ $isActive ? 'active' : '' }} {{ !$allowed ? 'disabled' : '' }}">

            {{-- MENU NORMAL --}}
            @if ($allowed)
                <a href="{{ route($m['route']) }}" class="menu-link">
                    <i class="menu-icon tf-icons {{ $m['icon'] }}"></i>
                    <div>{{ $m['label'] }}</div>
                </a>

                {{-- MENU LOCKED --}}
            @else
                <a class="menu-link disabled" style="opacity: 0.5; cursor: not-allowed;">
                    <i class="menu-icon tf-icons bi bi-lock-fill"></i>
                    <div>{{ $m['label'] }}</div>
                </a>
            @endif

        </li>
    @endforeach

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
