<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terjadi Kesalahan</title>
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
            background: #FCEBEB;
            border: 1px solid #F7C1C1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }

        .icon-box svg {
            width: 26px;
            height: 26px;
            stroke: #A32D2D;
        }

        .e-code {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-align: center;
            color: #A32D2D;
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
            background: #FCEBEB;
            border: 1px solid #F7C1C1;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }

        .trigger-label {
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: #791F1F;
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
            color: #A32D2D;
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
            background: #FCEBEB;
            border: 1px solid #F7C1C1;
            color: #791F1F;
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
                    d="M12 12.75c1.148 0 2.278.08 3.383.237 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-5.25 6.75S6.75 18.728 6.75 15c0-1.046.83-1.867 1.866-2.013A24.204 24.204 0 0112 12.75zm0 0c2.883 0 5.647.508 8.207 1.44a23.91 23.91 0 01-1.152 6.06M12 12.75c-2.883 0-5.647.508-8.208 1.44a23.916 23.916 0 001.152 6.061M12 12.75c-1.794 0-3.54.16-5.232.466m10.464 0A48.78 48.78 0 0112 13.5a48.78 48.78 0 00-5.232-.284m10.464.75A48.78 48.78 0 0112 13.5m-5.232-.284A48.78 48.78 0 0112 12.75m0 0V5.25m0 7.5v-7.5m0 0a2.25 2.25 0 00-2.25-2.25H7.5A2.25 2.25 0 005.25 7.5v2.25" />
            </svg>
        </div>
        <p class="e-code">Error 500</p>
        <h1>Terjadi kesalahan pada sistem</h1>
        <p class="desc">Ada masalah di dalam sistem yang sedang kami tangani.<br>Ini bukan kesalahan kamu — tim kami
            sudah diberitahu.</p>
        <div class="trigger-box">
            <p class="trigger-label">Apa artinya ini?</p>
            <ul class="trigger-list">
                <li>Ada bug atau error pada kode sistem</li>
                <li>Server mengalami gangguan sementara</li>
                <li>Masalah sedang ditangani oleh tim teknis</li>
            </ul>
        </div>
        <div class="section">
            <p class="section-label">Yang bisa dilakukan</p>
            <ul class="steps">
                <li><span class="num">1</span> Tunggu beberapa saat lalu coba lagi</li>
                <li><span class="num">2</span> Muat ulang halaman</li>
                <li><span class="num">3</span> Jika masih terjadi, hubungi tim kami</li>
            </ul>
        </div>
        <div class="actions">
            <a href="javascript:location.reload()" class="btn btn-primary">&#8635; Muat Ulang</a>
            <a href="/" class="btn btn-secondary">Ke Beranda</a>
        </div>
        <p class="footer">Error 500 &middot; Internal Server Error</p>
    </main>
</body>

</html>
