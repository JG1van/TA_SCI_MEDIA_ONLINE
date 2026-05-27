<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SCI Media Online — Platform Pembelajaran Digital</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,300&family=Syne:wght@600;700;800&display=swap"
        rel="stylesheet" />
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <!-- ==================== NAVBAR ==================== -->
    <nav class="navbar navbar-expand-lg" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#">SCI <span>Media</span> Online</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
                style="color:rgba(255,255,255,0.7);">
                <i class="bi bi-list" style="font-size:1.5rem;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-center gap-1">
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#cara-pakai">Cara Pakai</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimoni">Testimoni</a></li>
                    <li class="nav-item"><a class="nav-link" href="#bantuan">Bantuan</a></li>
                    <li class="nav-item ms-2">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#popupLogin" class="nav-login-btn">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Modal -->
    <div class="modal fade" id="popupLogin" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-box-arrow-in-right me-2"></i>Pilih Role Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body d-flex flex-column gap-3">
                    <a href="{{ route('login') }}" class="modal-login-btn admin">
                        <i class="bi bi-shield-lock me-2"></i>Login sebagai Admin
                    </a>
                    <a href="#" class="modal-login-btn guru">
                        <i class="bi bi-person-badge me-2"></i>Login sebagai Guru
                    </a>
                    <a href="#" class="modal-login-btn siswa">
                        <i class="bi bi-backpack me-2"></i>Login sebagai Siswa
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Store Modal -->
    <div class="modal fade" id="popupTokoOnline" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-shop me-2"></i>Toko Online Resmi SCI Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body d-flex flex-column gap-2">
                    <p class="text-muted mb-2" style="font-size:0.85rem;">Pilih platform untuk pembelian produk resmi:
                    </p>
                    <a href="https://scimedia.co.id/" target="_blank" class="store-btn">
                        <div class="store-btn-icon" style="background:#1E4FD8;color:white;"><i class="bi bi-globe"></i>
                        </div>
                        <span>SCI Media Website</span>
                        <i class="bi bi-arrow-right ms-auto text-muted" style="font-size:0.9rem;"></i>
                    </a>
                    <a href="https://www.tokopedia.com/sci-media" target="_blank" class="store-btn">
                        <div class="store-btn-icon" style="background:#42B549;color:white;"><i class="bi bi-bag"></i>
                        </div>
                        <span>Tokopedia</span>
                        <i class="bi bi-arrow-right ms-auto text-muted" style="font-size:0.9rem;"></i>
                    </a>
                    <a href="https://id.shp.ee/Lgf5Frg" target="_blank" class="store-btn">
                        <div class="store-btn-icon" style="background:#EE4D2D;color:white;"><i
                                class="bi bi-bag-heart"></i></div>
                        <span>Shopee</span>
                        <i class="bi bi-arrow-right ms-auto text-muted" style="font-size:0.9rem;"></i>
                    </a>
                    <a href="https://siplahtelkom.com/product/alat-peraga-sekolah/1932102-media-ajar-sci-rpp-dan-adminitrasi-guru-"
                        target="_blank" class="store-btn">
                        <div class="store-btn-icon" style="background:#E40521;color:white;"><i
                                class="bi bi-building"></i></div>
                        <span>Siplah Telkom</span>
                        <i class="bi bi-arrow-right ms-auto text-muted" style="font-size:0.9rem;"></i>
                    </a>
                    <a href="https://siplah.blibli.com/merchant-detail/SSME-0028?itemPerPage=40&page=0&merchantId=SSME-0028"
                        target="_blank" class="store-btn">
                        <div class="store-btn-icon" style="background:#0F146D;color:white;"><i
                                class="bi bi-cart"></i></div>
                        <span>Siplah Blibli</span>
                        <i class="bi bi-arrow-right ms-auto text-muted" style="font-size:0.9rem;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== HERO ==================== -->
    <section class="hero" id="beranda">
        <div class="hero-mesh"></div>
        <div class="hero-grid-lines"></div>
        <div class="container">
            <div class="row align-items-center gy-5">
                <!-- Text -->
                <div class="col-lg-6 hero-content" data-aos="fade-right" data-aos-duration="900">
                    <div class="hero-badge">Platform LMS Terpercaya</div>
                    <h1 class="hero-title">
                        Pembelajaran Digital
                        <span class="highlight">Lebih Mudah</span>,
                        Lebih Modern
                    </h1>
                    <p class="hero-subtitle">
                        SCI Media Online menghadirkan solusi Learning Management System (LMS) yang fleksibel dan mudah
                        diakses kapan saja, di mana saja — untuk guru dan siswa Indonesia.
                    </p>
                    <div class="hero-cta-group">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#popupLogin"
                            class="btn-primary-sci">
                            <i class="bi bi-rocket-takeoff"></i> Mulai Sekarang
                        </a>
                        <a href="#fitur" class="btn-outline-sci">
                            <i class="bi bi-grid-3x3-gap"></i> Lihat Fitur
                        </a>
                    </div>
                    <div class="hero-stats text-center">
                        <div class="text-center">
                            <div class="hero-stat-num">45</div>
                            <div class="hero-stat-label">Siswa per kelas</div>
                        </div>

                        <div class="text-center">
                            <div class="hero-stat-num">12</div>
                            <div class="hero-stat-label">Fitur unggulan</div>
                        </div>

                        <div class="text-center">
                            <div class="hero-stat-num">100%</div>
                            <div class="hero-stat-label">Akses fleksibel</div>
                        </div>
                    </div>
                </div>

                <!-- Visual -->
                <div class="col-lg-6 hero-visual hero-svg-wrapper" data-aos="fade-left " data-aos-duration="900"
                    data-aos-delay="150">
                    <div class="position-relative"style="padding: 30px 30px 30px 0;">
                        <svg width="100%" height="auto" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg"
                            style="max-width:900px; display:block; margin:0 auto;">
                            <defs>
                                <clipPath id="clipLogo">
                                    <circle cx="250" cy="230" r="110" />
                                </clipPath>
                            </defs>

                            <!-- Lingkaran orbit luar (dekoratif) -->
                            <circle cx="250" cy="230" r="175" fill="none" stroke="#3a86c8"
                                stroke-width="1" opacity="0.15" />
                            <circle cx="250" cy="230" r="145" fill="none" stroke="#3a86c8"
                                stroke-width="1" opacity="0.2" />

                            <!-- Titik-titik orbit -->
                            <circle cx="75" cy="230" r="8" fill="#b8d9f5" opacity="0.7" />
                            <circle cx="425" cy="230" r="8" fill="#b8d9f5" opacity="0.7" />
                            <circle cx="155" cy="80" r="12" fill="#ddeefa" opacity="0.8" />
                            <circle cx="345" cy="80" r="6" fill="#b8d9f5" opacity="0.6" />
                            <circle cx="140" cy="385" r="7" fill="#c7e5f8" opacity="0.6" />
                            <circle cx="365" cy="370" r="11" fill="#ddeefa" opacity="0.7" />

                            <!-- Lingkaran background utama -->
                            <circle cx="250" cy="230" r="130" fill="#edf6ff" stroke="#b8d9f5"
                                stroke-width="1.5" />

                            <!-- Lingkaran dalam putih (wadah logo) -->
                            <circle cx="250" cy="230" r="112" fill="white" stroke="#d4eaf9"
                                stroke-width="1" />

                            <!-- Logo -->
                            <image href="{{ asset('images/logo1.webp') }}" x="140" y="120" width="220"
                                height="220" preserveAspectRatio="xMidYMid meet" clip-path="url(#clipLogo)" />

                            <!-- Ikon dekoratif kiri bawah: buku -->
                            <g transform="translate(62, 330)">
                                <rect x="0" y="0" width="38" height="28" rx="4" fill="#3a86c8"
                                    opacity="0.18" />
                                <rect x="4" y="4" width="30" height="20" rx="2" fill="#3a86c8"
                                    opacity="0.25" />
                                <line x1="19" y1="4" x2="19" y2="24" stroke="#3a86c8"
                                    stroke-width="1.5" opacity="0.4" />
                            </g>

                            <!-- Ikon dekoratif kanan atas: pensil -->
                            <g transform="translate(378, 95) rotate(30)">
                                <rect x="0" y="0" width="8" height="36" rx="2" fill="#3a86c8"
                                    opacity="0.25" />
                                <polygon points="0,36 8,36 4,44" fill="#3a86c8" opacity="0.3" />
                                <rect x="0" y="0" width="8" height="6" rx="2" fill="#aaa"
                                    opacity="0.3" />
                            </g>

                            <!-- Ikon dekoratif kanan bawah: bintang kecil -->
                            <g transform="translate(370, 355)">
                                <circle cx="12" cy="12" r="12" fill="#edf6ff" stroke="#b8d9f5"
                                    stroke-width="1" />
                                <polygon points="12,4 14,10 20,10 15,14 17,20 12,16 7,20 9,14 4,10 10,10"
                                    fill="#3a86c8" opacity="0.35" />
                            </g>

                        </svg>
                    </div>
                </div>




            </div>
        </div>
    </section>

    <!-- ==================== ABOUT ==================== -->
    <section class="about-section" id="tentang">
        <div class="container">
            <div class="row align-items-center gy-5">

                <div class="col-lg-5" data-aos="fade-right">
                    <div class="section-label">Tentang Kami</div>
                    <h2 class="section-title mb-4">Solusi LMS untuk Pendidikan Indonesia</h2>
                    <p style="color:var(--c-text-light);font-size:0.97rem;line-height:1.8;margin-bottom:1.5rem;">
                        <strong>SCI Media</strong> adalah perusahaan penyedia solusi pendidikan digital yang
                        mengembangkan <strong>SCI Media Online</strong> — platform Learning Management System (LMS)
                        untuk mendukung proses pembelajaran guru dan siswa secara modern dan efektif.
                    </p>
                    <div>
                        <div class="about-list-item">
                            <div class="about-check"><i class="bi bi-check-lg"></i></div>
                            <div class="about-list-text">Akses melalui <strong>browser</strong> di
                                <strong>scimediaonline.com</strong>
                            </div>
                        </div>
                        <div class="about-list-item">
                            <div class="about-check"><i class="bi bi-check-lg"></i></div>
                            <div class="about-list-text">Tersedia aplikasi <strong>Android</strong> di Google Play
                                Store</div>
                        </div>
                        <div class="about-list-item">
                            <div class="about-check"><i class="bi bi-check-lg"></i></div>
                            <div class="about-list-text">Dapat diakses dari <strong>HP maupun laptop</strong></div>
                        </div>
                        <div class="about-list-item">
                            <div class="about-check"><i class="bi bi-check-lg"></i></div>
                            <div class="about-list-text">Akses <strong>kapan saja dan di mana saja</strong> tanpa batas
                            </div>
                        </div>
                        <div class="about-list-item">
                            <div class="about-check"><i class="bi bi-check-lg"></i></div>
                            <div class="about-list-text">Antarmuka <strong>fleksibel dan mudah digunakan</strong></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 offset-lg-1" data-aos="fade-left" data-aos-delay="150">
                    <div class="about-visual-grid">
                        <div class="about-card">
                            <div class="about-card-icon"><i class="bi bi-mortarboard"></i></div>
                            <div class="about-card-title">Dirancang untuk Guru</div>
                            <div class="about-card-text">Kelola kelas, materi, dan penilaian dari satu dashboard
                                terpadu.</div>
                        </div>
                        <div class="about-card">
                            <div class="about-card-icon"><i class="bi bi-people"></i></div>
                            <div class="about-card-title">Fokus pada Siswa</div>
                            <div class="about-card-text">Pengalaman belajar interaktif, kuis, dan diskusi langsung.
                            </div>
                        </div>
                        <div class="about-card span2">
                            <div class="about-card-icon"><i class="bi bi-shield-check"></i></div>
                            <div class="about-card-title">Platform Terpercaya</div>
                            <div class="about-card-text">Dikembangkan khusus untuk kebutuhan pendidikan dasar Indonesia
                                dengan fitur KI1, KI2, rekap nilai, dan pelaporan terintegrasi.</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==================== FEATURES ==================== -->
    <section class="features-section" id="fitur">
        <div class="container" style="position:relative;z-index:2;">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="section-label dark" style="margin:0 auto 1rem;">Fitur Lengkap</div>
                <h2 class="section-title light mb-3">Semua yang Anda Butuhkan</h2>
                <p class="section-subtitle light">Lengkap, terintegrasi, dan siap mendukung pembelajaran digital</p>
            </div>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-3 g-2 px-1">

                <!-- Baris 1: Kelas & Siswa -->
                <div class="col" data-aos="fade-up" data-aos-delay="50">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-people-fill"></i></div>
                        <div class="feature-title">Manajemen Kelas & Siswa</div>
                        <div class="feature-desc">Kelola hingga 45 siswa per kelas dengan data dan aktivitas
                            pembelajaran lengkap.</div>
                    </div>
                </div>

                <div class="col" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-broadcast-pin"></i></div>
                        <div class="feature-title">Kelas Online</div>
                        <div class="feature-desc">Tatap muka virtual interaktif langsung antara guru dan siswa kapan
                            saja.</div>
                    </div>
                </div>

                <div class="col" data-aos="fade-up" data-aos-delay="150">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-chat-square-text"></i></div>
                        <div class="feature-title">Diskusi Pembelajaran</div>
                        <div class="feature-desc">Fitur diskusi langsung antara siswa dan guru pada setiap soal materi.
                        </div>
                    </div>
                </div>

                <!-- Baris 2: Materi -->
                <div class="col" data-aos="fade-up" data-aos-delay="50">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-book-half"></i></div>
                        <div class="feature-title">Bank Materi</div>
                        <div class="feature-desc">Bank materi siap pakai — tinggal pilih dan langsung share ke kelas
                            tanpa perlu menyiapkan dari nol.</div>
                    </div>
                </div>

                <div class="col" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-file-earmark-text"></i></div>
                        <div class="feature-title">Buat Materi Sendiri</div>
                        <div class="feature-desc">Buat dan susun materi pembelajaran sesuai gaya mengajar dan kebutuhan
                            kurikulum Anda sendiri.</div>
                    </div>
                </div>

                <div class="col" data-aos="fade-up" data-aos-delay="150">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-graph-up-arrow"></i></div>
                        <div class="feature-title">Penilaian Terintegrasi</div>
                        <div class="feature-desc">Penilaian otomatis per KD, nilai ulangan, hingga rekap laporan dalam
                            satu sistem.</div>
                    </div>
                </div>

                <!-- Baris 3: Soal -->
                <div class="col" data-aos="fade-up" data-aos-delay="50">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-pencil-square"></i></div>
                        <div class="feature-title">Bank Soal</div>
                        <div class="feature-desc">Bank soal siap pakai — tinggal pilih dan langsung share ke kelas,
                            hemat waktu persiapan.</div>
                    </div>
                </div>

                <div class="col" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-pencil-fill"></i></div>
                        <div class="feature-title">Buat Soal Sendiri</div>
                        <div class="feature-desc">Rancang soal latihan atau ujian secara mandiri dengan editor soal
                            yang mudah digunakan.</div>
                    </div>
                </div>

                <div class="col" data-aos="fade-up" data-aos-delay="150">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-stars"></i></div>
                        <div class="feature-title">Generate Soal dengan AI</div>
                        <div class="feature-desc">Buat soal otomatis dalam hitungan detik menggunakan kecerdasan buatan
                            berdasarkan materi yang dipilih.</div>
                    </div>
                </div>

                <!-- Baris 4: Penilaian & Sikap -->
                <div class="col" data-aos="fade-up" data-aos-delay="50">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-bar-chart-line"></i></div>
                        <div class="feature-title">Monitoring Kuis</div>
                        <div class="feature-desc">Pantau aktivitas kuis siswa secara real-time termasuk status dan
                            hasil pengerjaan.</div>
                    </div>
                </div>

                <div class="col" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-bookmark-star"></i></div>
                        <div class="feature-title">Rekam KI1 & KI2</div>
                        <div class="feature-desc">Pencatatan sikap spiritual dan sosial siswa secara otomatis dan
                            terstruktur.</div>
                    </div>
                </div>

                <div class="col" data-aos="fade-up" data-aos-delay="150">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-person-circle"></i></div>
                        <div class="feature-title">Manajemen Profil</div>
                        <div class="feature-desc">Kelola akun, data pribadi, dan keamanan dengan tampilan yang mudah
                            dipahami.</div>
                    </div>
                </div>

                <!-- Baris 5: Pendukung -->
                <div class="col" data-aos="fade-up" data-aos-delay="50">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-headset"></i></div>
                        <div class="feature-title">Layanan Pelanggan</div>
                        <div class="feature-desc">Dukungan melalui QnA, chatbot, hingga admin untuk membantu pengguna.
                        </div>
                    </div>
                </div>

                <div class="col" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-bell-fill"></i></div>
                        <div class="feature-title">Notifikasi Masa Aktif</div>
                        <div class="feature-desc">Pemberitahuan otomatis saat masa aktif serial akan habis atau
                            kedaluwarsa.</div>
                    </div>
                </div>

                <div class="col" data-aos="fade-up" data-aos-delay="150">
                    <div class="feature-card">
                        <div class="feature-icon-wrap"><i class="bi bi-phone-fill"></i></div>
                        <div class="feature-title">Akses Fleksibel</div>
                        <div class="feature-desc">Akses dari berbagai perangkat — HP, tablet, atau laptop — kapan saja
                            dan di mana saja.</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==================== HOW IT WORKS ==================== -->
    <section class="howto-section" id="cara-pakai">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="section-label" style="margin:0 auto 1rem;">Cara Pakai</div>
                <h2 class="section-title mb-3">Mulai dalam 3 Langkah Mudah</h2>
                <p class="section-subtitle">Mudah diakses dan mudah didapatkan</p>
            </div>

            <div class="row gy-4 mb-5">
                <div class="col-12">
                    <h4
                        style="font-family:var(--font-display);font-weight:700;color:var(--c-text);margin-bottom:1.5rem;font-size:1.1rem;letter-spacing:-0.01em;">
                        <span style="color:var(--c-blue);">A.</span> Cara Akses Aplikasi
                    </h4>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="50">
                    <div class="step-card">
                        <div class="step-number">01</div>
                        <div class="step-icon"><i class="bi bi-globe"></i></div>
                        <div class="step-title">Melalui Browser</div>
                        <div class="step-desc">Akses langsung melalui <strong>scimediaonline.com</strong> dari browser
                            favorit Anda.</div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-card">
                        <div class="step-number">02</div>
                        <div class="step-icon"><i class="bi bi-phone"></i></div>
                        <div class="step-title">Aplikasi Android</div>
                        <div class="step-desc">Download <strong>"SCI Media Online"</strong> di Google Play Store untuk
                            pengalaman lebih praktis dari genggaman.</div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
                    <div class="step-card">
                        <div class="step-number">03</div>
                        <div class="step-icon"><i class="bi bi-wifi"></i></div>
                        <div class="step-title">Koneksi Internet</div>
                        <div class="step-desc">Pastikan perangkat Anda terhubung dengan koneksi internet yang stabil
                            untuk pengalaman terbaik.</div>
                    </div>
                </div>
            </div>

            <div class="row gy-4 mt-2">
                <div class="col-12">
                    <h4
                        style="font-family:var(--font-display);font-weight:700;color:var(--c-text);margin-bottom:1.5rem;font-size:1.1rem;letter-spacing:-0.01em;">
                        <span style="color:var(--c-blue);">B.</span> Cara Mendapatkan Akun & Kode Serial
                    </h4>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="50">
                    <div class="step-card">
                        <div class="step-number">01</div>
                        <div class="step-icon"><i class="bi bi-person-plus"></i></div>
                        <div class="step-title">Buat / Dapatkan Akun</div>
                        <div class="step-desc">Daftarkan akun melalui halaman registrasi atau hubungi admin untuk
                            dibuatkan akun.</div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-card">
                        <div class="step-number">02</div>
                        <div class="step-icon"><i class="bi bi-chat-dots"></i></div>
                        <div class="step-title">Hubungi Admin SCI</div>
                        <div class="step-desc">Setelah memiliki akun, hubungi admin SCI Media untuk mengajukan
                            permintaan kode serial.</div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
                    <div class="step-card">
                        <div class="step-number">03</div>
                        <div class="step-icon"><i class="bi bi-key"></i></div>
                        <div class="step-title">Dapatkan Kode Serial</div>
                        <div class="step-desc">Kirim bukti pembelian jika sudah memiliki produk, atau ikuti arahan
                            admin untuk mendapatkan serial.</div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ==================== TESTIMONIALS ==================== -->
    <section class="testimonials-section" id="testimoni">
        <div class="container" style="position:relative;z-index:2;">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="section-label dark" style="margin:0 auto 1rem;">Testimoni</div>
                <h2 class="section-title light mb-3">Kata Mereka tentang SCI Media</h2>
                <p class="section-subtitle light">Guru-guru yang telah merasakan manfaatnya</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="50">
                    <div class="testi-card">
                        <div class="testi-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i></div>
                        <div class="testi-quote-icon">"</div>
                        <p class="testi-text">SCI Media Online sangat membantu saya mengelola pembelajaran jarak jauh.
                            Fitur-fiturnya lengkap dan mudah digunakan!</p>
                        <div class="testi-author">
                            <div class="testi-avatar">JO</div>
                            <div>
                                <div class="testi-name">Jojo</div>
                                <div class="testi-role">Guru SD · Jawa Barat</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testi-card">
                        <div class="testi-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i></div>
                        <div class="testi-quote-icon">"</div>
                        <p class="testi-text">Dengan SCI Media Online, saya bisa memantau perkembangan siswa secara
                            real-time. Rekap nilai otomatis sangat menghemat waktu.</p>
                        <div class="testi-author">
                            <div class="testi-avatar">FA</div>
                            <div>
                                <div class="testi-name">Fahri</div>
                                <div class="testi-role">Guru SD · Jawa Tengah</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
                    <div class="testi-card">
                        <div class="testi-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i></div>
                        <div class="testi-quote-icon">"</div>
                        <p class="testi-text">Materi video bernarasi dan bank soal yang tersedia membuat persiapan
                            mengajar jadi lebih efisien. Sangat direkomendasikan!</p>
                        <div class="testi-author">
                            <div class="testi-avatar">FS</div>
                            <div>
                                <div class="testi-name">Faisal</div>
                                <div class="testi-role">Guru SD · DKI Jakarta</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- ==================== HELP / FAQ ==================== -->
    <section class="help-section" id="bantuan">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12" data-aos="fade-up">
                    <div class="help-card">
                        <div class="help-icon">
                            <i class="bi bi-life-preserver"></i>
                        </div>
                        <h2 class="help-title">Butuh Bantuan atau Ada Pertanyaan?</h2>
                        <p class="help-desc">
                            Jika Anda mengalami kendala atau ingin mengajukan pertanyaan, silakan gunakan fitur Pusat
                            Layanan Pelanggan SCI Media yang telah kami sediakan. Klik tombol di bawah ini untuk memilih
                            menu layanan sesuai kebutuhan Anda.
                        </p>
                        <a href="{{ route('layanan-pelanggan.index') }}" class="btn-primary-sci"
                            style="display:inline-flex; width:auto; margin:0 auto;">
                            <i class="bi bi-chat-dots-fill"></i> Pergi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ==================== CTA ==================== -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-inner" data-aos="fade-up">
                <div class="cta-content">
                    <h2 class="cta-title">Siap Memulai Pembelajaran Digital?</h2>

                    <p class="cta-subtitle">
                        Pesan Media Ajar SCI Media untuk mendapatkan akses ke SCI Media Online,
                        atau hubungi admin untuk mendapatkan arahan lebih lanjut terkait pembelian dan aktivasi.
                    </p>

                    <div class="cta-btn-group">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#popupTokoOnline"
                            class="btn-cta-primary">
                            <i class="bi bi-cart-check-fill"></i> Pesan Media Ajar
                        </a>

                        <a href="{{ route('layanan-pelanggan.index') }}" class="btn-cta-secondary">
                            <i class="bi bi-chat-dots-fill"></i> Hubungi Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== FOOTER ==================== -->
    <footer id="kontak">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-6">
                    <div class="footer-brand">SCI <span>Media</span> Online</div>
                    <p class="footer-desc">
                        Platform Learning Management System (LMS) terpercaya yang dirancang untuk mendukung proses
                        pembelajaran digital secara efektif, fleksibel, dan mudah digunakan di seluruh Indonesia.
                    </p>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="footer-heading">Navigasi</div>
                    <a href="#tentang" class="footer-link"><i class="bi bi-chevron-right"></i>Tentang Kami</a>
                    <a href="#fitur" class="footer-link"><i class="bi bi-chevron-right"></i>Fitur Lengkap</a>
                    <a href="#cara-pakai" class="footer-link"><i class="bi bi-chevron-right"></i>Cara Pakai</a>
                    <a href="#bantuan" class="footer-link"><i class="bi bi-chevron-right"></i>Bantuan</a>
                </div>
                <div class="col-lg-4 col-md-3">
                    <div class="footer-heading">Kontak</div>
                    <a href="https://wa.me/6282327042255" target="_blank" class="footer-link">
                        <i class="bi bi-whatsapp"></i> 0823-2704-2255
                    </a>
                    <a href="https://www.instagram.com/scimedia.id" target="_blank" class="footer-link">
                        <i class="bi bi-instagram"></i> @scimedia.id
                    </a>
                    <a href="https://scimediaonline.com/" target="_blank" class="footer-link">
                        <i class="bi bi-globe"></i> scimediaonline.com
                    </a>
                    <a href="https://scimedia.co.id/" target="_blank" class="footer-link">
                        <i class="bi bi-globe2"></i> scimedia.co.id
                    </a>
                    <a class="footer-link" style="cursor:default;">
                        <i class="bi bi-geo-alt"></i> Indonesia
                    </a>
                </div>
            </div>
            <hr class="footer-divider" />
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <p class="footer-bottom mb-0">&copy; 2026 SCI Media Online. Semua hak cipta dilindungi.</p>
                <p class="footer-bottom mb-0">Dikembangkan untuk transformasi pendidikan digital Indonesia.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 700,
            once: true,
            offset: 80,
            easing: 'ease-out-cubic'
        });

        // Navbar scroll effect
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 60);
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const target = document.querySelector(a.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close navbar on mobile
                    const collapse = document.getElementById('navMenu');
                    if (collapse.classList.contains('show')) {
                        bootstrap.Collapse.getInstance(collapse)?.hide();
                    }
                }
            });
        });
    </script>
</body>

</html>
