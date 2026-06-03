<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'SciMedia Online')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Sneat Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets_sneat/vendor/css/core.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets_sneat/vendor/css/theme-default.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets_sneat/css/demo.css') }}?v={{ time() }}">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Sneat Helpers -->
    <script src="{{ asset('assets_sneat/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets_sneat/js/config.js') }}"></script>
</head>

<body>
    @php
        $currentAction = request()->route()->getActionName();
        $controller = explode('@', class_basename($currentAction))[0];
        $allowedRoles = null;

        if (class_exists("App\\Http\\Controllers\\Admin\\$controller")) {
            $fullClass = "App\\Http\\Controllers\\Admin\\$controller";
            if (defined("$fullClass::ALLOWED_ROLES")) {
                $allowedRoles = $fullClass::ALLOWED_ROLES;
            }
        }

        $userRole = Auth::user()->role ?? 0;
        $allowedForThisUser = $allowedRoles === null ? true : in_array($userRole, $allowedRoles);
    @endphp
    @php
        use App\Models\Serial;

        $expired14Months = Serial::whereNotNull('expired_at')
            ->whereDate('expired_at', '<=', now()->subMonths(14))
            ->count();
    @endphp
    @php
        $warningNoEmail = App\Models\Serial::where('notif', 'Tidak_ada')
            ->whereDate('expired_at', '<=', now()->addDays(30))
            ->whereHas('user', function ($q) {
                $q->whereNull('email')->orWhere('email', '');
            })
            ->count();
    @endphp
    @php
        $waitingAdmin = App\Models\CsRoom::where('chat_status', 'Admin')->whereNull('admin_id')->count();
    @endphp
    @php
        $warningSerials = [];
        $serialsAll = App\Models\Serial::with(['classrooms', 'user'])->get();

        foreach ($serialsAll as $serial) {
            $kelasCount = $serial->classrooms->count();
            $paketCount = (int) ($serial->paket ?? 1);

            if ($kelasCount > $paketCount) {
                $warningSerials[] = [
                    'kode_serial' => $serial->serial ?? '-',
                    'paket' => $paketCount,
                    'kelas' => $kelasCount,
                    'username' => $serial->user->username ?? 'Tidak Ada Pengguna',
                    'daftar_kelas' => $serial->classrooms->pluck('name')->toArray(),
                ];
            }
        }
        $warningSerialCount = count($warningSerials);
    @endphp
    @php
        use Illuminate\Support\Facades\DB;

        $totalUnansweredCount = DB::table('unanswered_questions')->sum('count');
    @endphp

    <!-- Mobile sidebar overlay -->
    <div id="sidebarOverlay"></div>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            {{-- Sidebar Sneat --}}
            @include('admin.layouts.partials.sidebar')

            <div class="layout-page">

                <!-- ═══ NAVBAR ═══ -->
                <nav class="layout-navbar navbar navbar-expand-xl px-4" id="layout-navbar">
                    <div class="navbar-nav-right d-flex align-items-center w-100 gap-3">

                        <!-- Toggle Sidebar -->
                        <button id="sidebarToggleBtn" title="Toggle Sidebar">
                            <i class="bi bi-layout-sidebar"></i>
                        </button>

                        <!-- Burger (mobile) -->
                        <button class="layout-menu-toggle navbar-toggler d-xl-none border-0 bg-transparent"
                            type="button" id="mobileSidebarToggle">
                            <i class="bi bi-list fs-5"></i>
                        </button>

                        <!-- Judul Halaman — rata kiri, dekat tombol sidebar -->
                        <span class="navbar-page-title">@yield('page_title', 'Admin')</span>

                        <!-- Spacer -->
                        <div class="flex-grow-1"></div>

                        <!-- Tombol Toggle Notifikasi -->
                        @php $hasAnyAlertNav = ($expired14Months > 0 || $warningNoEmail > 0 || $waitingAdmin > 0 || $totalUnansweredCount > 20 ||    $warningSerialCount > 0 ); @endphp
                        @if ($hasAnyAlertNav)
                            <button id="navAlertToggleBtn" title="Notifikasi" class="navbar-icon-btn position-relative">
                                <i class="bi bi-bell" id="navBellIcon"></i>
                                <span class="nav-alert-dot"></span>
                            </button>
                        @endif

                        <!-- Profil User -->
                        <a href="{{ route('admin.profil.index') }}" class="navbar-user-link">
                            <span class="d-none d-sm-inline">{{ Auth::user()->username ?? 'Admin' }}</span>
                            <i class="fas fa-user-circle fs-5"></i>
                        </a>

                    </div>
                </nav>
                <!-- ═══ END NAVBAR ═══ -->

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">

                        {{-- SWEETALERT SESSIONS --}}
                        @if (session('success'))
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: "{{ session('success') }}",
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            </script>
                        @endif
                        @if (session('error'))
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: "{{ session('error') }}",
                                })
                            </script>
                        @endif
                        @if ($errors->any())
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    html: `{!! implode('<br>', $errors->all()) !!}`,
                                });
                            </script>
                        @endif

                        {{-- ═══ GLOBAL ALERT BOX ═══ --}}
                        @if ($hasAnyAlertNav)
                            <div id="globalAlertBox">

                                @if ($expired14Months > 0)
                                    <div class="alert alert-danger" role="alert">
                                        <div class="alert-left">
                                            <i class="fas fa-circle-xmark"></i>
                                            <span><b>{{ $expired14Months }}</b> serial expired lebih dari 14
                                                bulan</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('admin.serial.index') }}"
                                                class="btn btn-sm btn-danger">Lihat</a>
                                            <button class="alert-close" onclick="closeAlert(this)" title="Tutup">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @if ($warningSerialCount > 0)
                                    <div class="alert alert-warning" role="alert">
                                        <div class="alert-left">
                                            <i class="fas fa-triangle-exclamation"></i>
                                            <span><b>{{ $warningSerialCount }}</b> serial melebihi batas kelas yang
                                                diizinkan</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('admin.kelas.index') }}"
                                                class="btn btn-sm btn-warning">Lihat</a>
                                            <button class="alert-close" onclick="closeAlert(this)" title="Tutup">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @if ($waitingAdmin > 0)
                                    <div class="alert alert-info" role="alert">
                                        <div class="alert-left">
                                            <i class="fas fa-user-clock"></i>
                                            <span><b>{{ $waitingAdmin }}</b> layanan pelanggan menunggu penanganan
                                                admin</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('admin.layanan-pelanggan.index') }}"
                                                class="btn btn-sm btn-info text-white">Lihat</a>
                                            <button class="alert-close" onclick="closeAlert(this)" title="Tutup">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @if ($warningNoEmail > 0)
                                    <div class="alert alert-secondary" role="alert">
                                        <div class="alert-left">
                                            <i class="fas fa-envelope-open-text"></i>
                                            <span><b>{{ $warningNoEmail }}</b> serial gagal kirim peringatan — email
                                                kosong</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('admin.serial.index') }}"
                                                class="btn btn-sm btn-secondary text-white">Lihat</a>
                                            <button class="alert-close" onclick="closeAlert(this)" title="Tutup">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @if ($totalUnansweredCount > 20)
                                    <div class="alert alert-dark" role="alert">
                                        <div class="alert-left">
                                            <i class="fas fa-circle-question"></i>
                                            <span>Total pertanyaan tidak terjawab melebihi batas maksimum</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('admin.pertanyaan-tidak-terjawab.index') }}"
                                                class="btn btn-sm btn-dark">Lihat</a>
                                            <button class="alert-close" onclick="closeAlert(this)" title="Tutup">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                            </div>{{-- #globalAlertBox --}}
                        @endif
                        {{-- ═══ END GLOBAL ALERT BOX ═══ --}}

                        {{-- WRAPPER ISI HALAMAN --}}
                        <div class="content-body">

                            {{-- CEK AKSES ROLE --}}
                            @if (isset($allowedForThisUser) && !$allowedForThisUser)
                                <div class="d-flex justify-content-center my-5">
                                    <div class="alert alert-danger text-center p-4 w-75 shadow-sm rounded-4">
                                        <h3 class="fw-bold mb-3">
                                            <i class="fas fa-ban me-2"></i> Akses Ditolak
                                        </h3>
                                        <p class="mb-3">
                                            Role Anda saat ini <strong>tidak sesuai</strong> untuk mengakses halaman
                                            ini.<br>
                                            Halaman yang Anda buka memiliki batasan akses khusus sesuai kategori peran.
                                        </p>
                                        <p class="text-muted mb-4">
                                            Jika Anda merasa ini adalah sebuah kesalahan, <br>
                                            <strong>harap segera menghubungi Super-Admin</strong> untuk peninjauan hak
                                            akses.
                                        </p>

                                        <div class="mb-3">
                                            <strong class="d-block mb-1">Role Anda:</strong>
                                            @switch($userRole)
                                                @case(1)
                                                    <span class="badge bg-dark px-3 py-2">Super-Admin</span>
                                                @break

                                                @case(2)
                                                    <span class="badge bg-primary px-3 py-2">Admin</span>
                                                @break

                                                @case(3)
                                                    <span class="badge bg-success px-3 py-2">Operasional</span>
                                                @break

                                                @case(4)
                                                    <span
                                                        class="badge bg-warning text-dark px-3 py-2">Konten-Pembelajaran</span>
                                                @break

                                                @case(5)
                                                    <span class="badge bg-info text-dark px-3 py-2">Layanan-Pengguna</span>
                                                @break

                                                @default
                                                    <span class="badge bg-secondary px-3 py-2">Tidak Aktif</span>
                                            @endswitch
                                        </div>

                                        <div class="mt-4">
                                            <strong class="d-block mb-2">Role yang diizinkan untuk halaman
                                                ini:</strong>
                                            @foreach ($allowedRoles as $r)
                                                @switch($r)
                                                    @case(1)
                                                        <span class="badge bg-dark px-3 py-2 m-1">Super-Admin</span>
                                                    @break

                                                    @case(2)
                                                        <span class="badge bg-primary px-3 py-2 m-1">Admin</span>
                                                    @break

                                                    @case(3)
                                                        <span class="badge bg-success px-3 py-2 m-1">Operasional</span>
                                                    @break

                                                    @case(4)
                                                        <span
                                                            class="badge bg-warning text-dark px-3 py-2 m-1">Konten-Pembelajaran</span>
                                                    @break

                                                    @case(5)
                                                        <span
                                                            class="badge bg-info text-dark px-3 py-2 m-1">Layanan-Pengguna</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-secondary px-3 py-2 m-1">Tidak Aktif</span>
                                                @endswitch
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                @php return; @endphp
                            @endif

                            {{-- Tombol Kembali Otomatis --}}
                            @php $segmentCount = count(Request::segments()); @endphp
                            @if ($segmentCount > 3 && Request::segment(1) === 'admin')
                                <button type="button" class="btn btn-secondary mb-2" onclick="history.back()">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </button>
                            @endif
                            <div class="card mb-4">
                                <div class="card-body" style="zoom: 75%;">
                                    @yield('content')
                                </div>
                            </div>

                        </div>{{-- .content-body --}}
                    </div>

                    <!-- FOOTER -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div class="text-center py-2 small">
                                © {{ date('Y') }} — Admin Panel
                            </div>
                        </div>
                    </footer>
                </div>

            </div>{{-- .layout-page --}}
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Sneat Core JS -->
    <script src="{{ asset('assets_sneat/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets_sneat/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets_sneat/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets_sneat/js/main.js') }}"></script>

    <script>
        const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');

        if (sidebarToggleBtn) {
            sidebarToggleBtn.addEventListener('click', function() {
                document.body.classList.toggle('sidebar-collapsed');
            });
        }

        /* ============================================================
           MOBILE SIDEBAR TOGGLE
        ============================================================ */
        const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const layoutMenu = document.querySelector('.layout-menu');

        function openMobileSidebar() {
            if (layoutMenu) layoutMenu.classList.add('mobile-open');
            if (sidebarOverlay) sidebarOverlay.classList.add('active');
        }

        function closeMobileSidebar() {
            if (layoutMenu) layoutMenu.classList.remove('mobile-open');
            if (sidebarOverlay) sidebarOverlay.classList.remove('active');
            // Sneat kadang pakai class ini juga
            document.documentElement.classList.remove('layout-menu-expanded');
        }

        if (mobileSidebarToggle) {
            mobileSidebarToggle.addEventListener('click', openMobileSidebar);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function(e) {
                e.stopPropagation();
                closeMobileSidebar();
            });
        }
        /* ============================================================
           ALERT — SEMBUNYIKAN INDIVIDUAL (tombol X)
        ============================================================ */
        function closeAlert(btn) {
            const alertEl = btn.closest('.alert');
            if (!alertEl) return;
            alertEl.classList.add('alert-fade-out');
            setTimeout(() => alertEl.remove(), 280);
        }

        /* ============================================================
           ALERT — TOGGLE via TOMBOL BELL di NAVBAR
           sessionStorage:
             'hideAlert' = 'true'  → tersembunyi
             default / null        → tampil
           Logout → sessionStorage terhapus → muncul lagi
        ============================================================ */
        const navAlertToggleBtn = document.getElementById('navAlertToggleBtn');
        const globalAlertBox = document.getElementById('globalAlertBox');
        const navBellIcon = document.getElementById('navBellIcon');
        const navAlertDot = navAlertToggleBtn ? navAlertToggleBtn.querySelector('.nav-alert-dot') : null;

        function setAlertVisible(visible) {
            if (!globalAlertBox) return;
            if (visible) {
                globalAlertBox.style.display = '';
                sessionStorage.removeItem('hideAlert');
                if (navBellIcon) {
                    navBellIcon.className = 'bi bi-bell';
                }
                if (navAlertDot) {
                    navAlertDot.classList.remove('muted');
                }
                if (navAlertToggleBtn) navAlertToggleBtn.title = 'Sembunyikan Notifikasi';
            } else {
                globalAlertBox.style.display = 'none';
                sessionStorage.setItem('hideAlert', 'true');
                if (navBellIcon) {
                    navBellIcon.className = 'bi bi-bell-slash';
                }
                if (navAlertDot) {
                    navAlertDot.classList.add('muted');
                }
                if (navAlertToggleBtn) navAlertToggleBtn.title = 'Tampilkan Notifikasi';
            }
        }

        // Terapkan state saat load
        const isHidden = sessionStorage.getItem('hideAlert') === 'true';
        setAlertVisible(!isHidden);

        // Klik bell → toggle
        if (navAlertToggleBtn) {
            navAlertToggleBtn.addEventListener('click', function() {
                const currentlyHidden = globalAlertBox && globalAlertBox.style.display === 'none';
                setAlertVisible(currentlyHidden); // kalau hidden, tampilkan; vice versa
            });
        }
    </script>

    @yield('js')

</body>

</html>
