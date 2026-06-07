<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SciMedia Online</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Syne:wght@700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg-deep: #f0f4ff;
            --bg-card: #ffffff;
            --accent: #4f46e5;
            --accent-2: #6366f1;

            --text-pri: #1e293b;
            --text-sec: #64748b;
            --text-muted: #94a3b8;

            --border: #e2e8f0;
            --border-hover: #c7d2fe;

            --input-bg: #f8fafc;
            --input-bg-focus: #ffffff;

            --error: #ef4444;
            --error-bg: #fef2f2;

            --success: #22c55e;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 18px;
            --radius-xl: 24px;
            --font-body: "Plus Jakarta Sans", sans-serif;
            --font-head: "Plus Jakarta Sans", sans-serif;
        }

        html,
        body {
            height: 100%;
            font-family: var(--font-body);
            background: var(--bg-deep);
            color: var(--text-pri);
        }

        /* ─── ANIMATED BACKGROUND ─── */
        .login-bg {
            position: fixed;
            inset: 0;
            overflow: hidden;
            z-index: 0;
        }

        .login-bg::before {
            content: '';
            position: absolute;
            width: 700px;
            height: 700px;
            top: -200px;
            left: -180px;
            background: radial-gradient(circle, rgba(90, 111, 255, 0.13) 0%, transparent 65%);
            animation: float1 12s ease-in-out infinite alternate;
        }

        .login-bg::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            bottom: -150px;
            right: -100px;
            background: radial-gradient(circle, rgba(167, 139, 250, 0.12) 0%, transparent 65%);
            animation: float2 15s ease-in-out infinite alternate;
        }

        .orb-mid {
            position: absolute;
            width: 400px;
            height: 400px;
            top: 40%;
            left: 55%;
            background: radial-gradient(circle, rgba(52, 211, 153, 0.07) 0%, transparent 65%);
            animation: float3 18s ease-in-out infinite alternate;
        }

        @keyframes float1 {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(60px, 40px) scale(1.1);
            }
        }

        @keyframes float2 {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(-50px, -30px) scale(1.08);
            }
        }

        @keyframes float3 {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(-40px, 60px);
            }
        }

        /* ─── GRID LINES ─── */
        .grid-overlay {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image:
                linear-gradient(rgba(90, 111, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(90, 111, 255, 0.05) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* ─── MAIN WRAPPER ─── */
        .login-wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* ─── CARD ─── */
        .login-card {
            width: 100%;
            max-width: 440px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 2.75rem 2.5rem 2.5rem;
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.9) inset,
                0 20px 60px rgba(79, 70, 229, 0.10),
                0 4px 20px rgba(0, 0, 0, 0.07);
            animation: cardIn 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(28px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ─── HEADER ─── */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, rgba(90, 111, 255, 0.12), rgba(167, 139, 250, 0.12));
            border: 1px solid rgba(90, 111, 255, 0.2);
            border-radius: var(--radius-md);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.1rem;
        }

        .login-logo img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        /* ── gradient gelap agar terbaca di background putih ── */
        .login-title {
            font-family: var(--font-head);
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            background: linear-gradient(135deg, #4f46e5 0%, #7c6aff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.3rem;
        }

        .login-subtitle {
            font-size: 0.83rem;
            color: var(--text-sec);
        }

        /* ─── ERROR ALERT ─── */
        .login-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 0.75rem 1rem;
            background: var(--error-bg);
            border: 1px solid rgba(248, 113, 113, 0.25);
            border-radius: var(--radius-sm);
            margin-bottom: 1.4rem;
            font-size: 0.82rem;
            color: var(--error);
            animation: slideDown 0.3s ease both;
        }

        .login-alert svg {
            flex-shrink: 0;
            margin-top: 1px;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ─── FORM ─── */
        .form-group {
            margin-bottom: 1.1rem;
        }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-sec);
            margin-bottom: 0.45rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .form-control {
            width: 100%;
            padding: 0.72rem 1rem;
            font-family: var(--font-body);
            font-size: 0.9rem;
            color: var(--text-pri);
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
            -webkit-appearance: none;
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-control:hover {
            border-color: var(--border-hover);
        }

        .form-control:focus {
            border-color: var(--accent);
            background: var(--input-bg-focus);
            box-shadow: 0 0 0 3px rgba(90, 111, 255, 0.12);
        }

        .form-control.is-error {
            border-color: var(--error) !important;
            box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.15) !important;
        }

        /* ─── PASSWORD INPUT ─── */
        .password-group {
            position: relative;
        }

        .password-group .form-control {
            padding-right: 2.8rem;
        }

        .pw-toggle {
            position: absolute;
            right: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .pw-toggle:hover {
            color: var(--accent);
        }

        .pw-toggle svg {
            display: block;
        }

        /* ─── REMEMBER + FORGOT ─── */
        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            margin-top: 0.25rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.82rem;
            color: var(--text-sec);
            user-select: none;
        }

        .remember-check {
            position: relative;
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .remember-check input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 1;
            margin: 0;
        }

        .checkbox-box {
            width: 16px;
            height: 16px;
            border: 1.5px solid var(--border-hover);
            border-radius: 4px;
            background: var(--input-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.18s, border-color 0.18s;
        }

        .remember-check input:checked~.checkbox-box {
            background: var(--accent);
            border-color: var(--accent);
        }

        .checkbox-box svg {
            display: none;
        }

        .remember-check input:checked~.checkbox-box svg {
            display: block;
        }

        .forgot-link {
            font-size: 0.82rem;
            color: var(--accent-2);
            text-decoration: none;
            transition: color 0.2s;
        }

        /* ── hover tetap gelap agar terbaca di tema terang ── */
        .forgot-link:hover {
            color: #3730a3;
        }

        /* ─── SUBMIT BUTTON ─── */
        .btn-login {
            width: 100%;
            padding: 0.82rem;
            font-family: var(--font-body);
            font-size: 0.93rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--accent) 0%, #7c6aff 100%);
            border: none;
            border-radius: 999px;
            cursor: pointer;
            letter-spacing: 0.01em;
            position: relative;
            overflow: hidden;
            transition: transform 0.22s, box-shadow 0.22s, opacity 0.22s;
            box-shadow: 0 4px 20px rgba(90, 111, 255, 0.30);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12), transparent);
            opacity: 0;
            transition: opacity 0.22s;
        }

        .btn-login:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(90, 111, 255, 0.38);
        }

        .btn-login:hover::before {
            opacity: 1;
        }

        .btn-login:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }


        /* ─── FOOTER ─── */
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .login-footer a {
            color: var(--text-sec);
            text-decoration: none;
        }

        .login-footer a:hover {
            color: var(--text-pri);
        }

        /* ─── DIVIDER ─── */
        .login-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 1.5rem 0;
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        .login-divider::before,
        .login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.5rem;
            }

            .login-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

    {{-- ── SweetAlert Notifications ── --}}
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: @json(session('error')),
                confirmButtonColor: '#4f46e5',
                background: '#ffffff',
                color: '#1e293b'
            }));
        </script>
    @endif
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                confirmButtonColor: '#4f46e5',
                background: '#ffffff',
                color: '#1e293b'
            }));
        </script>
    @endif

    <!-- Background FX -->
    <div class="login-bg">
        <div class="orb-mid"></div>
    </div>
    <div class="grid-overlay"></div>

    <!-- Main -->
    <div class="login-wrapper">
        <div class="login-card">

            <!-- Header -->
            <div class="login-header">
                <div class="login-logo">
                    <img src="{{ asset('images/logo1.webp') }}" alt="SciMedia Logo">
                </div>
                <h1 class="login-title">SCI Media Online</h1>
            </div>

            {{-- ── Validation Errors ── --}}
            @if ($errors->any())
                <div class="login-alert">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login.process') }}" autocomplete="off" id="loginForm">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" id="username" name="username"
                        class="form-control {{ $errors->has('username') ? 'is-error' : '' }}"
                        placeholder="Masukkan username" value="{{ old('username') }}" required autocomplete="username">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="password-group">
                        <input type="password" id="password" name="password"
                            class="form-control {{ $errors->has('password') ? 'is-error' : '' }}"
                            placeholder="Masukkan password" required autocomplete="current-password">
                        <button type="button" class="pw-toggle" id="pwToggle" aria-label="Tampilkan password">
                            <!-- Eye icon -->
                            <svg id="iconEye" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <!-- Eye-off icon -->
                            <svg id="iconEyeOff" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                style="display:none">
                                <path
                                    d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                                <line x1="1" y1="1" x2="23" y2="23" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="login-options">
                    <label class="remember-label">
                        <span class="remember-check">
                            <input type="checkbox" name="remember">
                            <span class="checkbox-box">
                                <svg width="10" height="8" viewBox="0 0 10 8" fill="none" stroke="#fff"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 4 7 9 1" />
                                </svg>
                            </span>
                        </span>
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn-login" id="btnLogin">
                    <span class="btn-text">Masuk</span>
                    <span class="btn-spinner"><span class="spinner-ring"></span></span>
                </button>

            </form>
        </div>
    </div>

    <script>
        // ── Toggle Password ──
        const pwInput = document.getElementById('password');
        const pwToggle = document.getElementById('pwToggle');
        const iconEye = document.getElementById('iconEye');
        const iconEyeOff = document.getElementById('iconEyeOff');

        pwToggle.addEventListener('click', () => {
            const isHidden = pwInput.type === 'password';
            pwInput.type = isHidden ? 'text' : 'password';
            iconEye.style.display = isHidden ? 'none' : 'block';
            iconEyeOff.style.display = isHidden ? 'block' : 'none';
        });

        // ── Loading State on Submit ──
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('btnLogin');
            btn.disabled = true;
            btn.innerHTML =
                '<span style="display:inline-flex;align-items:center;gap:8px;"><span class="spinner-ring"></span> Memproses...</span>';
        });
    </script>

</body>

</html>
