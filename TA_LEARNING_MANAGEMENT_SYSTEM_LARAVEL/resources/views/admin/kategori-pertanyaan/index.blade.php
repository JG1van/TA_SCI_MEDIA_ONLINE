@extends('admin.layouts.app')

@section('title', 'Manajemen Kategori Pertanyaan')
@section('page_title', 'Manajemen Kategori Pertanyaan')

@section('content')
    {{-- Search + Button Tambah --}}
    <div class="row g-3 align-items-end mb-3">

        {{-- Search --}}
        <div class="col-md-6">
            <label class="form-label">Pencarian</label>
            <input id="searchInput" type="text" class="form-control" placeholder="Cari Nama Kategori..." />
        </div>

        {{-- Filter Level --}}
        <div class="col-md-3">
            <label class="form-label">Level</label>
            <select id="filterLevel" class="form-select">
                <option value="">Semua</option>
                <option value="Umum">Umum</option>
                <option value="Siswa">Siswa</option>
                <option value="Guru">Guru</option>
            </select>
        </div>

        {{-- Filter Status --}}
        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select id="filterStatus" class="form-select">
                <option value="">Semua</option>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
        </div>

        {{-- Tombol Unanswered --}}
        <div class="col-md-4">
            <a href="{{ route('admin.pertanyaan-tidak-terjawab.index') }}" class="btn btn-warning w-100">

                <i class="fas fa-question-circle me-2"></i>
                Pertanyaan Tidak Terjawab

            </a>
        </div>

        {{-- Tambah --}}
        <div class="col-md-8">
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalTambah">

                <i class="fas fa-plus me-2"></i>
                Tambah

            </button>
        </div>

    </div>
    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover align-middle text-center" id="categoryTable">
            <thead>
                <tr class="align-middle text-center">
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Tingkat Masalah</th>
                    <th>Status</th>
                    <th>File Panduan</th>
                    <th>Video Panduan</th>
                    <th style="width:180px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="categoryBody">
                @forelse($data as $index => $item)
                    <tr id="row{{ $item->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td class="category-name">{{ $item->name }}</td>
                        <td class="category-level">{{ $item->level }}</td>
                        <td class="category-status">{{ $item->category_status }}</td>

                        {{-- File Panduan --}}
                        <td>
                            @if ($item->guide_file)
                                <a href="{{ asset('storage/guide_files/' . $item->guide_file) }}" target="_blank"
                                    class="btn btn-secondary btn-sm">
                                    File
                                </a>
                            @else
                                <span class="text-muted">Tidak Ada</span>
                            @endif
                        </td>

                        {{-- Video Panduan --}}
                        <td>
                            @if ($item->guide_video)
                                <button class="btn btn-primary btn-sm" onclick="previewVideo('{{ $item->guide_video }}')">
                                    Video
                                </button>
                            @else
                                <span class="text-muted">Tidak Ada</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-warning btn-sm" style="min-width: 85px;"
                                    onclick="editCategory('{{ $item->id }}')">Detail
                                    / Edit</button>
                                <button class="btn btn-danger btn-sm"
                                    onclick="hapusCategory('{{ $item->id }}','{{ $item->name }}')">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted">Belum ada kategori.</td>
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

    {{-- Modal Tambah --}}
    <div class="modal fade p-5" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog custom-modal mt-5">
            <form id="formTambah" class="modal-content" enctype="multipart/form-data">
                @csrf
                <div class="modal-header mb-3">
                    <h5 class="modal-title">Tambah Kategori Pertanyaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3" style="max-height:600px; overflow-y:auto; overflow-x:auto;">
                    <div class="col-md-12">
                        <label class="form-label">Nama Kategori</label>
                        <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" name="name"
                            type="text" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tingkat Masalah</label>
                        <select name="level" class="form-select" required>
                            <option value="">== Pilih Level ==</option>
                            <option value="Umum">Umum</option>
                            <option value="Siswa">Siswa</option>
                            <option value="Guru">Guru</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">File Panduan</label>
                        <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="file"
                            name="guide_file" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Solusi</label>
                        <textarea name="solution_text" id="solutionEditor" class="form-control"></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Link Video Panduan (embed)</label>
                        <textarea name="guide_video" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Status Ditampilkan</label>
                        <select name="category_status" class="form-select">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade p-5" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog custom-modal mt-5">
            <form id="formEdit" class="modal-content" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header mb-3">
                    <h5 class="modal-title">Detail / Edit Kategori Pertanyaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3" style="max-height:500px; overflow-y:auto; overflow-x:auto;">
                    <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="hidden"
                        id="editId" name="id">
                    <div class="col-md-12">
                        <label class="form-label">Nama Kategori</label>
                        <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                            type="text" id="editName" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tingkat Masalah</label>
                        <select id="editLevel" name="level" class="form-select" required>
                            <option value="Umum">Umum</option>
                            <option value="Siswa">Siswa</option>
                            <option value="Guru">Guru</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">File Panduan Baru</label>
                        <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                            type="file" name="guide_file" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Solusi</label>
                        <textarea id="editSolutionText" name="solution_text" class="form-control"></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Link Video Panduan (embed)</label>
                        <textarea id="editGuideVideo" name="guide_video" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Status Ditampilkan</label>
                        <select id="editStatus" name="category_status" class="form-select">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
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

        function filterTable() {

            const keyword = document.getElementById("searchInput").value.toLowerCase();
            const level = document.getElementById("filterLevel").value;
            const status = document.getElementById("filterStatus").value;

            document.querySelectorAll("#categoryBody tr").forEach(row => {

                const name = row.querySelector(".category-name").textContent.toLowerCase();
                const rowLevel = row.querySelector(".category-level").textContent;
                const rowStatus = row.querySelector(".category-status").textContent;

                let show = true;

                // search
                if (keyword && !name.includes(keyword)) {
                    show = false;
                }

                // level
                if (level && rowLevel !== level) {
                    show = false;
                }

                // status
                if (status && rowStatus !== status) {
                    show = false;
                }

                row.style.display = show ? "" : "none";

            });

        }


        // event
        document.getElementById("searchInput").addEventListener("keyup", filterTable);
        document.getElementById("filterLevel").addEventListener("change", filterTable);
        document.getElementById("filterStatus").addEventListener("change", filterTable);
        // =======================
        // TAMBAH KATEGORI (WITH LOADING)
        // =======================
        document.getElementById("formTambah").addEventListener("submit", async function(e) {
            e.preventDefault();

            const btn = document.querySelector("#formTambah button[type=submit]");
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';

            try {
                let fd = new FormData(this);
                fd.set("solution_text", editorTambah.getData());
                const res = await fetch("{{ route('admin.kategori-pertanyaan.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: fd
                });

                let data = await res.json();

                if (data.success) {
                    $('#modalTambah').modal('hide');
                    notifSuccess(data.message);
                    setTimeout(() => location.reload(), 800);
                } else {
                    notifError(data.message);
                }
            } catch (err) {
                notifError("Terjadi kesalahan pada server");
            }

            btn.disabled = false;
            btn.innerHTML = 'Simpan';
        });

        // =======================
        // EDIT KATEGORI (WITH LOADING)
        // =======================
        function editCategory(id) {
            fetch(`/admin/kategori-pertanyaan/${id}/edit`).then(r => r.json()).then(res => {
                if (res.success) {
                    const c = res.data;
                    document.getElementById("editId").value = c.id;
                    document.getElementById("editName").value = c.name;
                    document.getElementById("editLevel").value = c.level;
                    if (editorEdit) {
                        editorEdit.setData(c.solution_text ?? '');
                    }
                    document.getElementById("editGuideVideo").value = c.guide_video ?? '';
                    document.getElementById("editStatus").value = c.category_status;
                    new bootstrap.Modal(document.getElementById("modalEdit")).show();
                } else {
                    notifError(res.message);
                }
            });
        }

        document.getElementById("formEdit").addEventListener("submit", async function(e) {
            e.preventDefault();

            const btn = document.querySelector("#formEdit button[type=submit]");
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';

            try {
                let id = document.getElementById("editId").value;
                let fd = new FormData(this);
                fd.set("solution_text", editorEdit.getData());

                const res = await fetch(`/admin/kategori-pertanyaan/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: fd
                });

                let data = await res.json();

                if (data.success) {
                    $('#modalEdit').modal('hide');
                    notifSuccess(data.message);
                    setTimeout(() => location.reload(), 800);
                } else {
                    notifError(data.message);
                }
            } catch (err) {
                notifError("Terjadi kesalahan pada server");
            }

            btn.disabled = false;
            btn.innerHTML = 'Simpan';
        });

        // =======================
        // HAPUS KATEGORI (WITH LOADING)
        // =======================
        function hapusCategory(id, nama) {
            Swal.fire({
                title: 'Hapus?',
                text: `Yakin ingin menghapus "${nama}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus'
            }).then(async x => {
                if (x.isConfirmed) {

                    // Swal.fire({
                    //     title: 'Menghapus...',
                    //     text: 'Mohon tunggu sebentar.',
                    //     allowOutsideClick: false,
                    //     didOpen: () => Swal.showLoading()
                    // });

                    const res = await fetch(`/admin/kategori-pertanyaan/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await res.json();

                    if (data.success) {
                        document.getElementById(`row${id}`).remove();
                        Swal.close();
                        notifSuccess(data.message);
                    } else {
                        notifError(data.message);
                    }
                }
            });
        }

        // Preview Video
        function previewVideo(embedCode) {
            const modalHtml = `
            <div class="modal fade p-5" id="videoModal" tabindex="-1">
                <div class="modal-dialog custom-modal mt-5">
                         <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Preview Video</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="video-wrapper">${embedCode}</div>
                    </div>
                </div>
            </div>
        `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
            videoModal.show();
            document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
                document.getElementById('videoModal').remove();
            });
        }

        let editorTambah;
        let editorEdit;

        document.addEventListener("DOMContentLoaded", function() {

            ClassicEditor.create(document.querySelector('#solutionEditor'), {
                toolbar: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'undo',
                    'redo'
                ],
                removePlugins: [
                    'Image',
                    'ImageUpload',
                    'MediaEmbed',
                    'Table',
                    'CKFinder',
                    'EasyImage',
                    'LinkImage',
                    'ImageToolbar',
                    'ImageCaption',
                    'ImageStyle'
                ]
            }).then(editor => {
                editorTambah = editor;
            });


            ClassicEditor.create(document.querySelector('#editSolutionText'), {
                toolbar: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'undo',
                    'redo'
                ],
                removePlugins: [
                    'Image',
                    'ImageUpload',
                    'MediaEmbed',
                    'Table',
                    'CKFinder',
                    'EasyImage',
                    'LinkImage',
                    'ImageToolbar',
                    'ImageCaption',
                    'ImageStyle'
                ]
            }).then(editor => {
                editorEdit = editor;
            });

        });
    </script>

@endsection
