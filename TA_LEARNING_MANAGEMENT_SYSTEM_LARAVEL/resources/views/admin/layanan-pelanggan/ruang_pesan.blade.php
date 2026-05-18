@extends('admin.layouts.app')

@section('title', 'Ruang Percakapan Admin')
@section('page_title', 'Ruang Percakapan Admin')

@section('content')

    @if (!$room)
        <div class="alert alert-warning text-center mt-4">
            <h5 class="fw-bold text-danger">⚠️ Ruangan Tidak Ditemukan</h5>
            <p>Kode ruangan ini sudah tidak tersedia atau telah dihapus.</p>
            <a href="{{ route('admin.layanan-pelanggan.index') }}" class="btn btn-primary btn-sm mt-2">Kembali</a>
        </div>
    @else
        <div class="row mt-4 mx-2" id="chatUI">

            <div class="col-12 d-flex">
                <div class=" flex-fill" style="height: 65vh; overflow: hidden;">
                    <div class="d-flex flex-column h-100">

                        <!-- HEADER -->
                        <div class="text-center mb-3">
                            <h5 class="mb-0">
                                Kode Ruangan: <b>{{ $room->room_code }}</b>
                            </h5>
                        </div>

                        <!-- CHAT BOX -->
                        <div id="chatBox" class="flex-grow-1 overflow-auto mb-3 px-2">
                        </div>

                        <!-- FORM INPUT -->
                        <form id="sendForm">
                            @csrf

                            <input type="hidden" id="roomId" value="{{ $room->id }}">
                            <input type="hidden" id="sender"
                                value="Admin({{ auth()->user()->username . '#' . auth()->user()->id }})">
                            <input type="hidden" id="currentUser"
                                value="Admin({{ auth()->user()->username . '#' . auth()->user()->id }})">

                            <div class="d-flex align-items-center gap-2">

                                <!-- Tombol Gambar -->
                                <button type="button" id="btnImage" class="btn btn-light border">
                                    <i class="bi bi-image"></i>
                                </button>

                                <!-- Input file (hidden) -->
                                <input type="file" id="uploadFileInput" name="file" accept="image/*" hidden>

                                <!-- Input pesan -->
                                <input type="text" id="msgInput" class="form-control" placeholder="Ketik pesan..."
                                    autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">

                                <!-- Tombol Kirim -->
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i>
                                </button>

                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>


        <!-- MODAL PREVIEW GAMBAR -->
        <div class="modal fade" id="imagePreviewModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered custom-modal">
                <div class="modal-content">

                    <div class="modal-header border-0">
                        <h5 class="modal-title">Preview Gambar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-center">

                        <img id="modalPreviewImg" src="" class="img-fluid"
                            style="transition: transform .3s; cursor: zoom-in;">

                    </div>

                    <div class="modal-footer justify-content-between">
                        <small class="text-muted">Klik gambar untuk zoom</small>

                        <!-- Tombol kirim khusus upload -->
                        <button type="button" id="modalSendBtn" class="btn btn-primary d-none">
                            Kirim
                        </button>
                    </div>


                </div>
            </div>
        </div>
    @endif
@endsection

@section('js')
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
    @if ($room)
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

                // ===============================
                // MODE 1: Upload Gambar
                // ===============================
                btnImage.addEventListener("click", () => {
                    fileInput.click();
                });

                fileInput.addEventListener("change", () => {

                    if (!fileInput.files.length) return;

                    selectedFile = fileInput.files[0];

                    previewImg.src = URL.createObjectURL(selectedFile);

                    // Tampilkan tombol Kirim
                    sendBtn.classList.remove("d-none");

                    modal.show();
                });

                // ===============================
                // Kirim Gambar
                // ===============================
                sendBtn.addEventListener("click", async () => {

                    if (!selectedFile) return;

                    sendBtn.disabled = true;
                    sendBtn.textContent = "Mengirim...";

                    const formData = new FormData();
                    formData.append("file", selectedFile);
                    formData.append("_token", "{{ csrf_token() }}");

                    try {

                        const response = await fetch(
                            "{{ route('admin.layanan-pelanggan.upload', $room->id) }}", {
                                method: "POST",
                                body: formData
                            }
                        );

                        if (!response.ok) throw new Error();

                        modal.hide();
                        selectedFile = null;
                        fileInput.value = "";

                    } catch (err) {
                        alert("Upload gagal.");
                    }

                    sendBtn.disabled = false;
                    sendBtn.textContent = "Kirim";
                });

                // ===============================
                // MODE 2: Hanya Preview (Klik dari chat)
                // ===============================
                window.previewImage = function(src) {

                    previewImg.src = src;

                    // Sembunyikan tombol Kirim
                    sendBtn.classList.add("d-none");

                    modal.show();
                };

                // ===============================
                // Zoom
                // ===============================
                let zoomed = false;

                previewImg.addEventListener("click", function() {
                    zoomed = !zoomed;
                    this.style.transform = zoomed ? "scale(2)" : "scale(1)";
                    this.style.cursor = zoomed ? "zoom-out" : "zoom-in";
                });

            });
        </script>
    @endif
@endsection
