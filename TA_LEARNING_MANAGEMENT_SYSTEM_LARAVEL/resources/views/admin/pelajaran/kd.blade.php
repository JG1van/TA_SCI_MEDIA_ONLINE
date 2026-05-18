@extends('admin.layouts.app')

@section('title', 'Kompetensi Dasar')

@section('page_title')
    Manajemen Kompetensi Dasar (KD) - {{ $lesson->name }}
@endsection

@section('content')
    <div class="container-fluid py-3">

        {{-- Informasi Pelajaran --}}
        <div class="row mb-3 rounded">
            <h5 class="fw-bold mb-3">Informasi Pelajaran</h5>
            <div class="col-md-12">
                <label class="form-label fw-semibold">Nama Pelajaran</label>
                <input type="text" class="form-control" value="{{ $lesson->name }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Kelas</label>
                <input type="text" class="form-control" value="{{ $lesson->grade }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Semester</label>
                <input type="text" class="form-control" value="{{ $lesson->semester }}" readonly>
            </div>
        </div>

        {{-- Tabel Kompetensi Dasar --}}
        <div class="p-3 rounded">
            <div class="row g-3 align-items-end mb-3">
                <div class="col-md-8">
                    <label class="form-label">Pencarian</label>
                    <input type="text" id="searchKD" class="form-control" placeholder="Cari KD...">
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-primary w-100" id="btnTambah" data-bs-toggle="modal" data-bs-target="#modalKD">
                        <i class="fas fa-plus me-2"></i>Tambah KD
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle text-center" id="lessonTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Kode</th>
                            <th>Deskripsi</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="kdBody">
                        @forelse ($competences as $index => $item)
                            <tr id="row{{ $item->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->point }}</td>
                                <td class="kd-desc">{{ $item->description }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editKD('{{ $item->id }}')">Edit</button>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="hapusKD('{{ $item->id }}', '{{ $item->point }}')">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted text-center">Belum ada data KD.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    {{-- Modal Tambah / Edit KD --}}
    <div class="modal fade p-5" id="modalKD" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md mt-5 custom-modal">
            <form id="formKD" class="modal-content">
                @csrf
                <input type="hidden" id="kdId" name="id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah KD</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <label class="form-label">Poin KD</label>
                    <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="text"
                        id="point" name="point" class="form-control mb-3" placeholder="Contoh: KD-1.1">

                    <label class="form-label">Deskripsi KD</label>
                    <textarea autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" id="description"
                        name="description" class="form-control" rows="4" required></textarea>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script>
        // ── Data KD dari server ───────────────────────────────────────────
        const allKDPoints = @json($competences->pluck('point')->values());
        const lessonId = "{{ $lesson->id }}";

        // ── Notifikasi ────────────────────────────────────────────────────
        const notifSuccess = msg => Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: msg,
            timer: 1800,
            showConfirmButton: false
        });

        const notifError = msg => Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: msg,
            confirmButtonText: 'Tutup'
        });

        // ── Generate point KD berikutnya ──────────────────────────────────
        function generateNextKD() {
            const pattern = /^KD-(\d+)\.(\d+)$/i;
            let lastMajor = 1;
            let lastMinor = 0;
            let found = false;

            allKDPoints.forEach(point => {
                const match = point.match(pattern);
                if (match) {
                    const major = parseInt(match[1]);
                    const minor = parseInt(match[2]);
                    if (
                        !found ||
                        major > lastMajor ||
                        (major === lastMajor && minor > lastMinor)
                    ) {
                        lastMajor = major;
                        lastMinor = minor;
                        found = true;
                    }
                }
            });

            return found ? `KD-${lastMajor}.${lastMinor + 1}` : 'KD-1.1';
        }

        // ── Realtime Search ───────────────────────────────────────────────
        document.getElementById("searchKD").addEventListener("keyup", e => {
            const keyword = e.target.value.toLowerCase();
            document.querySelectorAll("#kdBody tr").forEach(row => {
                const desc = row.querySelector(".kd-desc")?.textContent.toLowerCase() || '';
                row.style.display = desc.includes(keyword) ? "" : "none";
            });
        });

        // ── Tombol Tambah KD ──────────────────────────────────────────────
        document.getElementById("btnTambah").addEventListener("click", () => {
            document.getElementById("modalTitle").textContent = "Tambah KD";
            document.getElementById("kdId").value = "";
            document.getElementById("point").value = generateNextKD();
            document.getElementById("description").value = "";
        });

        // ── Simpan (Tambah / Edit) ────────────────────────────────────────
        document.getElementById("formKD").addEventListener("submit", async e => {
            e.preventDefault();

            const id = document.getElementById("kdId").value;
            const formData = new FormData(e.target);
            const url = id ?
                `/admin/pelajaran/${lessonId}/kd/${id}` :
                `/admin/pelajaran/${lessonId}/kd`;

            const btn = e.target.querySelector("button[type='submit']");
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';

            try {
                formData.append('_method', id ? 'PUT' : 'POST');

                const res = await fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: formData
                });
                const result = await res.json();

                if (result.success) {
                    bootstrap.Modal.getInstance(document.getElementById('modalKD')).hide();
                    notifSuccess(result.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    notifError(result.message);
                }
            } catch (err) {
                notifError("Terjadi kesalahan: " + err.message);
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });

        // ── Edit KD ───────────────────────────────────────────────────────
        function editKD(id) {
            fetch(`/admin/pelajaran/${lessonId}/kd/${id}/edit`)
                .then(res => res.json())
                .then(result => {
                    if (result.success) {
                        document.getElementById("modalTitle").textContent = "Edit KD";
                        document.getElementById("kdId").value = result.data.id;
                        document.getElementById("point").value = result.data.point;
                        document.getElementById("description").value = result.data.description;
                        new bootstrap.Modal(document.getElementById('modalKD')).show();
                    } else {
                        notifError('Data KD tidak ditemukan.');
                    }
                })
                .catch(() => notifError('Gagal memuat data KD.'));
        }

        // ── Hapus KD ──────────────────────────────────────────────────────
        function hapusKD(id, kode) {
            Swal.fire({
                title: 'Hapus KD?',
                text: `Yakin ingin menghapus KD "${kode}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#696CFF',
                cancelButtonColor: '#8592A3',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`/admin/pelajaran/${lessonId}/kd/${id}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            }
                        })
                        .then(res => res.json())
                        .then(result => {
                            if (result.success) {
                                document.getElementById(`row${id}`)?.remove();
                                notifSuccess(result.message);
                            } else {
                                notifError(result.message);
                            }
                        })
                        .catch(() => notifError('Gagal menghapus data.'));
                }
            });
        }
    </script>
@endsection
