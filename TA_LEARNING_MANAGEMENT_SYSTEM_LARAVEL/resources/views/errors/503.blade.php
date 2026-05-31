<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedang Dalam Pemeliharaan</title>
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
            background: #F1EFE8;
            border: 1px solid #D3D1C7;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }

        .icon-box svg {
            width: 26px;
            height: 26px;
            stroke: #444441;
        }

        .e-code {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-align: center;
            color: #5F5E5A;
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
            background: #F1EFE8;
            border: 1px solid #D3D1C7;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }

        .trigger-label {
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: #2C2C2A;
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
            color: #444441;
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
            background: #F1EFE8;
            border: 1px solid #D3D1C7;
            color: #2C2C2A;
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
                    d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l5.653-4.655m5.585-5.585a2.548 2.548 0 013.586 3.586L12 15.17" />
            </svg>
        </div>
        <p class="e-code">Error 503</p>
        <h1>Sedang dalam pemeliharaan</h1>
        <p class="desc">Sistem sedang kami perbarui untuk pengalaman yang lebih baik.<br>Mohon tunggu sebentar dan
            coba kembali.</p>
        <div class="trigger-box">
            <p class="trigger-label">Apa yang sedang terjadi?</p>
            <ul class="trigger-list">
                <li>Sistem sedang diperbarui atau diperbaiki</li>
                <li>Pemeliharaan rutin yang terjadwal</li>
                <li>Akan kembali normal dalam waktu dekat</li>
            </ul>
        </div>
        <div class="section">
            <p class="section-label">Yang bisa dilakukan</p>
            <ul class="steps">
                <li><span class="num">1</span> Tunggu beberapa menit lalu coba lagi</li>
                <li><span class="num">2</span> Muat ulang halaman setelah beberapa saat</li>
                <li><span class="num">3</span> Ikuti info terbaru jika ada pengumuman dari kami</li>
            </ul>
        </div>
        <div class="actions">
            <a href="javascript:location.reload()" class="btn btn-primary">&#8635; Coba Lagi</a>
            <a href="/" class="btn btn-secondary">Ke Beranda</a>
        </div>
        <p class="footer">Error 503 &middot; Service Unavailable</p>
    </main>
</body>

</html>
