<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamu Belum Masuk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f5f4f1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .card {
            background: #fff;
            border: 1px solid #ebebeb;
            border-radius: 20px;
            max-width: 480px;
            width: 100%;
            padding: 2.25rem 1.75rem 1.75rem;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #E6F1FB;
            border: 1px solid #B5D4F4;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }

        .icon-box svg {
            width: 26px;
            height: 26px;
            stroke: #0C447C;
        }

        .e-code {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-align: center;
            color: #0C447C;
            margin-bottom: 0.35rem;
        }

        h1 {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            text-align: center;
            margin-bottom: 0.4rem;
        }

        .desc {
            font-size: 13px;
            color: #6b7280;
            text-align: center;
            line-height: 1.65;
            margin-bottom: 1.25rem;
        }

        .trigger-box {
            background: #E6F1FB;
            border: 1px solid #B5D4F4;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }

        .trigger-label {
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: #042C53;
            margin-bottom: 0.5rem;
        }

        .trigger-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .trigger-list li {
            font-size: 12.5px;
            color: #185FA5;
            display: flex;
            align-items: flex-start;
            gap: 6px;
            line-height: 1.5;
        }

        .trigger-list li::before {
            content: '–';
            flex-shrink: 0;
        }

        .section {
            background: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 0.9rem 1rem;
            margin-bottom: 0.6rem;
        }

        .section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 0.6rem;
        }

        .steps {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .steps li {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            font-size: 13px;
            color: #374151;
            line-height: 1.5;
        }

        .num {
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #fff;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9.5px;
            font-weight: 600;
            color: #9ca3af;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .actions {
            display: flex;
            gap: 8px;
            margin-top: 1.25rem;
        }

        .btn {
            flex: 1;
            padding: 9px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            text-align: center;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
            transition: opacity 0.15s;
            font-family: inherit;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .btn-primary {
            background: #E6F1FB;
            border: 1px solid #B5D4F4;
            color: #0C447C;
        }

        .btn-secondary {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            color: #374151;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            color: #d1d5db;
            margin-top: 1.25rem;
        }
    </style>
</head>

<body>
    <main class="card" role="main">
        <div class="icon-box" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
        </div>
        <p class="e-code">Error 401</p>
        <h1>Kamu belum masuk</h1>
        <p class="desc">Halaman ini hanya bisa diakses setelah login.<br>Silakan masuk dengan akunmu terlebih dahulu.
        </p>
        <div class="trigger-box">
            <p class="trigger-label">Kenapa ini terjadi?</p>
            <ul class="trigger-list">
                <li>Mengakses halaman tanpa login terlebih dahulu</li>
                <li>Akun yang sedang aktif sudah habis masa berlakunya</li>
                <li>Membuka link langsung tanpa melalui halaman login</li>
            </ul>
        </div>
        <div class="section">
            <p class="section-label">Yang bisa dilakukan</p>
            <ul class="steps">
                <li><span class="num">1</span> Klik tombol Login di bawah ini</li>
                <li><span class="num">2</span> Masuk dengan akun yang terdaftar</li>
                <li><span class="num">3</span> Setelah masuk, coba buka halaman kembali</li>
            </ul>
        </div>
        <div class="actions">
            <a href="/login" class="btn btn-primary">&#8594; Login</a>
            <a href="/" class="btn btn-secondary">Ke Beranda</a>
        </div>
        <p class="footer">Error 401 &middot; Unauthorized</p>
    </main>
</body>

</html>
