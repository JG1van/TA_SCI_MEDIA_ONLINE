@extends('admin.layouts.app')

@section('title', 'Manajemen Siswa')
@section('page_title', 'Manajemen Siswa')

@section('content')

    {{-- ======================= INFORMASI KELAS ======================= --}}
    @if (isset($classroom))
        <div class="col-lg-12 col-md-12 bg-white p-3 shadow mb-3 rounded">
            <h5 class="fw-bold mb-3">Informasi Kelas</h5>
            <div class="row g-3">

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Nama Kelas</label>
                    <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="text"
                        class="form-control" value="{{ $classroom->name }}" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kode Serial</label>
                    <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="text"
                        class="form-control" value="{{ $classroom->serial->serial ?? '-' }}" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Guru Pengajar</label>
                    <input type="text" class="form-control" value="{{ $classroom->serial->user->name ?? '-' }}"
                        autocomplete="off" readonly>
                </div>

            </div>
        </div>
    @endif

    {{-- ======================= PENCARIAN & TAMBAH ======================= --}}
    <div class="row g-3 align-items-end mb-3">
        <div class="col-md-8">
            <label class="form-label">Pencarian</label>
            <input id="searchInput" type="text" class="form-control" placeholder="Cari Nama Siswa..." autocomplete="off">
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-primary w-100" id="btnPilihKelas" data-bs-toggle="modal"
                data-bs-target="#modalPilihKelas">
                <i class="fas fa-plus me-2"></i>Tambah Siswa
            </button>
        </div>
    </div>

    {{-- ======================= TABEL SISWA ======================= --}}
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Nama Kelas</th>
                    <th>Kode Serial</th>
                    <th>Guru Pengajar</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody id="studentBody">
                @forelse ($students as $index => $student)
                    @php
                        $isExpired =
                            $student->serial &&
                            $student->serial->expired_at &&
                            \Carbon\Carbon::parse($student->serial->expired_at)->isPast();
                    @endphp

                    <tr id="row{{ $student->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td class="student-name">{{ $student->name }}</td>
                        <td>{{ $student->username }}</td>
                        <td>{{ $student->classroom->name ?? '-' }}</td>
                        <td>
                            {{ $student->serial->serial ?? '-' }}
                            @if ($isExpired)
                                <span
                                    style="background:#fdecea; color:#c0392b; border:1px solid #c0392b;
                            font-size:11px; font-weight:600; padding:2px 8px; border-radius:20px;">
                                    <i class="fas fa-circle-xmark me-1"></i> Expired
                                </span>
                            @endif
                        </td>
                        <td>{{ $student->user->name ?? '-' }}</td>

                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                <button class="btn btn-warning btn-sm"
                                    style="min-width: 85px; {{ $isExpired ? 'opacity: 0.5; cursor: not-allowed;' : '' }}"
                                    @if (!$isExpired) onclick="editStudent('{{ $student->id }}')" @else disabled title="Serial sudah expired" @endif>
                                    @if ($isExpired)
                                        <i class="bi bi-lock-fill me-1"></i>
                                    @endif
                                    Detail / Edit
                                </button>

                                <button class="btn btn-danger btn-sm"
                                    @if (!$isExpired) onclick="hapusStudent('{{ $student->id }}', '{{ $student->name }}')"
                            @else
                                disabled
                                style="opacity: 0.5; cursor: not-allowed;"
                                title="Serial sudah expired" @endif>
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
                        <td colspan="7" class="text-muted text-center">Belum ada data siswa.</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="7"></th>
                </tr>
            </tfoot>

        </table>
    </div>

    {{-- ======================= MODAL PILIH KELAS ======================= --}}
    <div class="modal fade p-5" id="modalPilihKelas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog custom-modal modal-md mt-5">
            <form id="formPilihKelas" class="modal-content">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Pilih Kelas untuk Tambah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label fw-semibold">Pilih Kelas</label>
                    <select name="classroom_id" id="selectClassroom" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($classrooms as $class)
                            <option value="{{ $class->id }}">
                                {{ $class->name }} - (Guru: {{ $class->serial->user->name ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Lanjutkan</button>
                </div>

            </form>
        </div>
    </div>

    {{-- ======================= MODAL EDIT ======================= --}}
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

                                    <input type="text" id="editPassword" class="form-control border-2 rounded-3 mb-2"
                                        value="********" readonly>

                                    <button type="button" class="btn btn-outline-danger w-100 rounded-3"
                                        id="btnResetPassword">
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
        function notifSuccess(msg) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: msg,
                timer: 1800,
                showConfirmButton: false
            });
        }

        function notifError(msg) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: msg,
                confirmButtonText: 'Tutup'
            });
        }

        // ======================= SEARCH =======================
        document.getElementById("searchInput").addEventListener("keyup", function() {
            const keyword = this.value.toLowerCase();
            document.querySelectorAll("#studentBody tr").forEach(row => {
                const nama = row.querySelector(".student-name")?.textContent.toLowerCase() ?? "";
                row.style.display = nama.includes(keyword) ? "" : "none";
            });
        });

        // ======================= PILIH KELAS =======================
        document.getElementById("formPilihKelas").addEventListener("submit", function(e) {
            e.preventDefault();
            const id = document.getElementById("selectClassroom").value;
            if (id) window.location.href = `siswa/create?classroom_id=${id}`;
        });

        // ======================= LOAD DATA EDIT =======================
        function editStudent(id) {
            fetch(`/admin/siswa/${id}/edit`)
                .then(res => res.json())
                .then(result => {
                    if (!result.success) {
                        notifError('Data siswa tidak ditemukan.');
                        return;
                    }

                    const s = result.data;

                    // ===== SET VALUE =====
                    document.getElementById("editId").value = s.id;
                    document.getElementById("editName").value = s.name;
                    document.getElementById("editUsername").value = s.username;
                    document.getElementById("editNis").value = s.nis ?? '';
                    document.getElementById("editEmail").value = s.email ?? '';
                    document.getElementById("editPhone").value = s.phone ?? '';
                    document.getElementById("editSerialId").value = s.serial_id ?? '';
                    document.getElementById("editUserId").value = s.user_id ?? '';
                    document.getElementById("editClassroomId").value = s.classroom_id ?? '';
                    document.getElementById("editAbsen").value = s.absen_number ?? '';

                    // ===== RESET FILE INPUT =====
                    document.getElementById("editPhotoInput").value = "";

                    // ===== SET FOTO =====
                    document.getElementById("editPhotoPreview").src =
                        s.photo ?
                        `/admin/proxy/students/${s.photo}` :
                        `{{ asset('images/logo.webp') }}`;
                    document.getElementById("editNameCard").textContent = s.name;
                    // ===== OPEN MODAL =====
                    new bootstrap.Modal(document.getElementById("modalEdit")).show();
                })
                .catch(() => notifError('Gagal memuat data siswa.'));
        }


        // ======================= SIMPAN EDIT =======================
        document.getElementById("formEdit").addEventListener("submit", async function(e) {
            e.preventDefault();

            const form = this;
            const id = document.getElementById("editId").value;
            const formData = new FormData(form);

            // ✅ ambil tombol submit
            const btn = form.querySelector("button[type='submit']");
            const originalText = btn.innerHTML;

            // ✅ loading state
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';

            try {
                const res = await fetch(`/admin/siswa/${id}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "X-HTTP-Method-Override": "PUT"
                    },
                    body: formData
                });

                const result = await res.json();

                if (!result.success) {
                    notifError(result.message);

                    // ❗ balikin tombol
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    return;
                }

                bootstrap.Modal.getInstance(document.getElementById("modalEdit")).hide();
                notifSuccess(result.message);

                setTimeout(() => location.reload(), 1200);

            } catch (err) {
                notifError(err.message);

                // ❗ balikin tombol kalau error
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });

        // ======================= FOTO HANDLER =======================
        document.getElementById("btnEditPhoto").addEventListener("click", function() {
            document.getElementById("editPhotoInput").click();
        });

        document.getElementById("editPhotoInput").addEventListener("change", function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("editPhotoPreview").src = e.target.result;
            };
            reader.readAsDataURL(file);
        });


        // ======================= UPDATE NAMA REALTIME =======================
        document.getElementById("editName").addEventListener("input", function() {
            document.getElementById("editNameCard").textContent = this.value;
        });

        // ======================= RESET PASSWORD =======================
        document.getElementById("btnResetPassword").addEventListener("click", function() {
            const id = document.getElementById("editId").value;

            Swal.fire({
                title: 'Reset Password?',
                text: 'Password akan dikembalikan ke default (Siswa1234)',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#696CFF',
                cancelButtonColor: '#8592A3',
                reverseButtons: true
            }).then(result => {

                if (!result.isConfirmed) return;

                fetch(`/admin/siswa/${id}/reset-password`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(res => res.json())
                    .then(data => data.success ? notifSuccess(data.message) : notifError(data.message))
                    .catch(() => notifError('Gagal mereset password.'));
            });
        });

        // ======================= HAPUS SISWA =======================
        function hapusStudent(id, nama) {
            Swal.fire({
                title: 'Hapus Siswa?',
                text: `Yakin ingin menghapus "${nama}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#696CFF',
                cancelButtonColor: '#8592A3',
                reverseButtons: true
            }).then(result => {
                if (!result.isConfirmed) return;

                fetch(`/admin/siswa/${id}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(res => res.json())
                    .then(result => {
                        if (result.success) {
                            document.getElementById(`row${id}`).remove();
                            notifSuccess(result.message);
                        } else notifError(result.message);
                    })
                    .catch(() => notifError('Gagal menghapus.'));
            });
        }
    </script>
@endsection
