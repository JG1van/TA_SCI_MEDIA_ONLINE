@extends('admin.layouts.app')

@section('title', 'Data Siswa')
@section('page_title', 'Data Siswa')

@section('content')
    @if (!$classroom->serial || !$classroom->serial->user)
        <div class="alert alert-warning text-center mt-4">
            <h5 class="fw-bold text-danger">⚠️ Data Tidak Lengkap</h5>
            <p>Harap tentukan <strong>Guru Pengampu (User)</strong> di bagian <strong>halaman Serial</strong> terlebih
                dahulu sebelum menambahkan siswa.</p>
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-primary btn-sm mt-2">Kembali ke Data Kelas</a>
        </div>
    @else
        @php
            $isExpired =
                $classroom->serial->expired_at && \Carbon\Carbon::parse($classroom->serial->expired_at)->isPast();
        @endphp

        <div class="col-lg-12 col-md-12 bg-white p-3 shadow mb-3 rounded"
            style="{{ $isExpired ? 'border: 1.5px solid #c0392b;' : '' }}">

            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0">Informasi Kelas</h5>
                @if ($isExpired)
                    <span
                        style="background:#fdecea; color:#c0392b; border:1px solid #c0392b;
                         font-size:12px; font-weight:600; padding:4px 12px; border-radius:20px;">
                        <i class="fas fa-circle-xmark me-1"></i> Serial Expired
                    </span>
                @endif
            </div>

            <div class="row g-3">
                <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="hidden"
                    id="classroom_id" value="{{ $classroom->id }}">
                <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="hidden"
                    id="serial_id" value="{{ $classroom->serial->id }}">
                <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="hidden"
                    id="teacher_id" value="{{ $classroom->serial->user->id }}">

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nama Kelas</label>
                    <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="text"
                        class="form-control" value="{{ $classroom->name }}" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kode Serial</label>
                    <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="text"
                        class="form-control fw-bold"
                        style="{{ $isExpired ? 'background:#fdecea; border-color:#c0392b; color:#c0392b;' : '' }}"
                        value="{{ $classroom->serial->serial }}" readonly>
                    @if ($isExpired)
                        <small style="color:#c0392b;" class="mt-1 d-block">
                            <i class="fas fa-circle-xmark me-1"></i>
                            Expired sejak
                            {{ \Carbon\Carbon::parse($classroom->serial->expired_at)->translatedFormat('d F Y') }}
                        </small>
                    @endif
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Guru Pengajar</label>
                    <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="text"
                        class="form-control" value="{{ $classroom->serial->user->name }}" readonly>
                </div>
            </div>
        </div>

        <div class="row g-3 align-items-end mb-3">
            <div class="col-md-8">
                <label class="form-label">Pencarian</label>
                <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" id="searchInput"
                    type="text" class="form-control" placeholder="Cari Nama Siswa...">
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary w-100" id="btnTambah"
                    @if (!$isExpired) data-bs-toggle="modal" data-bs-target="#modalTambah"
        @else
            disabled
            style="opacity: 0.5; cursor: not-allowed;"
            title="Serial sudah expired, tidak dapat menambah siswa" @endif>
                    @if ($isExpired)
                        <i class="bi bi-lock-fill me-1"></i>
                    @endif
                    <i class="fas fa-plus me-2"></i>Tambah Siswa
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover align-middle text-center" id="studentTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="studentBody">
                    @forelse ($students as $index => $student)
                        <tr id="row{{ $student->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td class="student-name">{{ $student->name }}</td>
                            <td>{{ $student->username }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-warning btn-sm"
                                        style="min-width: 85px; {{ $isExpired ? 'opacity: 0.5; cursor: not-allowed;' : '' }}"
                                        @if (!$isExpired) onclick="editStudent('{{ $student->id }}')" @else disabled title="Serial sudah expired" @endif>
                                        Detail / Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm"
                                        @if (!$isExpired) onclick="hapusStudent('{{ $student->id }}', '{{ $student->name }}')" @else disabled style="opacity: 0.5; cursor: not-allowed;" title="Serial sudah expired" @endif>
                                        @if ($isExpired)
                                            <i class="bi bi-lock-fill me-1"></i>
                                        @endif
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted text-center">Belum ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6"></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="modal fade p-5" id="modalTambah" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md mt-5 custom-modal">
                <form id="formTambah" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                            type="hidden" name="classroom_id" value="{{ $classroom->id }}">
                        <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                            type="hidden" name="serial_id" value="{{ $classroom->serial->id }}">
                        <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                            type="hidden" name="user_id" value="{{ $classroom->serial->user->id }}">

                        <div class="col-md-12">
                            <label class="form-label">Nama</label>
                            <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                                type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Username </label>
                            <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                                type="text" name="username" class="form-control" required>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade p-5" id="modalEdit" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg mt-5 custom-modal">
                <form id="formEdit" class="modal-content border-0 shadow-lg rounded-4" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold">Detail / Edit Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="row align-items-center g-4">

                            {{-- FOTO --}}
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="bg-light rounded-4 p-4 d-flex flex-column align-items-center">
                                    <div class="position-relative">
                                        <img id="editPhotoPreview" src="{{ asset('images/logo.webp') }}"
                                            class="rounded-circle border bg-white" width="180" height="180"
                                            style="object-fit: cover;">

                                        <button type="button"
                                            class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0 translate-middle shadow"
                                            id="btnEditPhoto" style="width:35px;height:35px; display:none;">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </div>

                                    <input type="file" id="editPhotoInput" name="photo" accept="image/*" hidden>

                                    <h6 class="fw-bold mt-3 mb-0" id="editNameCard">Nama Siswa</h6>
                                </div>
                            </div>

                            {{-- FORM --}}
                            <div class="col-md-8">
                                <div class="row g-3">

                                    <input type="hidden" id="editId" name="id">
                                    <input type="hidden" name="serial_id" id="editSerialId">
                                    <input type="hidden" name="user_id" id="editUserId">
                                    <input type="hidden" name="classroom_id" id="editClassroomId">

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama</label>
                                        <input type="text" id="editName" name="name"
                                            class="form-control border-2 rounded-3" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Username</label>
                                        <input type="text" id="editUsername" name="username"
                                            class="form-control border-2 rounded-3" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">NIS</label>
                                        <input type="text" id="editNis" name="nis"
                                            class="form-control border-2 rounded-3">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">No Absen</label>
                                        <input type="number" id="editAbsen" name="absen_number"
                                            class="form-control border-2 rounded-3">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input type="email" id="editEmail" name="email"
                                            class="form-control border-2 rounded-3">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Telepon</label>
                                        <input type="text" id="editPhone" name="phone"
                                            class="form-control border-2 rounded-3">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Password</label>

                                        <input type="text" id="editPassword"
                                            class="form-control border-2 rounded-3 mb-2" value="********" readonly>

                                        <button type="button" class="btn btn-outline-danger w-100 rounded-3"
                                            id="btnResetPass">
                                            <i class="fas fa-undo me-1"></i> Reset Password
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer bg-light border-0">
                        <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    @endsection

    @section('js')
        <script>
            // ================================ NOTIFIKASI =================================
            const notifSuccess = (msg) =>
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: msg,
                    timer: 1600,
                    showConfirmButton: false,
                });

            const notifError = (msg) =>
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: msg,
                    confirmButtonText: "Tutup",
                });

            document.addEventListener("DOMContentLoaded", () => {

                // ============================ SEARCH SISWA ============================
                const searchInput = document.getElementById("searchInput");
                if (searchInput) {
                    searchInput.addEventListener("keyup", (e) => {
                        const keyword = e.target.value.toLowerCase();
                        document.querySelectorAll("#studentBody tr").forEach((row) => {
                            const nama =
                                row.querySelector(".student-name")?.textContent.toLowerCase() || "";
                            row.style.display = nama.includes(keyword) ? "" : "none";
                        });
                    });
                }

                // ============================ TAMBAH SISWA ============================
                const formTambah = document.getElementById("formTambah");
                if (formTambah) {
                    formTambah.addEventListener("submit", async (e) => {
                        e.preventDefault();

                        const btn = formTambah.querySelector("button[type='submit']");
                        const originalHTML = btn.innerHTML;
                        btn.disabled = true;
                        btn.innerHTML =
                            `<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...`;

                        try {
                            const res = await fetch("{{ route('admin.siswa.store') }}", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: new FormData(formTambah),
                            });

                            const result = await res.json();

                            if (result.success) {
                                bootstrap.Modal.getOrCreateInstance(
                                    document.getElementById("modalTambah")
                                ).hide();

                                notifSuccess(result.message);
                                setTimeout(() => location.reload(), 700);
                            } else notifError(result.message);
                        } catch (err) {
                            notifError("Terjadi kesalahan: " + err.message);
                        } finally {
                            btn.disabled = false;
                            btn.innerHTML = originalHTML;
                        }
                    });
                }

                // ============================ EDIT SISWA ============================
                const formEdit = document.getElementById("formEdit");
                if (formEdit) {
                    formEdit.addEventListener("submit", async (e) => {
                        e.preventDefault();

                        const id = document.getElementById("editId").value;
                        const btn = formEdit.querySelector("button[type='submit']");
                        const originalHTML = btn.innerHTML;

                        btn.disabled = true;
                        btn.innerHTML =
                            `<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...`;

                        const formData = new FormData(formEdit);
                        formData.append("_method", "PUT");

                        try {
                            const res = await fetch(`/admin/siswa/${id}`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: formData,
                            });

                            const result = await res.json();

                            if (result.success) {
                                bootstrap.Modal.getOrCreateInstance(
                                    document.getElementById("modalEdit")
                                ).hide();

                                notifSuccess(result.message);
                                setTimeout(() => location.reload(), 700);
                            } else notifError(result.message);
                        } catch (err) {
                            notifError("Terjadi kesalahan: " + err.message);
                        } finally {
                            btn.disabled = false;
                            btn.innerHTML = originalHTML;
                        }
                    });
                }

                // ============================ RESET PASSWORD ============================
                const btnReset = document.getElementById("btnResetPass");
                if (btnReset) {
                    btnReset.addEventListener("click", () => {
                        const id = document.getElementById("editId").value;

                        Swal.fire({
                            title: "Reset Password?",
                            text: "Password akan dikembalikan ke default (Siswa1234).",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Ya, Reset",
                            cancelButtonText: "Batal",
                            confirmButtonColor: "#696CFF",
                            cancelButtonColor: "#D79771",
                            reverseButtons: true,

                            // 🔥 Tambahan biar selalu paling atas
                            customClass: {
                                popup: "swal-zindex-top"
                            },
                        }).then(async (result) => {
                            if (!result.isConfirmed) return;

                            const originalHTML = btnReset.innerHTML;
                            btnReset.disabled = true;
                            btnReset.innerHTML =
                                `<span class="spinner-border spinner-border-sm me-2"></span> Mereset...`;

                            try {
                                const res = await fetch(`/admin/siswa/${id}/reset-password`, {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                });

                                const json = await res.json();
                                json.success ? notifSuccess(json.message) : notifError(json
                                    .message);
                            } catch {
                                notifError("Gagal mereset password.");
                            } finally {
                                btnReset.disabled = false;
                                btnReset.innerHTML = originalHTML;
                            }
                        });
                    });
                }

            });

            // ============================ LOAD DATA EDIT ============================
            window.editStudent = function(id) {
                fetch(`/admin/siswa/${id}/edit`)
                    .then(res => res.json())
                    .then(result => {
                        if (result.success) {
                            const s = result.data;

                            document.getElementById("editId").value = s.id;
                            document.getElementById("editName").value = s.name;
                            document.getElementById("editUsername").value = s.username;
                            document.getElementById("editEmail").value = s.email ?? '';
                            document.getElementById("editPhone").value = s.phone ?? '';
                            document.getElementById("editNis").value = s.nis ?? '';
                            document.getElementById("editAbsen").value = s.absen_number ?? '';
                            document.getElementById("editSerialId").value = s.serial_id ?? '';
                            document.getElementById("editUserId").value = s.user_id ?? '';
                            document.getElementById("editClassroomId").value = s.classroom_id ?? '';
                            // 🔥 FOTO
                            document.getElementById("editPhotoPreview").src =
                                s.photo ?
                                `/admin/proxy/${s.photo}` :
                                `{{ asset('images/logo.webp') }}`;

                            document.getElementById("editNameCard").innerText = s.name;

                            bootstrap.Modal.getOrCreateInstance(
                                document.getElementById("modalEdit")
                            ).show();

                        } else notifError("Data siswa tidak ditemukan.");
                    })
                    .catch(() => notifError("Gagal memuat data siswa."));
            };
            // ============================ HAPUS SISWA ============================
            window.hapusStudent = function(id, nama) {
                Swal.fire({
                    title: "Hapus Siswa?",
                    text: `Yakin ingin menghapus "${nama}"?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Hapus",
                    cancelButtonText: "Batal",
                    confirmButtonColor: "#696CFF",
                    cancelButtonColor: "#D79771",
                    reverseButtons: true,
                }).then(async (result) => {
                    if (!result.isConfirmed) return;

                    try {
                        const res = await fetch(`/admin/siswa/${id}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                        });

                        const data = await res.json();

                        if (data.success) {
                            document.getElementById(`row${id}`)?.remove();
                            notifSuccess(data.message);
                        } else notifError(data.message);
                    } catch {
                        notifError("Gagal menghapus data.");
                    }
                });
            };
            document.getElementById("btnEditPhoto").onclick = () => {
                document.getElementById("editPhotoInput").click();
            };

            document.getElementById("editPhotoInput").onchange = function(e) {
                const file = e.target.files[0];
                if (file) {
                    document.getElementById("editPhotoPreview").src = URL.createObjectURL(file);
                }
            };
        </script>



    @endif
@endsection
