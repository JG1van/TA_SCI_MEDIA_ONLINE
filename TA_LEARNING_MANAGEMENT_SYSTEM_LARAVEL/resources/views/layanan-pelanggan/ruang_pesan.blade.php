<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ruang Layanan Pelanggan</title>

    <!-- Sneat Core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="{{ asset('assets_sneat/vendor/css/core.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets_sneat/vendor/css/theme-default.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets_sneat/css/demo.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets_sneat/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets_sneat/js/config.js') }}"></script>

    @php
        $isAdminMode = $room->chat_status === 'ChatBot' || $room->chat_status === 'Admin';
    @endphp
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    {{-- ═══════════════════════════════════════════════
         NOTIFIKASI SWEETALERT — UNCHANGED
    ═══════════════════════════════════════════════ --}}
    <div>
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
                    confirmButtonColor: '#696CFF'
                })
            </script>
        @endif
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: `{!! implode('<br>', $errors->all()) !!}`
                })
            </script>
        @endif
        @if (session('notif-success'))
            <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
                {{ session('notif-success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('notif-error'))
            <div class="alert alert-danger alert-dismissible fade show mx-3" role="alert">
                {{ session('notif-error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('success_html'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    html: `{!! session('success_html') !!}`,
                    showConfirmButton: false,
                    timer: 5000
                })
            </script>
        @endif
    </div>

    <main style="zoom: 75%;">
        @if ($requireLogin)
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var loginModal = new bootstrap.Modal(document.getElementById('loginModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    loginModal.show();
                });
            </script>
        @endif

        {{-- ═══════════════════════════════════════════════
             MAIN CONTENT — QnA MODE
        ═══════════════════════════════════════════════ --}}
        <div class="main-wrapper-card mb-4 shadow" id="main-content" style="{{ $isAdminMode ? 'display:none;' : '' }}">

            <!-- Header -->
            <div class="main-wrapper-header">
                <div class="main-wrapper-title">
                    <div class="title-icon"><i class="bi bi-headset"></i></div>
                    Ruang Layanan Pelanggan
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="room-code-pill">
                        <i class="bi bi-hash"></i>
                        <span id="RoomCode">{{ $room->room_code }}</span>
                    </div>
                    <button type="button" class="btn-selesai" data-bs-toggle="modal" data-bs-target="#finishModal">
                        <i class="bi bi-check-circle"></i> Selesai
                    </button>
                </div>
            </div>

            <div class="card-body p-4">

                <!-- ══ TABS — REDESIGNED ══ -->
                <ul class="nav tab-nav-wrap" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="tab-umum-btn" data-bs-toggle="tab"
                            data-bs-target="#tab-umum" type="button" role="tab">
                            <i class="bi bi-globe2"></i>
                            Umum
                            <span class="tab-badge">{{ count($tabUmum) }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="tab-guru-btn" data-bs-toggle="tab" data-bs-target="#tab-guru"
                            type="button" role="tab">
                            <i class="bi bi-person-badge"></i>
                            Guru
                            <span class="tab-badge">{{ count($tabGuru) }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="tab-siswa-btn" data-bs-toggle="tab" data-bs-target="#tab-siswa"
                            type="button" role="tab">
                            <i class="bi bi-mortarboard"></i>
                            Siswa
                            <span class="tab-badge">{{ count($tabSiswa) }}</span>
                        </button>
                    </li>
                </ul>

                <!-- ══ QNA CARD — REDESIGNED ══ -->
                <div class="qna-card">
                    <div class="qna-header open" id="qnaHeaderEl" onclick="toggleQna()">
                        <div class="qna-icon-wrap">
                            <i class="bi bi-patch-question-fill"></i>
                        </div>
                        <div class="qna-header-text">
                            <div class="qna-header-title">Tahap Layanan: QnA (Solusi Mandiri)</div>
                            <div class="qna-header-sub">
                                Pilih kategori yang sesuai lalu klik <b>"Pilih"</b> pada pertanyaan yang mendekati
                                masalah Anda.
                            </div>
                        </div>
                        <div class="qna-chevron" id="qnaArrow">
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>

                    <div class="qna-body show" id="qnaDesc">
                        <div class="qna-body-text">
                            <b>Kategori pertanyaan yang tersedia:</b>
                            <div class="qna-cat-list">
                                <span class="qna-cat-pill"><i class="bi bi-globe2"></i> Umum</span>
                                <span class="qna-cat-pill guru"><i class="bi bi-person-badge"></i> Guru</span>
                                <span class="qna-cat-pill siswa"><i class="bi bi-mortarboard"></i> Siswa</span>
                            </div>
                            <ul>
                                <li><b>Umum</b> — dapat diakses oleh semua pengguna tanpa login.</li>
                                <li><b>Guru</b> — khusus untuk pengguna dengan akun guru (memerlukan login).</li>
                                <li><b>Siswa</b> — khusus untuk pengguna dengan akun siswa (memerlukan login).</li>
                            </ul>
                            Untuk membuka kategori <b>Guru</b> atau <b>Siswa</b>, pilih salah satu pertanyaan kemudian
                            klik tombol <b>"Pilih"</b>.
                            Sistem akan menampilkan form login agar Anda dapat masuk sesuai peran yang dipilih.
                        </div>
                        <div class="qna-tip">
                            <i class="bi bi-lightbulb-fill"></i>
                            <span>Jika solusi belum membantu, tekan <b>"Mulai Percakapan"</b> di bawah untuk mendapatkan
                                bantuan melalui chatbot atau admin.</span>
                        </div>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content shadow px-2 mx-md-5 py-3" style="margin-bottom:100px">
                    <div class="tab-pane fade show active" id="tab-umum" role="tabpanel">
                        @include('layanan-pelanggan.partials.kategori-list', ['items' => $tabUmum])
                    </div>
                    <div class="tab-pane fade" id="tab-guru" role="tabpanel">
                        @include('layanan-pelanggan.partials.kategori-list', ['items' => $tabGuru])
                    </div>
                    <div class="tab-pane fade" id="tab-siswa" role="tabpanel">
                        @include('layanan-pelanggan.partials.kategori-list', ['items' => $tabSiswa])
                    </div>
                </div>

            </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             BOTTOM ACTION BAR — QnA MODE
        ═══════════════════════════════════════════════ --}}
        <div id="adminButtonContainer" style="{{ $isAdminMode ? 'display:none;' : '' }}">
            <div class="action-bar">
                <button id="hubungiBtn" class="btn-start-chat" onclick="handleMainAction(this)">
                    <i class="bi bi-chat-dots-fill"></i>
                    Mulai Percakapan
                </button>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             MODAL: LOGIN — UNCHANGED LOGIC
        ═══════════════════════════════════════════════ --}}
        <div class="modal fade p-5" id="loginModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered custom-modal">
                <div class="modal-content" style="border-radius:20px; border:1px solid var(--border);">
                    <div class="modal-header" style="border-bottom:1px solid var(--border);">
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-shield-lock me-2" style="color:var(--primary)"></i>
                            Login Diperlukan
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div id="loginError" class="alert alert-danger d-none"></div>
                        <form id="loginForm" onsubmit="loginAllSubmit(); return false;">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Login Sebagai</label>
                                <select name="login_as" id="loginAs" class="form-select" required>
                                    <option value="">== Pilih ==</option>
                                    <option value="guru">Guru</option>
                                    <option value="siswa">Siswa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Username</label>
                                <input name="username" required class="form-control" autocomplete="username">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input name="password" type="password" required class="form-control"
                                    autocomplete="current-password">
                            </div>
                            <div class="d-grid">
                                <button id="loginSubmitBtn" type="submit" class="btn btn-primary"
                                    style="border-radius:12px; font-weight:700;">
                                    <span id="loginSubmitLabel">Login</span>
                                </button>
                            </div>
                        </form>
                        <div class="mt-2 text-muted small">Login sebagai Guru / Siswa sesuai akun.</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             MODAL: DETAIL MASALAH — UNCHANGED LOGIC
        ═══════════════════════════════════════════════ --}}
        <div class="modal fade p-5" id="problemModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered custom-modal">
                <div class="modal-content" style="border-radius:20px; border:1px solid var(--border);">
                    <div class="modal-header" style="border-bottom:1px solid var(--border);">
                        <h5 class="modal-title fw-bold" id="problemTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div id="problemSolution" class="mb-4"></div>
                        <div id="videoWrapper" class="mb-4" style="display:none;">
                            <h6 class="fw-bold mb-2"><i class="bi bi-play-circle me-1"
                                    style="color:var(--primary)"></i>Video Panduan</h6>
                            <div id="problemVideoContainer"></div>
                        </div>
                        <div id="fileWrapper" class="mb-3" style="display:none;">
                            <h6 class="fw-bold mb-2"><i class="bi bi-file-earmark me-1"
                                    style="color:var(--primary)"></i>File Panduan</h6>
                            <div id="problemFileContainer"></div>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid var(--border);">
                        <button id="hubungiBtn" class="btn-start-chat" onclick="handleMainAction(this)"
                            style="border-radius:12px;">
                            <i class="bi bi-chat-dots-fill"></i> Mulai Percakapan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             CHAT UI — REDESIGNED HEADER + BUBBLES
        ═══════════════════════════════════════════════ --}}
        <div class="row mt-4 mx-2" id="chatUI"
            @if (!$isAdminMode) style="visibility:hidden; height:0; overflow:hidden;" @endif>

            <div class="col-12 d-flex">
                <div class="card flex-fill"
                    style="overflow:hidden; border-radius:var(--radius-lg); border:1px solid var(--border); box-shadow:var(--shadow-md);">
                    <div class="card-body d-flex flex-column h-100 p-3 p-md-4">

                        @php
                            $statusLogin = 'Umum';
                            $isError = false;
                            $badgeClass = 's-umum';
                            if (!is_null($room->user_id) && !is_null($room->student_id)) {
                                $statusLogin = 'ERROR: Data tidak valid';
                                $isError = true;
                                $badgeClass = 's-error';
                            } elseif (!is_null($room->user_id)) {
                                $statusLogin = 'Guru';
                                $badgeClass = 's-guru';
                            } elseif (!is_null($room->student_id)) {
                                $statusLogin = 'Siswa';
                                $badgeClass = 's-siswa';
                            }
                        @endphp

                        <!-- ══ CHAT HEADER TOOLBAR — REDESIGNED ══ -->
                        <div class="chat-header" style="flex-direction: column; gap: 10px; align-items: stretch;">

                            <!-- Baris 1: Hubungi Admin (kiri) + Selesai (kanan) -->
                            <div class="d-flex justify-content-between align-items-center">
                                <button id="panggilLagiBtn">
                                    <i class="bi bi-telephone-fill"></i>
                                    Hubungi Admin
                                </button>
                                <button type="button" class="btn-selesai" data-bs-toggle="modal"
                                    data-bs-target="#finishModal">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </button>
                            </div>

                            <!-- Baris 2: Kode Ruangan + Status -->
                            <div class="text-center">
                                <div class="chat-room-label">Kode Ruangan</div>
                                <div class="chat-room-code-wrap" style="justify-content: center;">
                                    <div class="chat-room-code">{{ $room->room_code }}</div>
                                    <button class="btn-copy-code" id="btnCopyCode" title="Salin kode">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>

                                <!-- Status vertikal -->
                                <div class="status-wrap"
                                    style="display: flex; flex-direction: column; align-items: center; gap: 4px; margin-top: 6px;">

                                    <!-- Login Badge -->
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <small style="color: #888; font-size: 11px;">Klik dibawah ini untuk login akun
                                            Anda</small>
                                        <span id="statusBadge" class="status-badge {{ $badgeClass }}"
                                            style="cursor:pointer">
                                            <span class="status-dot"></span>
                                            Login: {{ $statusLogin }}
                                        </span>

                                    </div>

                                    <!-- ChatBot / Admin Badge -->
                                    {{-- @if ($room->chat_status === 'ChatBot')
                                        <span class="mode-badge bot"><i class="bi bi-robot"></i> Chatbot</span>
                                    @elseif($room->chat_status === 'Admin')
                                        <span class="mode-badge admin"><i class="bi bi-headset"></i> Admin</span>
                                    @endif --}}

                                </div>
                            </div>

                        </div>

                        <!-- ══ PETUNJUK COLLAPSIBLE — REDESIGNED ══ -->
                        <div class="chat-info-card" id="chatInfoCard">
                            <div class="chat-info-header" onclick="toggleChatInfo()">
                                <div class="chat-info-header-icon">
                                    <i class="bi bi-info-circle-fill"></i>
                                </div>
                                <div class="chat-info-header-text">
                                    Petunjuk Penggunaan Ruang Percakapan
                                    <div class="chat-info-header-sub">Klik untuk menyembunyikan</div>
                                </div>
                                <i class="bi bi-chevron-down chat-info-chevron" id="chatInfoArrow"></i>
                            </div>
                            <div class="chat-info-body show" id="chatInfoDesc"
                                style="height:auto; max-height: 500px;">
                                Halaman ini digunakan untuk menyampaikan pengaduan atau pertanyaan kepada layanan
                                pelanggan.
                                <br><br>
                                <b>Tahapan layanan:</b>
                                <ul>
                                    <li><b>Chatbot</b> — sistem mencoba menjawab pertanyaan Anda secara otomatis.</li>
                                    <li><b>Admin</b> — jika chatbot tidak dapat membantu, Anda dapat meminta bantuan
                                        admin.</li>
                                </ul>
                                <b>Cara menggunakan:</b>
                                <ul>
                                    <li>Ketik pesan untuk menjelaskan masalah yang Anda alami.</li>
                                    <li>Klik <b>"Hubungi Admin"</b> untuk beralih ke layanan langsung.</li>
                                    <li>Setelah beralih ke Admin, Anda dapat mengirim <b>gambar</b> sebagai bukti
                                        laporan.</li>
                                    <li>Tombol <b>"Hubungi Admin"</b> tersedia kembali setelah <b>5 menit</b>.</li>
                                </ul>
                                <small class="text-muted">Tips: Jelaskan masalah secara singkat dan jelas agar admin
                                    dapat membantu lebih cepat.</small>
                            </div>
                        </div>

                        <!-- ══ CHAT BOX ══ -->
                        <div id="chatBox" class="flex-grow-1 overflow-auto mb-3">
                            <!-- Empty state (akan disembunyikan JS saat ada pesan) -->

                        </div>

                        <!-- ══ FORM INPUT — REDESIGNED ══ -->
                        <form id="sendForm">
                            @csrf
                            <input type="hidden" id="roomId" value="{{ $room->id }}">
                            <input type="hidden" id="sender" value="Pelanggan">
                            <input type="hidden" id="currentUser" value="Pelanggan">
                            <input type="hidden" id="status_login" value="{{ $statusLogin }}">

                            <div class="chat-input-wrap">
                                <!-- Tombol Gambar -->
                                <button type="button" id="btnImage" class="btn-img-attach"
                                    data-status="{{ $room->chat_status }}">
                                    <i class="bi bi-image"></i>
                                </button>
                                <input type="file" id="uploadFileInput" name="file" accept="image/*" hidden>

                                <!-- Input pesan -->
                                <input type="text" id="msgInput" placeholder="Ketik pesan..." autocomplete="off"
                                    autocorrect="off" autocapitalize="off" spellcheck="false">

                                <!-- Kirim -->
                                <button type="submit" class="btn-send">
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             MODAL: IMAGE PREVIEW — UNCHANGED LOGIC
        ═══════════════════════════════════════════════ --}}
        <div class="modal fade" id="imagePreviewModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered custom-modal">
                <div class="modal-content" style="border-radius:20px;">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">Preview Gambar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalPreviewImg" src="" class="img-fluid"
                            style="transition:transform .3s; cursor:zoom-in; border-radius:10px;">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <small class="text-muted">Klik gambar untuk zoom</small>
                        <button type="button" id="modalSendBtn" class="btn btn-primary d-none"
                            style="border-radius:10px; font-weight:600;">Kirim</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             MODAL: SELESAI — UNCHANGED LOGIC
        ═══════════════════════════════════════════════ --}}
        <div class="modal fade" id="finishModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered custom-modal">
                <div class="modal-content" style="border-radius:20px; border:1px solid var(--border);">
                    <div class="modal-header" style="border-bottom:1px solid var(--border);">
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-star-fill me-2" style="color:var(--warning)"></i>
                            Konfirmasi Selesai
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('layanan-pelanggan.finish', $room->room_code) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rating (Wajib)</label>
                                <select name="rating" class="form-select" required style="border-radius:10px;">
                                    <option value="">Pilih Rating</option>
                                    <option value="5">⭐⭐⭐⭐⭐ — Sangat Puas</option>
                                    <option value="4">⭐⭐⭐⭐ — Puas</option>
                                    <option value="3">⭐⭐⭐ — Cukup</option>
                                    <option value="2">⭐⭐ — Kurang</option>
                                    <option value="1">⭐ — Tidak Puas</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Ulasan (Opsional)</label>
                                <textarea name="review" class="form-control" rows="3" placeholder="Tulis ulasan... (opsional)"
                                    style="border-radius:10px;"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top:1px solid var(--border);">
                            <button type="submit" class="btn-selesai w-100">
                                <i class="bi bi-check-circle"></i> Selesai &amp; Kirim Ulasan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- CONFIG SCRIPTS — UNCHANGED --}}
        <script class="fitur menyambungkan ke n8n">
            window.ChatRoomConfig = {
                roomId: "{{ $room->id }}",
                status: "{{ $room->chat_status }}",
                webhook: {
                    url: "http://n8n.tak-scimediaonline.my.id/webhook/d3336480-e428-478c-ba84-56c28938d66d/chat",
                    route: "general",
                },
            };
        </script>
        <script class="fitur menyambungkan ke Firebase">
            window.FirebaseConfig = {
                apiKey: "{{ config('firebase.api_key') }}",
                authDomain: "{{ config('firebase.auth_domain') }}",
                databaseURL: "{{ config('firebase.database_url') }}",
                projectId: "{{ config('firebase.project_id') }}",
                messagingSenderId: "{{ config('firebase.messaging_sender_id') }}",
                appId: "{{ config('firebase.app_id') }}"
            };
        </script>
        <script class="fitur membuat percakapan 2 arah" type="module" src="/js/cs-realtime.js"></script>

    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('assets_sneat/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets_sneat/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets_sneat/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets_sneat/js/main.js') }}"></script>


    {{-- ═══════════════════════════════════════════════
         SCRIPTS — ALL LOGIC UNCHANGED, only UI helpers added
    ═══════════════════════════════════════════════ --}}
    <script class="fitur layanan dasar cs">
        // Keep-alive
        setInterval(async () => {
            try {
                await fetch(window.location.href, {
                    method: "HEAD"
                });
            } catch (e) {}
        }, 5 * 60 * 1000);

        // ── Helpers ──────────────────────────────────
        function showConfirm(message, onConfirm) {
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#696CFF',
                cancelButtonColor: '#8592A3'
            }).then(r => {
                if (r.isConfirmed && typeof onConfirm === 'function') onConfirm();
            });
        }

        function showInfo(message) {
            Swal.fire({
                title: 'Informasi',
                text: message,
                icon: 'info',
                confirmButtonColor: '#696CFF',
                confirmButtonText: 'OK'
            });
        }

        function showToast(type, message) {
            Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                })
                .fire({
                    icon: type,
                    title: message
                });
        }

        // ── LOAD KATEGORI ──────────────────────────────────
        const problems = {};
        @foreach ($tabUmum as $c)
            problems["{{ $c->id }}"] = {
                id: {{ $c->id }},
                title: {!! json_encode($c->name) !!},
                solution: {!! json_encode($c->solution_text) !!},
                file: {!! json_encode($c->guide_file) !!},
                video: {!! json_encode($c->guide_video) !!},
                level: {!! json_encode($c->level) !!}
            };
        @endforeach
        @foreach ($tabSiswa as $c)
            problems["{{ $c->id }}"] = {
                id: {{ $c->id }},
                title: {!! json_encode($c->name) !!},
                solution: {!! json_encode($c->solution_text) !!},
                file: {!! json_encode($c->guide_file) !!},
                video: {!! json_encode($c->guide_video) !!},
                level: {!! json_encode($c->level) !!}
            };
        @endforeach
        @foreach ($tabGuru as $c)
            problems["{{ $c->id }}"] = {
                id: {{ $c->id }},
                title: {!! json_encode($c->name) !!},
                solution: {!! json_encode($c->solution_text) !!},
                file: {!! json_encode($c->guide_file) !!},
                video: {!! json_encode($c->guide_video) !!},
                level: {!! json_encode($c->level) !!}
            };
        @endforeach

        // ── BUKA DETAIL MASALAH — UNCHANGED ──────────────────────────────────
        function openProblemDetail(id) {
            const isLoggedIn = "{{ auth()->check() ? 'yes' : 'no' }}";
            const cat = problems[id];
            if (!cat) {
                showToast("error", "Kategori tidak ditemukan!");
                return;
            }
            if (cat.level !== "Umum" && isLoggedIn === "no") {
                localStorage.setItem('open_after_login', "{{ $room->room_code }}");
                localStorage.setItem('open_after_login_category', id);
                new bootstrap.Modal(document.getElementById('loginModal')).show();
                return;
            }
            fetch("{{ route('layanan-pelanggan.assign_category', $room->room_code) }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    category_id: id
                })
            }).catch(() => {});
            document.getElementById('problemTitle').textContent = `${cat.title} (${cat.level})`;
            document.getElementById('problemSolution').innerHTML =
                `<p>${cat.solution ?? 'Silakan baca panduan dan tonton video.'}</p>`;
            const videoWrapper = document.getElementById('videoWrapper');
            const videoBox = document.getElementById('problemVideoContainer');
            if (cat.video) {
                const isIframe = String(cat.video).includes('<iframe');
                videoBox.innerHTML =
                    `<div class="video-wrapper">${ isIframe ? cat.video : `<iframe src="${cat.video}" frameborder="0" allowfullscreen></iframe>` }</div>`;
                videoWrapper.style.display = 'block';
            } else {
                videoWrapper.style.display = 'none';
                videoBox.innerHTML = '';
            }
            const fileWrapper = document.getElementById('fileWrapper');
            const fileBox = document.getElementById('problemFileContainer');
            fileWrapper.style.display = 'block';
            if (cat.file) {
                fileBox.innerHTML =
                    `<a href="/storage/guide_files/${encodeURIComponent(cat.file)}" class="btn btn-danger w-100" target="_blank" rel="noopener noreferrer">Buka File Panduan</a>`;
            } else {
                fileBox.innerHTML = `<button class="btn btn-secondary w-100" disabled>File Tidak Tersedia</button>`;
            }
            new bootstrap.Modal(document.getElementById('problemModal')).show();
        }

        // ── LOGIN AJAX — UNCHANGED ──────────────────────────────────
        async function loginAllSubmit() {
            const form = document.getElementById('loginForm');
            const submitBtn = document.getElementById('loginSubmitBtn');
            const submitLabel = document.getElementById('loginSubmitLabel');
            const errorBox = document.getElementById('loginError');
            errorBox.classList.add('d-none');
            errorBox.textContent = '';
            const data = new FormData(form);
            if (!data.get('login_as')) {
                errorBox.textContent = "Silakan pilih login sebagai Guru atau Siswa.";
                errorBox.classList.remove('d-none');
                return;
            }
            const roomCode = localStorage.getItem('open_after_login') || "{{ $room->room_code }}";
            const categoryId = localStorage.getItem('open_after_login_category');
            data.append("room_code", roomCode);
            if (categoryId) data.append("category_id", categoryId);
            submitBtn.disabled = true;
            submitLabel.textContent = 'Tunggu...';
            try {
                const res = await fetch("{{ route('login.ajax') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': "application/json"
                    },
                    body: data
                });
                const json = await res.json();
                if (json.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('loginModal')).hide();
                    setTimeout(() => window.location.reload(true), 300);
                    return;
                }
                errorBox.textContent = json.message || "Gagal login.";
                errorBox.classList.remove('d-none');
            } catch (e) {
                errorBox.textContent = "Terjadi kesalahan koneksi.";
                errorBox.classList.remove('d-none');
            } finally {
                submitBtn.disabled = false;
                submitLabel.textContent = 'Login';
            }
        }

        // ── AUTO OPEN SETELAH LOGIN — UNCHANGED ──────────────────────────────────
        window.addEventListener('load', function() {
            const roomCode = localStorage.getItem('open_after_login');
            const categoryId = localStorage.getItem('open_after_login_category');
            const isLoggedIn = "{{ auth()->check() ? 'yes' : 'no' }}";
            if (roomCode && categoryId && isLoggedIn === "yes") {
                localStorage.removeItem('open_after_login');
                localStorage.removeItem('open_after_login_category');
                setTimeout(() => openProblemDetail(categoryId), 200);
            }
        });

        // ── STATUS BADGE CLICK — UNCHANGED ──────────────────────────────────
        document.addEventListener("DOMContentLoaded", function() {
            const badge = document.getElementById("statusBadge");
            if (!badge) return;
            badge.addEventListener("click", function() {
                const isLoggedIn = "{{ auth()->check() ? 'yes' : 'no' }}";
                if (isLoggedIn === "yes") {
                    showInfo("Anda sudah login.");
                    return;
                }
                new bootstrap.Modal(document.getElementById('loginModal')).show();
            });

            // ── COPY CODE BUTTON (NEW UI HELPER) ──
            const btnCopy = document.getElementById('btnCopyCode');
            if (btnCopy) {
                btnCopy.addEventListener('click', function() {
                    const code = "{{ $room->room_code }}";
                    navigator.clipboard.writeText(code).then(() => {
                        btnCopy.innerHTML = '<i class="bi bi-clipboard-check"></i>';
                        btnCopy.style.color = 'var(--success)';
                        showToast('success', 'Kode berhasil disalin!');
                        setTimeout(() => {
                            btnCopy.innerHTML = '<i class="bi bi-clipboard"></i>';
                            btnCopy.style.color = '';
                        }, 2000);
                    });
                });
            }
        });

        // ── HANDLE MAIN ACTION — UNCHANGED ──────────────────────────────────
        function handleMainAction(button) {
            const status = "{{ $room->chat_status }}";
            if (button.disabled) return;
            button.disabled = true;
            button.innerHTML = '<i class="bi bi-arrow-repeat"></i> Memproses...';
            if (status === "QnA") {
                fetch("{{ route('layanan-pelanggan.start_ai', $room->id) }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(r => {
                        if (!r.ok) throw new Error("Gagal");
                        return r.text();
                    })
                    .then(() => window.location.reload())
                    .catch(() => {
                        button.disabled = false;
                        button.innerHTML = '<i class="bi bi-chat-dots-fill"></i> Mulai Percakapan';
                        alert("Terjadi kesalahan, coba lagi.");
                    });
            }
        }

        function activateChatUI() {
            const modalEl = document.getElementById('problemModal');
            if (modalEl) bootstrap.Modal.getOrCreateInstance(modalEl).hide();
            document.getElementById('main-content').style.display = 'none';
            document.getElementById('adminButtonContainer').style.display = 'none';
            const chatUI = document.getElementById("chatUI");
            chatUI.style.visibility = "visible";
            chatUI.style.height = "auto";
            chatUI.style.overflow = "visible";
        }
        window.openProblemDetail = openProblemDetail;

        // ── POPUP KODE PENGADUAN — UNCHANGED ──────────────────────────────────
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Kode Ruangan Anda:',
                html: `<div class="mt-2"><b id="kodePengaduan" style="font-size:20px;letter-spacing:2px;color:var(--primary)">{{ $room->room_code }}</b><br><br><span class="text-muted" style="font-size:13px">Simpan kode ini untuk membuka kembali ruang ini.</span></div>`,
                icon: 'info',
                confirmButtonText: 'Mengerti',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#696CFF'
            }).then(() => {
                const kode = document.getElementById('kodePengaduan').innerText;
                navigator.clipboard.writeText(kode).then(() => showToast("success",
                    "Kode berhasil disalin!"));
            });
        });

        // ── PANGGIL LAGI / COOLDOWN — UNCHANGED ──────────────────────────────────
        const roomId = window.ChatRoomConfig.roomId;
        const COOLDOWN_KEY = "panggilLagiCooldown_" + roomId;
        const COOLDOWN_TIME = 5 * 60;
        const panggilBtn = document.getElementById("panggilLagiBtn");
        document.addEventListener("DOMContentLoaded", function() {
            checkCooldown();
        });

        panggilBtn.onclick = async function() {
            if (panggilBtn.disabled) return;
            const status = window.ChatRoomConfig.status;
            if (status === "ChatBot") {
                panggilBtn.disabled = true;
                panggilBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Memproses...';
                try {
                    await fetch("{{ route('layanan-pelanggan.set_admin', $room->id) }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    });
                    showToast("info", "Permintaan diteruskan ke Admin.");
                    window.ChatRoomConfig.status = "Admin";
                    const btnImage = document.getElementById("btnImage");
                    const fileInput = document.getElementById("uploadFileInput");
                    if (!btnImage || !fileInput) return;
                    if (window.ChatRoomConfig.status === "ChatBot") {
                        btnImage.classList.add("d-none");
                        btnImage.disabled = true;
                        fileInput.disabled = true;
                    } else {
                        btnImage.classList.remove("d-none");
                        btnImage.disabled = false;
                        fileInput.disabled = false;
                    }
                } catch (err) {
                    console.error(err);
                } finally {
                    panggilBtn.disabled = false;
                    panggilBtn.innerHTML = '<i class="bi bi-telephone-fill"></i> Hubungi Admin';
                }
            } else if (status === "Admin") {
                showConfirm("Yakin ingin memanggil ulang admin? Akan ada jeda 5 menit.", async function() {
                    panggilBtn.disabled = true;
                    panggilBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Memproses...';
                    try {
                        await startPanggilUlang();
                    } finally {}
                });
            }
        };

        async function startPanggilUlang() {
            const roomId = document.getElementById("roomId").value;
            await fetch("/layanan-pelanggan-pelapor/panggil-lagi/" + roomId, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                }
            });
            showInfo("Admin telah dipanggil ulang.");
            const endTime = Date.now() + (COOLDOWN_TIME * 1000);
            localStorage.setItem(COOLDOWN_KEY, endTime);
            startCooldown(COOLDOWN_TIME);
        }

        function checkCooldown() {
            const endTime = localStorage.getItem(COOLDOWN_KEY);
            if (!endTime) return;
            const end = parseInt(endTime, 10);
            const diff = Math.floor((end - Date.now()) / 1000);
            if (diff > 0) {
                panggilBtn.disabled = true;
                startCooldown(diff);
            } else {
                localStorage.removeItem(COOLDOWN_KEY);
                panggilBtn.disabled = false;
            }
        }

        function startCooldown(seconds) {
            panggilBtn.disabled = true;
            let remaining = seconds;
            const interval = setInterval(() => {
                if (remaining <= 0) {
                    clearInterval(interval);
                    panggilBtn.disabled = false;
                    panggilBtn.innerHTML = '<i class="bi bi-telephone-fill"></i> Hubungi Admin';
                    localStorage.removeItem(COOLDOWN_KEY);
                    return;
                }
                const m = String(Math.floor(remaining / 60)).padStart(2, "0");
                const s = String(remaining % 60).padStart(2, "0");
                panggilBtn.innerHTML = `<i class="bi bi-clock"></i> ${m}:${s}`;
                remaining--;
            }, 1000);
        }

        // ── TOGGLE QNA — updated to use class instead of display ──────────────────────────────────
        function toggleQna() {
            const desc = document.getElementById("qnaDesc");
            const header = document.getElementById("qnaHeaderEl");
            desc.classList.toggle("show");
            header.classList.toggle("open");
        }

        // ── TOGGLE CHAT INFO ──────────────────────────────────
        function toggleChatInfo() {
            const desc = document.getElementById("chatInfoDesc");
            const card = document.getElementById("chatInfoCard");
            desc.classList.toggle("show");
            card.classList.toggle("open");
        }
    </script>

    <script class="fitur login jika antara kolom siswa atau guru terisi">
        document.addEventListener("DOMContentLoaded", function() {
            const originalFetch = window.fetch;
            window.fetch = async function(...args) {
                const response = await originalFetch(...args);
                if (response.status === 401) {
                    if (!args[0].includes("login-all")) {
                        new bootstrap.Modal(document.getElementById('loginModal')).show();
                    }
                    throw new Error("Unauthorized");
                }
                return response;
            };
        });
    </script>

    <script class="fitur kirim gambar dan review">
        document.addEventListener("DOMContentLoaded", () => {
            const btnImage = document.getElementById("btnImage");
            const fileInput = document.getElementById("uploadFileInput");
            const roomId = document.getElementById("roomId").value;
            const modalEl = document.getElementById("imagePreviewModal");
            const modal = new bootstrap.Modal(modalEl);
            const previewImg = document.getElementById("modalPreviewImg");
            const sendBtn = document.getElementById("modalSendBtn");
            let selectedFile = null;

            if (window.ChatRoomConfig.status !== "Admin") {
                btnImage.classList.add("d-none");
                btnImage.disabled = true;
                fileInput.disabled = true;
            }
            btnImage?.addEventListener("click", () => {
                if (btnImage.disabled) return;
                fileInput.click();
            });
            fileInput?.addEventListener("change", () => {
                if (!fileInput.files.length) return;
                selectedFile = fileInput.files[0];
                previewImg.src = URL.createObjectURL(selectedFile);
                sendBtn.classList.remove("d-none");
                modal.show();
            });
            sendBtn?.addEventListener("click", async () => {
                if (!selectedFile) return;
                sendBtn.disabled = true;
                sendBtn.textContent = "Mengirim...";
                const formData = new FormData();
                formData.append("file", selectedFile);
                formData.append("_token", "{{ csrf_token() }}");
                try {
                    const response = await fetch(
                        "{{ route('layanan-pelanggan.upload', $room->id) }}", {
                            method: "POST",
                            body: formData
                        });
                    if (!response.ok) throw new Error();
                    modal.hide();
                    fileInput.value = "";
                    selectedFile = null;
                } catch (error) {
                    alert("Upload gagal.");
                }
                sendBtn.disabled = false;
                sendBtn.textContent = "Kirim";
            });
            window.previewImage = function(src) {
                previewImg.src = src;
                sendBtn.classList.add("d-none");
                modal.show();
            };
            let zoomed = false;
            previewImg?.addEventListener("click", function() {
                zoomed = !zoomed;
                this.style.transform = zoomed ? "scale(2)" : "scale(1)";
                this.style.cursor = zoomed ? "zoom-out" : "zoom-in";
            });
        });
    </script>

    <script class="fitur menampilkan gambar dan review" type="module">
        import {
            loadFiles,
            enableRealtime
        } from "/js/cs-realtime.js";
        const roomId = "{{ $room->id }}";
        const endpoint = "/layanan-pelanggan-pelapor/files";
        enableRealtime(roomId, endpoint, "logGambar");
    </script>

</body>

</html>
