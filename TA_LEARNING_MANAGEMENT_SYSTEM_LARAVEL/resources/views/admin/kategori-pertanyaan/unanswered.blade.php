@extends('admin.layouts.app')

@section('title', 'Pertanyaan Tidak Terjawab')
@section('page_title', 'Pertanyaan Tidak Terjawab')

@section('content')

    <div class="row g-3 align-items-end mb-3">
        <div class="col-md-12">
            <label class="form-label">Pencarian</label>
            <input id="searchInput" type="text" class="form-control" placeholder="Cari Pertanyaan..." />
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th class="text-start">Pertanyaan</th>
                    <th>Kata Kunci</th>
                    <th>Total</th>
                    <th style="width:200px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="questionBody">
                @forelse($data as $index => $item)
                    <tr id="row{{ $item->id }}">
                        <td>{{ $index + 1 }}</td>

                        <td class="question-text text-start">
                            {{ $item->question }}
                        </td>

                        <td>
                            <span class="badge bg-secondary">
                                {{ $item->keyword ?? '-' }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                {{ $item->count ?? 0 }}x
                            </span>
                        </td>

                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-success btn-sm" onclick="pilihQuestion('{{ $item->id }}')">
                                    Pilih
                                </button>

                                <button class="btn btn-danger btn-sm" onclick="hapusQuestion('{{ $item->id }}')">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">
                            Tidak ada pertanyaan tidak terjawab.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    {{-- MODAL CONVERT --}}

    <div class="modal fade p-5" id="modalConvert" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog custom-modal">
            <form id="formConvert" class="modal-content" enctype="multipart/form-data">
                @csrf

                <div class="modal-header mb-3">
                    <h5 class="modal-title">Berikan Jawaban</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3" style="max-height:600px; overflow-y:auto; overflow-x:auto;">

                    <input type="hidden" id="convertId">

                    <div class="col-md-12">
                        <label class="form-label">Pertanyaan</label>
                        <textarea id="convertName" name="name" class="form-control" rows="3"></textarea>
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
                        <input type="file" name="guide_file" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Solusi</label>
                        <textarea id="convertSolution" name="solution_text" class="form-control"></textarea>
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
                    <button type="submit" class="btn btn-primary w-100">
                        Simpan
                    </button>
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
                text: msg
            });
        }

        // SEARCH
        document.getElementById("searchInput").addEventListener("keyup", function() {
            const keyword = this.value.toLowerCase();
            document.querySelectorAll('#questionBody tr').forEach(r => {
                const text = r.querySelector('.question-text').textContent.toLowerCase();
                r.style.display = text.includes(keyword) ? '' : 'none';
            });
        });

        // PILIH
        function pilihQuestion(id) {
            fetch(`/admin/pertanyaan-tidak-terjawab/${id}`)
                .then(res => res.json())
                .then(res => {
                    if (res.success) {

                        document.getElementById("convertId").value = res.data.id;
                        document.getElementById("convertName").value = res.data.question;

                        // isi solusi dari AI
                        if (editorConvert) {
                            editorConvert.setData(res.data.solution_text ?? '');
                        }
                        new bootstrap.Modal(
                            document.getElementById("modalConvert")
                        ).show();

                    } else {
                        notifError(res.message);
                    }
                });
        }
        // SUBMIT CONVERT
        document.getElementById("formConvert").addEventListener("submit", async function(e) {
            e.preventDefault();

            const id = document.getElementById("convertId").value;
            const fd = new FormData(this);
            if (editorConvert) {
                fd.set("solution_text", editorConvert.getData());
            }

            const res = await fetch(`/admin/pertanyaan-tidak-terjawab/${id}/convert`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: fd
            });

            const data = await res.json();

            if (data.success) {
                $('#modalConvert').modal('hide');
                document.getElementById(`row${id}`).remove();
                notifSuccess(data.message);
            } else {
                notifError(data.message);
            }
        });

        // HAPUS
        function hapusQuestion(id) {
            Swal.fire({
                title: 'Hapus?',
                text: 'Yakin ingin menghapus pertanyaan ini?',
                icon: 'warning',
                showCancelButton: true
            }).then(async result => {
                if (result.isConfirmed) {

                    const res = await fetch(`/admin/pertanyaan-tidak-terjawab/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await res.json();

                    if (data.success) {
                        document.getElementById(`row${id}`).remove();
                        notifSuccess(data.message);
                    } else {
                        notifError(data.message);
                    }
                }
            });
        }
        let editorConvert;

        document.addEventListener("DOMContentLoaded", function() {

            ClassicEditor.create(document.querySelector('#convertSolution'), {
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
                editorConvert = editor;
            });

        });
    </script>
@endsection
