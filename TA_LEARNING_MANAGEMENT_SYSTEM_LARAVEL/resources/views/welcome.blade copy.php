<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> SCI Media Online - Platform Pembelajaran Digital</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

    <style>
        :root {
            --warna0: #ffffff;
            --warna1: #000000;
            --warna2: #3A59D1;
            --warna3: #3D90D7;
            --warna4: #7AC6D2;
            --warna5: #B5FCCD;
            --warna6: #edf2fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Public Sans", sans-serif;
            font-size: 17px;

            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        body {

            color: var(--warna1);
            background-color: var(--warna2);
            overflow-x: hidden;
            position: relative;
        }

        .modal-backdrop {
            z-index: auto !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {

            font-weight: 700;
        }

        .section {
            position: relative;

        }

        .section::before,
        .section::after {
            content: "";
            position: absolute;
            width: 90px;
            height: 90px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M0,0 Q25,0 25,25 L25,100 M0,0 Q0,25 25,25 L100,25' stroke='%23FFD8A3' stroke-width='7' fill='none' opacity='0.8'/%3E%3Ccircle cx='25' cy='25' r='5' fill='%23FFD8A3'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;

            opacity: 0.7;
            filter: drop-shadow(0px 0px 3px rgba(255, 215, 180, 0.6));
            pointer-events: none;
            z-index: 3;
        }



        .section::before {
            top: 20px;
            left: 20px;
        }

        .section::after {
            bottom: 20px;
            right: 20px;
            transform: rotate(180deg);
        }



        /* Navbar Styling - Wood texture effect */
        .navbar {
            background-color: var(--warna2);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4),
                inset 0 1px 0 rgba(255, 244, 224, 0.1);
            padding: 1rem 0;
            border-bottom: 3px solid var(--warna4);
            position: relative;
        }


        .navbar-brand {
            font-weight: 900;
            color: var(--warna0) !important;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 2;
        }

        .navbar-nav .nav-link {
            color: var(--warna6) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            position: relative;
            font-size: 12px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .navbar-nav .nav-link:hover {
            color: var(--warna0) !important;
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link::after {
            content: "";
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--warna4);
            transition: width 0.3s ease;
        }

        .navbar-nav .nav-link:hover::after {
            width: 80%;
        }

        .btn-primary-custom {
            background: var(--warna3);
            color: #fff;

            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            box-shadow:
                0 4px 0 #4a1212,
                0 5px 10px rgba(0, 0, 0, 0.4);
            position: relative;
            transition: all 0.2s;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 999;

            /* tambahan penting */
            text-decoration: none;
            display: inline-block;
            width: auto;
            min-width: 200px;
            /* opsional, biar seragam */
        }


        .btn-primary-custom:hover {
            transform: translateY(2px);
            box-shadow:
                0 2px 0 #4a1212,
                0 3px 5px rgba(0, 0, 0, 0.4);
            background: var(--warna4);
            color: #ffebc9;
        }

        .btn-primary-custom:active {
            transform: translateY(4px);
            box-shadow: none;
        }


        .btn-whatsapp {
            background: #25d366;
            border: 2px solid #128c7e;
            color: var(--warna0);
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
        }

        .btn-whatsapp:hover {
            background: #128c7e;
            transform: scale(1.05);
            box-shadow: 0 0 25px rgba(37, 211, 102, 0.7),
                0 6px 12px rgba(0, 0, 0, 0.3);
            color: var(--warna0);
        }

        /* Hero Section */
        .hero-section {
            margin-top: 90px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            background: var(--warna2);
            /* background: linear-gradient(135deg,
                    var(--warna5) 0%,
                    var(--warna6) 50%,
                    var(--warna5) 100%); */
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                linear-gradient(#7AC6D2, rgba(58, 89, 209, 0.7)),
                url("{{ asset('images/bg-2.svg') }}") center / cover no-repeat;

        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 900;
            color: var(--warna0);
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.15);
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--warna0);
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .hero-ornament {
            width: 100%;
            max-width: 500px;
            height: auto;
            filter: drop-shadow(4px 4px 8px rgba(0, 0, 0, 0.2));
        }

        /* Decorative Ornament */
        .ornament-divider {
            text-align: center;
            margin: 3rem 0;
            position: relative;
        }

        .ornament-divider svg {
            width: 120px;
            height: auto;
            fill: var(--warna3);
            opacity: 0.7;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.1));
        }

        /* Section Styling */
        .section {
            padding: 5rem 0;
            position: relative;
        }

        .section-title {
            font-size: 2.5rem;
            color: var(--warna2);
            text-align: center;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .section-title::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 4px;
            background: linear-gradient(to right,
                    transparent,
                    var(--warna4),
                    transparent);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .section-title::before {
            content: "◆";
            position: absolute;
            left: -30px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--warna4);
            font-size: 1rem;
        }

        .section-subtitle {
            text-align: center;
            color: var(--warna3);
            font-size: 1.1rem;
            margin-bottom: 3rem;
            font-style: italic;
        }

        #tentang,
        #fitur-guru,
        #cara-pakai,
        #faq {
            background-color: var(--warna6);
        }

        /* Card Styling with enhanced shadows */
        .feature-card {
            background-color: var(--warna0);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 200 200'%3E%3Cdefs%3E%3ClinearGradient id='a' gradientUnits='userSpaceOnUse' x1='88' y1='88' x2='0' y2='0'%3E%3Cstop offset='0' stop-color='%23B5FCCD'/%3E%3Cstop offset='1' stop-color='%23B5FCCD'/%3E%3C/linearGradient%3E%3ClinearGradient id='b' gradientUnits='userSpaceOnUse' x1='75' y1='76' x2='168' y2='160'%3E%3Cstop offset='0' stop-color='%23868686'/%3E%3Cstop offset='0.09' stop-color='%23ababab'/%3E%3Cstop offset='0.18' stop-color='%23c4c4c4'/%3E%3Cstop offset='0.31' stop-color='%23d7d7d7'/%3E%3Cstop offset='0.44' stop-color='%23e5e5e5'/%3E%3Cstop offset='0.59' stop-color='%23f1f1f1'/%3E%3Cstop offset='0.75' stop-color='%23f9f9f9'/%3E%3Cstop offset='1' stop-color='%23FFFFFF'/%3E%3C/linearGradient%3E%3Cfilter id='c' x='0' y='0' width='200%25' height='200%25'%3E%3CfeGaussianBlur in='SourceGraphic' stdDeviation='12' /%3E%3C/filter%3E%3C/defs%3E%3Cpolygon fill='url(%23a)' points='0 174 0 0 174 0'/%3E%3Cpath fill='%23000' fill-opacity='0.32' filter='url(%23c)' d='M121.8 174C59.2 153.1 0 174 0 174s63.5-73.8 87-94c24.4-20.9 87-80 87-80S107.9 104.4 121.8 174z'/%3E%3Cpath fill='url(%23b)' d='M142.7 142.7C59.2 142.7 0 174 0 174s42-66.3 74.9-99.3S174 0 174 0S142.7 62.6 142.7 142.7z'/%3E%3C/svg%3E");
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: top left;
            border: 3px solid var(--warna4);
            border-radius: 12px;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
            position: relative;
        }

        .feature-card::before {
            content: "";
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            border: 1px solid var(--warna4);
            border-radius: 8px;
            opacity: 0.3;
            pointer-events: none;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 16px 32px rgba(117, 52, 34, 0.25),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);

        }

        .feature-icon {
            font-size: 3rem;
            color: var(--sepia-tone);
            margin-bottom: 1rem;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.2));
            opacity: 0.85;
        }

        .feature-title {
            font-size: 1.3rem;
            color: var(--warna2);
            margin-bottom: 1rem;
        }

        .feature-description {
            color: var(--warna1);
            line-height: 1.6;
        }

        /* Timeline Styling */
        .timeline {
            position: relative;
            padding: 2rem 0;
        }

        .timeline-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 2rem;
            position: relative;
        }

        .timeline-icon {
            width: 60px;
            height: 60px;
            background: var(--warna3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--warna0);
            font-size: 1.5rem;
            flex-shrink: 0;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25),
                inset 0 2px 4px rgba(255, 255, 255, 0.2);
            border: 3px solid var(--warna4);
        }

        .timeline-content {
            margin-left: 2rem;
            background: var(--warna0);
            padding: 1.5rem;
            border-radius: 8px;
            border: 3px solid var(--warna4);
            flex-grow: 1;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .timeline-content h4 {
            color: var(--warna2);
            margin-bottom: 0.5rem;
        }

        /* Accordion Styling */
        .accordion-item {
            background: var(--warna0);
            border: 3px solid var(--warna4);
            margin-bottom: 1rem;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .accordion-button {
            background: var(--warna6);
            color: var(--warna2);
            font-weight: 600;
            font-size: 1.1rem;
            padding: 1.2rem;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .accordion-button:not(.collapsed) {
            background: var(--warna3);
            color: var(--warna0);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .accordion-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(176, 91, 59, 0.25);
            border-color: var(--warna3);
        }

        .accordion-body {
            padding: 1.5rem;
            background: var(--warna0);
        }

        /* Testimonial Card */
        .testimonial-card {
            background: var(--warna6);
            border: 3px solid var(--warna4);
            border-radius: 12px;
            padding: 2rem;
            position: relative;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: 20px;
            font-size: 5rem;
            color: var(--warna3);
            opacity: 0.4;

        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 1rem;
            color: var(--warna1);
        }

        .testimonial-author {
            font-weight: 600;
            color: var(--warna2);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg,
                    var(--warna2) 0%,
                    var(--warna3) 100%);
            color: var(--warna0);
            padding: 5rem 0;
            text-align: center;
            box-shadow: inset 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .cta-section h2 {
            color: var(--warna0);
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .btn-cta-large {
            background: var(--warna0);
            color: var(--warna2);
            padding: 1rem 3rem;
            font-size: 1.2rem;
            border-radius: 50px;
            border: 3px solid var(--warna4);
            font-weight: 700;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 0.5rem;
            animation: heartbeat 2s infinite;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
        }

        .btn-cta-large:hover {
            transform: scale(1.1);
            box-shadow: 0 0 35px rgba(255, 255, 255, 0.6),
                0 8px 20px rgba(0, 0, 0, 0.4);
            color: var(--warna2);
        }

        /* judul & subjudul */
        .fitur-guru-judul {
            font-weight: bold;
            margin-bottom: 1rem;
            color: var(--warna2);
            /* lebih tegas */
        }

        .fitur-guru-subjudul {
            color: var(--warna3);
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        /* lingkaran fitur */
        .fitur-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            border: 2px solid var(--warna1);
            transition: 0.3s;
        }

        .fitur-circle:hover {
            background: var(--warna4);
            color: var(--warna0);
        }

        .fitur-circle i {
            font-size: 2.2rem;
        }

        /* teks fitur */
        .fitur-text {
            text-align: center;
            margin-top: .7rem;
            font-weight: 600;
            color: var(--warna2);
            font-size: 1rem;
        }

        .klik {
            box-shadow: 0 10px 0 var(--warna1);
            /*Warna bayangan*/
        }

        .klik:focus {
            border: none;
            /*Warna bayangan*/
            outline: none;
            /*Warna bayangan*/
        }

        .klik:active {
            box-shadow: 0 5px var(--warna0);
            /*Warna bayangan*/
            transform: translateY(5px);
            /*Warna bayangan*/
        }



        @keyframes heartbeat {

            0%,
            100% {
                transform: scale(1);
            }

            10%,
            30% {
                transform: scale(1.05);
            }

            20% {
                transform: scale(1);
            }
        }

        /* Footer */
        footer {
            background-color: var(--warna2);
            color: var(--warna0);
            padding: 3rem 0 1rem;
            box-shadow: inset 0 4px 8px rgba(0, 0, 0, 0.3);
            position: relative;
        }


        footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        footer a {
            color: var(--warna0);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        /* Table Styling */
        .table-custom {
            background: var(--warna0);
            border: 3px solid var(--warna4);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .table-custom thead {
            background: var(--warna3);
            color: var(--warna0);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .table-custom tbody tr:hover {
            background: var(--warna6);
        }

        .navbar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 2000;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                margin-top: 85px;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .timeline-item {
                flex-direction: column;
            }

            .timeline-content {
                margin-left: 0;
                margin-top: 1rem;
            }

            .section::before,
            .section::after {
                width: 50px;
                height: 50px;
            }
        }

        /* Scroll Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top navbar-fixed">
            <div class="container">
                <a class="navbar-brand" href="#"> SCI Media Online </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="#fitur">Fitur Lengkap</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#cara-pakai">Cara Pakai</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#faq">Bantuan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#kontak">Kontak</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#popupLogin"
                                class="btn btn-primary-custom text-center" style="padding: 6px 12px;">
                                Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="modal fade mt-5" id="popupLogin" tabindex="-1">
            <div class="modal-dialog custom-modal mt-5">
                <div class="modal-content p-3">

                    <div class="modal-header border-0">
                        <h5 class="modal-title">Pilih Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body d-flex flex-column gap-3">

                        <!-- Admin -->
                        <a href="{{ route('login') }}" class="btn btn-danger w-100">
                            Login sebagai Admin
                        </a>

                        <!-- Guru -->
                        <a href="#" class="btn btn-primary w-100">
                            Login sebagai Guru
                        </a>

                        <!-- Siswa -->
                        <a href="#" class="btn btn-success w-100">
                            Login sebagai Siswa
                        </a>

                    </div>

                </div>
            </div>
        </div>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5 text-center mt-5" data-aos="fade-left">
                        <svg width="120%" height="auto" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg"
                            style="max-width:700px; display:block; margin:0 auto;">
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
                    <div class="col-lg-7 hero-content" data-aos="fade-right">
                        <h1 class="hero-title">
                            Platform Pembelajaran Digital Terpadu
                        </h1>
                        <p class="hero-subtitle">
                            SCI Media Online menghadirkan solusi Learning
                            Management System (LMS) yang mudah, fleksibel,
                            dan dapat diakses kapan saja, di mana saja untuk
                            guru dan siswa.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Ornament Divider -->
        <div class="ornament-divider">
            <svg viewBox="0 0 120 25" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 12 Q 30 2, 60 12 T 120 12" stroke="#B05B3B" stroke-width="2" fill="none" />
                <circle cx="60" cy="12" r="5" fill="#B05B3B" stroke="#753422" stroke-width="1" />
                <circle cx="30" cy="12" r="3" fill="#D79771" stroke="#B05B3B" stroke-width="1" />
                <circle cx="90" cy="12" r="3" fill="#D79771" stroke="#B05B3B" stroke-width="1" />
                <path d="M55,12 L60,7 L65,12 L60,17 Z" fill="#FFF4E0" opacity="0.6" />
            </svg>
        </div>

        <!-- Section: Tentang Aplikasi -->
        <section class="section" id="tentang">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">
                        Tentang SCI Media Online
                    </h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="feature-card mb-2">
                            <p class="lead text-center mt-5">
                                <strong>SCI Media</strong> merupakan perusahaan penyedia solusi pendidikan
                                digital
                                yang mengembangkan aplikasi <strong>Learning Management System (LMS)</strong>
                                bernama <strong>SCI Media Online</strong> untuk mendukung proses pembelajaran guru dan
                                siswa.
                            </p>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Dapat diakses melalui
                                    <strong>browser</strong> di alamat
                                    <strong> SCI Mediaonline.com</strong>
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Dapat diakses dari
                                    <strong>HP atau laptop</strong>
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Tersedia aplikasi
                                    <strong>Android</strong> di Google Play
                                    Store
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <strong>Fleksibel</strong> dan mudah
                                    digunakan
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Akses
                                    <strong>kapan saja dan di mana saja</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="classical-divider"></div>

        <!-- Section: Fitur Utama -->
        <section class="section" id="fitur">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title" style="color: var(--warna5)">
                        Fitur Utama
                    </h2>
                    <p class="section-subtitle" style="color: var(--warna5)">
                        Lengkap, mudah, dan siap mendukung pembelajaran
                        digital Anda
                    </p>
                </div>
                <div class="row row-cols-2 row-cols-lg-4 g-4">

                    <!-- Kelas & Siswa -->
                    <div class="col">
                        <div class="feature-card text-center">
                            <i class="bi bi-people-fill feature-icon" style="color: var(--warna2)"></i>
                            <h3 class="feature-title">Manajemen Kelas & Siswa</h3>
                            <p class="feature-description">
                                Kelola kelas dengan mudah. Setiap kelas dapat menampung hingga 45 siswa, lengkap dengan
                                data dan aktivitas pembelajaran.
                            </p>
                        </div>
                    </div>

                    <!-- Materi -->
                    <div class="col">
                        <div class="feature-card text-center">
                            <i class="bi bi-book feature-icon" style="color: var(--warna2)"></i>
                            <h3 class="feature-title">Materi Pembelajaran Lengkap</h3>
                            <p class="feature-description">
                                Gunakan materi pembelajaran yang telah disediakan dalam paket, atau buat dan unggah
                                materi sendiri sesuai kebutuhan.
                            </p>
                        </div>
                    </div>

                    <!-- Soal -->
                    <div class="col">
                        <div class="feature-card text-center">
                            <i class="bi bi-pencil-square feature-icon" style="color: var(--warna2)"></i>
                            <h3 class="feature-title">Bank & Manajemen Soal</h3>
                            <p class="feature-description">
                                Gunakan bank soal yang telah disediakan, buat dan kelola soal sendiri,
                                atau generate soal otomatis dengan bantuan AI sesuai kebutuhan pembelajaran.
                            </p>
                        </div>
                    </div>

                    <!-- Penilaian -->
                    <div class="col">
                        <div class="feature-card text-center">
                            <i class="bi bi-graph-up feature-icon" style="color: var(--warna2)"></i>
                            <h3 class="feature-title">Sistem Penilaian Terintegrasi</h3>
                            <p class="feature-description">
                                Penilaian otomatis per KD, nilai ulangan, hingga rekap laporan lengkap dalam satu
                                sistem.
                            </p>
                        </div>
                    </div>

                    <!-- Monitoring Kuis (BARU) -->
                    <div class="col">
                        <div class="feature-card text-center">
                            <i class="bi bi-bar-chart-line feature-icon" style="color: var(--warna2)"></i>
                            <h3 class="feature-title">Monitoring Kuis</h3>
                            <p class="feature-description">
                                Pantau aktivitas pengerjaan kuis siswa secara real-time, termasuk status pengerjaan dan
                                hasil yang diperoleh.
                            </p>
                        </div>
                    </div>

                    <!-- KI -->
                    <div class="col">
                        <div class="feature-card text-center">
                            <i class="bi bi-bookmark-star-fill feature-icon" style="color: var(--warna2)"></i>
                            <h3 class="feature-title">Rekam KI1 & KI2</h3>
                            <p class="feature-description">
                                Pencatatan sikap spiritual dan sosial siswa secara otomatis dan terstruktur.
                            </p>
                        </div>
                    </div>

                    <!-- Diskusi -->
                    <div class="col">
                        <div class="feature-card text-center">
                            <i class="bi bi-chat-square-text feature-icon" style="color: var(--warna2)"></i>
                            <h3 class="feature-title">Diskusi Pembelajaran</h3>
                            <p class="feature-description">
                                Fitur diskusi langsung antara siswa dan guru pada setiap soal.
                            </p>
                        </div>
                    </div>

                    <!-- Kelas Online -->
                    <div class="col">
                        <div class="feature-card text-center">
                            <i class="bi bi-broadcast-pin feature-icon" style="color: var(--warna2)"></i>
                            <h3 class="feature-title">Kelas Online</h3>
                            <p class="feature-description">
                                Tatap muka virtual interaktif antara guru dan siswa.
                            </p>
                        </div>
                    </div>

                    <!-- Customer Service -->
                    <div class="col">
                        <div class="feature-card text-center">
                            <i class="bi bi-headset feature-icon" style="color: var(--warna2)"></i>
                            <h3 class="feature-title">Layanan Pelanggan</h3>
                            <p class="feature-description">
                                Dukungan melalui QnA, chatbot, hingga admin untuk membantu menyelesaikan masalah
                                pengguna.
                            </p>
                        </div>
                    </div>

                    <!-- Notifikasi -->
                    <div class="col">
                        <div class="feature-card text-center">
                            <i class="bi bi-envelope-exclamation-fill feature-icon" style="color: var(--warna2)"></i>
                            <h3 class="feature-title">Notifikasi Masa Aktif</h3>
                            <p class="feature-description">
                                Pemberitahuan otomatis saat masa aktif serial akan habis atau kedaluwarsa.
                            </p>
                        </div>
                    </div>

                    <!-- Profil -->
                    <div class="col">
                        <div class="feature-card text-center">
                            <i class="bi bi-person-circle feature-icon" style="color: var(--warna2)"></i>
                            <h3 class="feature-title">Manajemen Profil</h3>
                            <p class="feature-description">
                                Kelola akun, data pribadi, dan keamanan dengan mudah.
                            </p>
                        </div>
                    </div>

                    <!-- Akses -->
                    <div class="col">
                        <div class="feature-card text-center">
                            <i class="bi bi-phone-fill feature-icon" style="color: var(--warna2)"></i>
                            <h3 class="feature-title">Akses Fleksibel</h3>
                            <p class="feature-description">
                                Akses sistem kapan saja dan di mana saja dari berbagai perangkat.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <div class="classical-divider"></div>

        <!-- Section: How It Works -->
        <section class="section" id="cara-pakai">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">
                        Cara Menggunakan
                    </h2>
                    <p class="section-subtitle">
                        Mudah diakses dan mudah didapatkan
                    </p>
                </div>

                <div class="row mb-5">
                    <div class="col-lg-6" data-aos="fade-right">
                        <h3 class="mb-4">
                            Cara Akses Aplikasi
                        </h3>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="bi bi-globe"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4>Melalui Browser</h4>
                                    <p>
                                        Akses langsung melalui website
                                        <strong> SCI Mediaonline.com</strong>
                                        dari browser favorit Anda.
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="bi bi-phone"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4>Aplikasi Android</h4>
                                    <p>
                                        Download aplikasi
                                        <strong>" SCI Media Online"</strong>
                                        di Google Play Store untuk akses
                                        lebih praktis.
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="bi bi-wifi"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4>Koneksi Internet</h4>
                                    <p>
                                        Pastikan perangkat Anda terhubung
                                        dengan koneksi internet yang stabil.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left">
                        <h3 class="mb-4">
                            Cara Mendapatkan Akun dan Kode Serial
                        </h3>
                        <div class="timeline">

                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="bi bi-person-plus"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4>1. Membuat atau Mendapatkan Akun</h4>
                                    <p>
                                        Pengguna dapat membuat akun melalui halaman registrasi
                                        atau menghubungi admin untuk dibuatkan akun.
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="bi bi-chat-dots"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4>2. Menghubungi Admin</h4>
                                    <p>
                                        Setelah memiliki akun, pengguna dapat langsung
                                        menghubungi admin SCI Media untuk mengajukan
                                        permintaan kode serial.
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="bi bi-key"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4>3. Mendapatkan Kode Serial</h4>
                                    <p>
                                        Jika sudah memiliki produk, kirim bukti pembelian. Jika belum, minta kode serial
                                        dan ikuti arahan admin.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="classical-divider"></div>

        <!-- Section: Testimoni -->
        <section class="section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title" style="color: var(--warna5)">
                        Testimoni Pengguna
                    </h2>
                    <p class="section-subtitle" style="color: var(--warna5)">
                        Apa kata mereka tentang SCI Media Online
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4" data-aos-delay="100">
                        <div class="testimonial-card">
                            <p class="testimonial-text">
                                " SCI Media Online sangat membantu saya dalam
                                mengelola pembelajaran jarak jauh.
                                Fitur-fiturnya lengkap dan mudah digunakan!"
                            </p>
                            <p class="testimonial-author">
                                — Ibu Sari, Guru SD
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos-delay="200">
                        <div class="testimonial-card">
                            <p class="testimonial-text">
                                "Dengan SCI Media Online, saya bisa memantau
                                perkembangan siswa secara real-time. Rekap
                                nilai otomatis sangat menghemat waktu."
                            </p>
                            <p class="testimonial-author">
                                — Pak Budi, Guru SD
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos-delay="300">
                        <div class="testimonial-card">
                            <p class="testimonial-text">
                                "Materi video bernarasi dan bank soal yang
                                tersedia membuat persiapan mengajar jadi
                                lebih efisien dan mudah. Sangat direkomendasikan!"
                            </p>
                            <p class="testimonial-author">
                                — Ibu Dewi, Guru SD
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="classical-divider"></div>

        <!-- Section: Bantuan  -->
        <section class="section" id="faq">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">
                        Butuh Bantuan atau Ada Pertanyaan?
                    </h2>
                    <p class="section-subtitle">
                        Jika Anda mengalami kendala atau ingin mengajukan
                        pertanyaan, silakan gunakan fitur pusat layanan pelanggan SCI Media yang
                        telah kami sediakan.
                    </p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="p-4 text-center feature-card">
                            <i class="bi bi-life-preserver"
                                style="
                        font-size: 4rem;
                        color: var(--warna2);
                    ">
                            </i>

                            <h3 class="mt-3" style="color: var(--warna2)">
                                PUSAT LAYANAN PELANGGAN<br>
                                SCI Media Online
                            </h3>

                            <p class="mt-2">
                                Untuk segala kebutuhan bantuan, pertanyaan, atau laporan masalah,
                                Anda dapat menggunakan layanan yang telah kami sediakan.
                                Silakan klik tombol di bawah ini untuk masuk ke halaman
                                <strong>Pusat Layanan Pelanggan SCI Media Online</strong>, lalu pilih menu layanan
                                yang sesuai
                                untuk memulai layanan baru atau melanjutkan layanan Anda sebelumnya.
                            </p>

                            <a href="{{ route('layanan-pelanggan.index') }}"
                                class="btn-primary-custom mt-3 px-4 py-2">
                                <i class="bi bi-chat-dots-fill me-1"></i>
                                Pergi
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div data-aos="zoom-in">
                    <h2 class="mb-4">Siap Memulai Pembelajaran Digital?</h2>
                    <p class="lead mb-5">
                        Ayo mulai sekarang! Pilih salah satu opsi di bawah
                        untuk melakukan pemesanan atau menghubungi admin
                        melalui metode yang Anda inginkan.
                    </p>

                    <div class="d-flex gap-3">

                        <!-- Tombol WhatsApp -->
                        {{-- <a href="https://wa.me/6282327042255" target="_blank" class="btn-primary-custom"
                            style="background: #25d366; color: white; border-color: #128c7e;">
                            <i class="bi bi-whatsapp"></i> Hubungi lewat WhatsApp
                        </a> --}}
                        <!-- Tombol Toko Online -->
                        <!-- Tombol Toko Online -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#popupTokoOnline"
                            class="btn-primary-custom"
                            style="
        flex:1;
        background: linear-gradient(135deg, #eb254d, #af1e1e);
        color: #fff;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        min-height: 50px;
    ">
                            <i class="bi bi-cart-check"></i> Toko Online
                        </a>

                        <!-- Tombol Layanan Pelanggan -->
                        <a href="{{ route('layanan-pelanggan.index') }}" class="btn-primary-custom"
                            style="
        flex:1;
        background: linear-gradient(135deg, #10b981, #047857);
        color: #fff;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        min-height: 50px;
    ">
                            <i class="bi bi-chat-dots-fill"></i> Hubungi Layanan Pelanggan
                        </a>

                    </div>
                </div>
            </div>
        </section>
        <!-- MODAL TOKO ONLINE -->
        <div class="modal fade p-5" id="popupTokoOnline" tabindex="-1" aria-hidden="true"
            style="z-index: 999999 !important; position: fixed !important;">
            <div class="modal-dialog modal-dialog-centered custom-modal"
                style="z-index: 1000000 !important; position: relative !important;">
                <div class="modal-content" style="z-index: 1000001 !important;">

                    <div class="modal-header" style="background: var(--warna2); color: var(--warna0);">
                        <h5 class="modal-title text-center w-100">Toko Online Resmi SCI Media</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label class="form-label fw-bold text-center w-100 mb-3">
                            Pilih platform resmi untuk pembelian produk SCI Media:
                        </label>

                        <div class="d-grid gap-2">

                            <a href="https://scimedia.co.id/" target="_blank"
                                class="btn-primary-custom w-100 text-center"
                                style="background: var(--warna1); color: var(--warna0); border: 2px solid var(--warna2);">
                                SCI Media Website
                            </a>

                            <a href="https://www.tokopedia.com/sci-media" target="_blank"
                                class="btn-primary-custom w-100 text-center"
                                style="background: var(--warna2); color: var(--warna0); border: 2px solid var(--warna3);">
                                Tokopedia
                            </a>

                            <a href="https://id.shp.ee/Lgf5Frg" target="_blank"
                                class="btn-primary-custom w-100 text-center"
                                style="background: var(--warna3); color: var(--warna0); border: 2px solid var(--warna1);">
                                Shopee
                            </a>

                            <a href="https://siplahtelkom.com/product/alat-peraga-sekolah/1932102-media-ajar-sci-rpp-dan-adminitrasi-guru-"
                                target="_blank" class="btn-primary-custom w-100 text-center"
                                style="background: var(--warna4); color: var(--warna0); border: 2px solid var(--warna2);">
                                Siplah Telkom
                            </a>

                            <a href="https://siplah.blibli.com/merchant-detail/SSME-0028?itemPerPage=40&page=0&merchantId=SSME-0028"
                                target="_blank" class="btn-primary-custom w-100 text-center"
                                style="background: var(--warna5); color: var(--warna1); border: 2px solid var(--warna3);">
                                Siplah Blibli
                            </a>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn-primary-custom w-100"
                            style="background: var(--warna0); color: var(--warna3); border: 2px solid var(--warna2);"
                            data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>
        </div>




        <!-- Footer -->
        <footer id="kontak">
            <div class="container">
                <div class="row">
                    <!-- Bagian Informasi -->
                    <div class="col-8 mb-4">
                        <h5 class="mb-3"> SCI Media Online</h5>
                        <p>
                            SCI Media Online adalah platform Learning Management System (LMS)
                            terpercaya yang dirancang untuk mendukung proses pembelajaran
                            digital secara lebih efektif, fleksibel, dan mudah digunakan.
                        </p>
                        <p>
                            Dengan berbagai fitur seperti pengelolaan kelas, penilaian,
                            manajemen materi, hingga laporan hasil belajar,
                            kami berkomitmen membantu guru, siswa, dan institusi pendidikan
                            mencapai pengalaman belajar yang lebih modern dan berkualitas.
                        </p>
                        <p>
                            Kami terus mengembangkan layanan agar dapat memberikan pengalaman
                            terbaik, baik untuk kebutuhan pembelajaran sehari-hari maupun
                            pengelolaan sistem pendidikan secara keseluruhan.
                        </p>
                    </div>

                    <!-- Bagian Kontak -->
                    <div class="col-4 mb-4">
                        <h5 class="mb-3">Kontak</h5>

                        <p>
                            <i class="bi bi-whatsapp me-2"></i>
                            <a href="https://wa.me/6282327042255" target="_blank">
                                0823-2704-2255
                            </a>
                        </p>

                        <p>
                            <i class="bi bi-instagram me-2"></i>
                            <a href="https://www.instagram.com/scimedia.id?igsh=MWJ1NHF3eXB6dGFndg==" target="_blank">
                                @scimedia.id
                            </a>
                        </p>
                        <p>
                            <i class="bi bi-globe me-2"></i>
                            <a href="https://scimediaonline.com/" target="_blank">
                                SCI Mediaonline.com
                            </a>
                        </p>
                        <p>
                            <i class="bi bi-globe me-2"></i>
                            <a href="https://scimedia.co.id/" target="_blank">
                                SCI Media.com
                            </a>
                        </p>

                        <p>
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            Indonesia
                        </p>
                    </div>
                </div>

                <hr style="border-color: var(--warna4)" />

                <div class="text-center py-3">
                    <p class="mb-0">
                        &copy; 2025 SCI Media Online. Semua hak cipta dilindungi.
                    </p>
                    <small class="d-block mt-1" style="opacity: 0.7;">
                        Dikembangkan untuk mendukung transformasi pendidikan digital.
                    </small>
                </div>
            </div>
        </footer>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
        });


        // Navbar background on scroll
        window.addEventListener("scroll", function() {
            const navbar = document.querySelector(".navbar");
            if (window.scrollY > 50) {
                navbar.style.boxShadow = "0 6px 24px rgba(0, 0, 0, 0.5)";
            } else {
                navbar.style.boxShadow = "0 6px 20px rgba(0, 0, 0, 0.4)";
            }
        });
    </script>
    <script>
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
        const popovers = [];

        // Inisialisasi semua popover
        popoverTriggerList.forEach((el) => {
            const pop = new bootstrap.Popover(el);
            popovers.push(pop);

            // Saat tombol diklik, tutup semua popover lain
            el.addEventListener("click", function(e) {
                // Tutup popover lainnya
                popovers.forEach((p) => {
                    if (p !== pop) p.hide();
                });
            });

            // Auto hide setelah 5 detik
            el.addEventListener("shown.bs.popover", () => {
                setTimeout(() => {
                    pop.hide();
                }, 5000);
            });
        });
    </script>

</body>

</html>
