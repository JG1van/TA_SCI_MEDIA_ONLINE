<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sci Media Online | Layanan Pelanggan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <!-- ── ALERT HANDLING (unchanged) ── -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
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

    <div class="bg-scene"></div>

    <div class="page-wrapper">
        <div class="main-card">

            <!-- HEADER -->
            <div class="text-center fade-up">
                <div class="brand-badge"><span class="dot"></span>SCI Media Online</div>
                <h1 class="main-title"><span>Pusat Layanan</span> Pelanggan</h1>
                <div class="subtitle-pill">
                    Unit Layanan Bantuan <span class="sep">•</span>
                    Penanganan Pengaduan <span class="sep">•</span>
                    Dukungan Pelanggan
                </div>
                <p class="intro-text">
                    Mengalami kendala atau membutuhkan bantuan? Kami hadir untuk membantu Anda kapan saja.
                    Melalui Layanan Pelanggan SCI Media Online, Anda dapat menemukan solusi cepat dari daftar
                    panduan yang tersedia, atau langsung berkomunikasi dengan Customer Service (CS) melalui fitur pesan.
                    Pilih menu di bawah ini untuk memulai layanan baru atau melanjutkan layanan yang sebelumnya.
                </p>
            </div>

            <div class="section-divider fade-up"><span>Pilih Layanan</span></div>

            <!-- ══ ENVELOPES ══ -->
            <div class="envelopes-row fade-up">

                <!-- MULAI -->
                <div class="envelope-col">
                    <a href="/layanan-pelanggan-pelapor/create" class="envelope-link" aria-label="Mulai Pengaduan">
                        <div class="envelope env-mulai">
                            <div class="env-shadow"></div>
                            <div class="env-bottom"></div>
                            <div class="env-left"></div>
                            <div class="env-right"></div>
                            <div class="env-paper">
                                <div class="env-paper-lines">
                                    <i></i><i></i><i></i><i></i>
                                </div>
                            </div>
                            <div class="env-flap">
                                <div class="env-flap-face"></div>
                            </div>
                            <div class="env-seal"><i class="bi bi-send-fill"></i></div>
                            <div class="env-label">Mulai</div>
                            <div class="env-shine"></div>
                        </div>
                    </a>
                    <div class="env-info env-info-mulai">
                        <h6>Mulai Layanan</h6>
                        <p>Masukkan kode layanan untuk melanjutkan percakapan yang pernah dibuat dan
                            digunakan sebelumnya.</p>
                    </div>
                </div>

                <!-- LANJUT -->
                <div class="envelope-col">
                    <a href="#" class="envelope-link" id="btnLanjutPengaduan" aria-label="Lanjut Pengaduan">
                        <div class="envelope env-lanjut">
                            <div class="env-shadow"></div>
                            <div class="env-bottom"></div>
                            <div class="env-left"></div>
                            <div class="env-right"></div>
                            <div class="env-paper">
                                <div class="env-paper-lines">
                                    <i></i><i></i><i></i><i></i>
                                </div>
                            </div>
                            <div class="env-flap">
                                <div class="env-flap-face"></div>
                            </div>
                            <div class="env-seal"><i class="bi bi-arrow-repeat"></i></div>
                            <div class="env-label">Lanjut</div>
                            <div class="env-shine"></div>
                        </div>
                    </a>
                    <div class="env-info env-info-lanjut">
                        <h6>Lanjut Layanan</h6>
                        <p>Masukkan kode layanan untuk melanjutkan percakapan yang sebelumnya pernah
                            dibuat melalui sistem layanan.</p>
                    </div>
                </div>

            </div>

            <!-- KODE NOTE -->
            <div class="text-center fade-up">
                <div class="kode-note">
                    <i class="bi bi-key-fill" style="color:var(--primary)"></i>
                    Simpan kode pengaduan agar Anda dapat melanjutkan layanan.
                </div>
            </div>

            <!-- TAHAPAN -->
            <div class="section-divider fade-up mt-5"><span>Tahapan Layanan</span></div>

            <div class="timeline-wrap fade-up">
                <div class="timeline-connector"></div>

                <div class="timeline-item">
                    <div class="tl-icon-wrap"><i class="bi bi-patch-question-fill"></i></div>
                    <div class="tl-card">
                        <div class="tl-step">Langkah 01</div>
                        <div class="tl-title">QnA — Solusi Mandiri</div>
                        <div class="tl-desc">Sistem menampilkan daftar pertanyaan dan solusi yang dapat membantu Anda
                            menemukan jawaban secara mandiri tanpa perlu menunggu.</div>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="tl-icon-wrap"><i class="bi bi-robot"></i></div>
                    <div class="tl-card">
                        <div class="tl-step">Langkah 02</div>
                        <div class="tl-title">Chatbot Otomatis</div>
                        <div class="tl-desc">Jika solusi belum ditemukan, chatbot akan mencoba memberikan jawaban
                            otomatis berdasarkan data yang tersedia secara real-time.</div>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="tl-icon-wrap"><i class="bi bi-headset"></i></div>
                    <div class="tl-card">
                        <div class="tl-step">Langkah 03</div>
                        <div class="tl-title">Hubungi Admin</div>
                        <div class="tl-desc">Jika masalah belum terselesaikan, Anda dapat melanjutkan percakapan
                            langsung dengan admin kami hingga masalah benar-benar selesai.</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SCRIPT LANJUT PENGADUAN — UNCHANGED LOGIC -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const btn = document.getElementById("btnLanjutPengaduan");

            btn.addEventListener("click", function(e) {

                e.preventDefault();

                Swal.fire({

                    title: "Masukkan Kode Layanan",

                    input: "text",

                    inputPlaceholder: "1234-5678-ABCD-EFGH",

                    showCancelButton: true,

                    confirmButtonText: "Ya, lanjutkan",

                    cancelButtonText: "Batal",

                    reverseButtons: true,

                    confirmButtonColor: "#696CFF",

                    cancelButtonColor: "#8592A3",

                    inputValidator: (value) => {

                        if (!value) {

                            return "Kode tidak boleh kosong!";

                        }

                    }

                }).then(result => {

                    if (result.isConfirmed) {

                        let form = document.createElement("form");

                        form.method = "POST";

                        form.action = "{{ route('layanan-pelanggan.continue') }}";


                        let csrf = document.createElement("input");

                        csrf.type = "hidden";

                        csrf.name = "_token";

                        csrf.value = "{{ csrf_token() }}";


                        let input = document.createElement("input");

                        input.type = "hidden";

                        input.name = "room_code";

                        input.value = result.value;


                        form.appendChild(csrf);

                        form.appendChild(input);

                        document.body.appendChild(form);

                        form.submit();

                    }

                });

            });

        });
    </script>

</body>

</html>
