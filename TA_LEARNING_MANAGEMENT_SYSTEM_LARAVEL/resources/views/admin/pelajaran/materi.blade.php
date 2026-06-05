@extends('admin.layouts.app')
@section('title', 'Manajemen Materi')
@section('page_title')
    Manajemen Materi - {{ $lesson->name }}
@endsection

@section('content')
    <style>
        .tree-panel {
            background: var(--bs-white);
            border: 0.5px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
        }

        .form-panel-card {
            background: var(--bs-white);
            border: 0.5px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
        }

        .panel-header {
            padding: 14px 18px 12px;
            border-bottom: 0.5px solid #e0e0e0;
        }

        .tree-body {
            padding: 14px;
            max-height: 600px;
            overflow-y: auto;
        }

        .bab-card {
            background: #f8f8f8;
            border: 0.5px solid #e0e0e0;
            border-radius: 10px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .bab-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 14px;
        }

        .bab-label {
            font-weight: 500;
            font-size: 13.5px;
        }

        .subbab-card {
            margin: 0 10px 10px 10px;
            background: #fff;
            border: 0.5px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .subbab-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            background: #f4f4f4;
            border-bottom: 0.5px solid #e0e0e0;
        }

        .subbab-label {
            font-size: 13px;
            color: #555;
        }

        .materi-list {
            padding: 6px 8px;
        }

        .materi-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 10px;
            border-radius: 6px;
            margin-bottom: 4px;
            background: #f8f8f8;
        }

        .materi-item:last-child {
            margin-bottom: 0;
        }

        .materi-title {
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 280px;
        }

        .materi-meta {
            font-size: 11px;
            color: #888;
            margin-top: 2px;
            display: flex;
            gap: 8px;
        }

        .btn-actions {
            display: flex;
            gap: 5px;
            flex-shrink: 0;
            margin-left: 8px;
        }

        .btn-import-file {
            width: 100%;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-add-group {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 6px;
            margin-bottom: 14px;
        }

        .btn-add {
            padding: 8px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            width: 100%;
        }

        .form-panel-body {
            padding: 14px 18px;
        }

        .panel-divider {
            border: none;
            border-top: 0.5px solid #e0e0e0;
            margin: 12px 0;
        }
    </style>

    <div class="container-fluid py-3">

        {{-- Informasi Pelajaran --}}
        <div class="col-lg-12 col-md-12 mb-3 rounded">
            <h5 class="fw-bold mb-3">Informasi Pelajaran</h5>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Nama Pelajaran</label>
                    <input type="text" class="form-control" value="{{ $lesson->name ?? 'Belum ditentukan' }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kelas</label>
                    <input type="text" class="form-control" value="Kelas {{ $lesson->grade }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Semester</label>
                    <input type="text" class="form-control"
                        value="{{ $lesson->semester == 1 ? 'Semester 1 (Ganjil)' : 'Semester 2 (Genap)' }}" readonly>
                </div>
            </div>
        </div>

        <div class="row g-3">

            {{-- DAFTAR ISI --}}
            <div class="col-lg-7 col-md-12">
                <div class="tree-panel">
                    <div class="panel-header">
                        <h5 class="fw-bold mb-2" style="font-size:15px">Daftar Isi: {{ $lesson->name }}</h5>
                        <button class="btn btn-primary btn-import-file" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            <i class="bi bi-upload"></i> Import File
                        </button>
                    </div>

                    <div class="tree-body" id="lessonTree">
                        @foreach ($lesson->themes as $theme)
                            <div class="bab-card">
                                <div class="bab-header">
                                    <span class="bab-label">Bab {{ $theme->theme }}: {{ $theme->name }}</span>
                                    <div class="btn-actions">
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editItem('theme', {{ $theme->id }})">Edit</button>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="deleteItem('theme', {{ $theme->id }})">Hapus</button>
                                    </div>
                                </div>

                                @foreach ($theme->subthemes as $sub)
                                    <div class="subbab-card">
                                        <div class="subbab-header">
                                            <span class="subbab-label">Subbab {{ $sub->subtheme }}:
                                                {{ $sub->name }}</span>
                                            <div class="btn-actions">
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="editItem('subtheme', {{ $sub->id }})">Edit</button>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="deleteItem('subtheme', {{ $sub->id }})">Hapus</button>
                                            </div>
                                        </div>

                                        <div class="materi-list">
                                            @foreach ($sub->lessonItems as $item)
                                                <div class="materi-item">
                                                    <div style="flex:1;min-width:0">
                                                        <div class="materi-title">Materi {{ $item->number }}:
                                                            {{ $item->title }}</div>
                                                        <div class="materi-meta">
                                                            <span><i class="far fa-user"></i>
                                                                {{ $item->admin->username ?? 'Tidak Diketahui' }}</span>
                                                            <span><i class="far fa-calendar"></i>
                                                                {{ $item->created_at?->format('d M Y H:i') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="btn-actions">
                                                        <button class="btn btn-primary btn-sm"
                                                            onclick="previewVideo('{{ base64_encode($item->embed) }}')">Video</button>
                                                        <button class="btn btn-warning btn-sm"
                                                            onclick="editItem('item', {{ $item->id }})">Edit</button>
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="deleteItem('item', {{ $item->id }})">Hapus</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- FORM PANEL --}}
            <div class="col-lg-5 col-md-12">
                <div class="form-panel-card" id="formPanel">
                    <div class="panel-header">
                        <h5 class="fw-bold mb-0" id="formTitle" style="font-size:15px">Tambah Bab</h5>
                    </div>
                    <div class="form-panel-body">
                        <div class="btn-add-group">
                            <button class="btn btn-primary btn-add" onclick="showForm('theme','add')">+ Bab</button>
                            <button class="btn btn-warning btn-add" onclick="showForm('subtheme','add')">+ Subbab</button>
                            <button class="btn btn-danger btn-add" onclick="showForm('item','add')">+ Materi</button>
                        </div>
                        <hr class="panel-divider">
                        <form id="formData">
                            @csrf
                            <div id="formContent"></div>
                            <button type="submit" id="btnSimpan" class="btn btn-primary "
                                style="display:none">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Preview --}}
    <div class="modal fade p-5" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md mt-5 custom-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="previewContent"></div>
            </div>
        </div>
    </div>

    {{-- Modal Import --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md mt-5 custom-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Import Materi dari Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.pelajaran.import', ['lesson_id' => $lesson->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih File Excel (.xlsx)</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ asset('template/template_import_materi.xlsx') }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-download"></i> Download Template
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-upload"></i> Upload & Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const lessonId = {{ $lesson->id }};
        let currentType = 'theme',
            currentMode = 'add',
            currentId = null;

        function notifSuccess(msg) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: msg,
                timer: 1500,
                showConfirmButton: false
            });
        }

        function notifError(msg) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: msg || 'Terjadi kesalahan',
                confirmButtonText: 'Tutup'
            });
        }

        function showForm(type, mode, data = {}) {
            const btnSimpan = document.getElementById("btnSimpan");
            const formContent = document.getElementById("formContent");
            btnSimpan.style.display = "inline-block";
            currentType = type;
            currentMode = mode;
            currentId = data.id || null;

            document.getElementById("formTitle").innerText =
                (mode === 'add' ? 'Tambah ' : 'Edit ') +
                (type === 'theme' ? 'Bab' : type === 'subtheme' ? 'Subbab' : 'Materi');

            formContent.querySelectorAll('.helper-hidden-input').forEach(h => h.remove());
            let html = '';

            if (type === 'theme') {
                if (mode === 'edit') {
                    html +=
                        `<div class="mb-3"><label class="form-label fw-semibold">Nomor Bab</label>
                    <input type="number" name="theme" class="form-control" value="${data.theme || ''}" required></div>`;
                } else {
                    html += `<input type="hidden" name="theme" value="">`;
                }
                html += `<div class="mb-3"><label class="form-label fw-semibold">Nama Bab</label>
                <input type="text" name="name" class="form-control" value="${data.name || ''}" required></div>`;
            }

            if (type === 'subtheme') {
                html += `<div class="mb-3"><label class="form-label fw-semibold">Pilih Bab</label>
                <select name="theme_id" id="selectThemeSub" class="form-select" ${mode === 'edit' ? 'disabled' : ''} required>
                    <option value="">== Pilih ==</option>
                    @foreach ($lesson->themes as $t)
                        <option value="{{ $t->id }}">{{ 'Bab ' . $t->theme . ': ' . $t->name }}</option>
                    @endforeach
                </select></div>`;
                if (mode === 'edit') {
                    html +=
                        `<div class="mb-3"><label class="form-label fw-semibold">Nomor Subbab</label>
                    <input type="number" name="subtheme" class="form-control" value="${data.subtheme || ''}" required></div>`;
                } else {
                    html += `<input type="hidden" name="subtheme" value="">`;
                }
                html += `<div class="mb-3"><label class="form-label fw-semibold">Nama Subbab</label>
                <input type="text" name="name" class="form-control" value="${data.name || ''}" required></div>`;
            }

            if (type === 'item') {
                html += `
            <input type="hidden" name="lesson_id" value="${lessonId}">
            <input type="hidden" name="admin_id" value="{{ Auth::id() }}">
            <div class="mb-3">
                <select name="theme_id" id="selectThemeItem" class="form-select visually-hidden" ${mode === 'edit' ? 'disabled' : ''} required>
                    <option value="">== Pilih ==</option>
                    @foreach ($lesson->themes as $theme)
                        <option value="{{ $theme->id }}">{{ 'Bab ' . $theme->theme . ': ' . $theme->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3"><label class="form-label fw-semibold">Pilih Subbab</label>
                <select name="subtheme_id" id="selectSubItem" class="form-select" ${mode === 'edit' ? 'disabled' : ''} required>
                    <option value="">== Pilih ==</option>
                    @foreach ($lesson->themes as $theme)
                        @foreach ($theme->subthemes as $sub)
                            <option value="{{ $sub->id }}" data-theme="{{ $theme->id }}">
                                {{ 'Bab ' . $theme->theme . ' - Subbab ' . $sub->subtheme . ': ' . $sub->name }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>`;

                if (mode === 'edit') {
                    html +=
                        `<div class="mb-3"><label class="form-label fw-semibold">Nomor Materi</label>
                    <input type="number" name="number" class="form-control" value="${data.number || ''}" required></div>`;
                } else {
                    html += `<input type="hidden" name="number" value="">`;
                }

                html += `
            <div class="mb-3"><label class="form-label fw-semibold">Judul Materi</label>
                <input type="text" name="title" class="form-control" value="${data.title || ''}" required></div>
            <div class="mb-3"><label class="form-label fw-semibold">Embed / Link</label>
                <textarea name="embed" class="form-control" rows="3" required>${data.embed || ''}</textarea></div>`;
            }

            if (mode === 'edit') html += `<input type="hidden" name="id" value="${data.id}">`;
            formContent.innerHTML = html;

            setTimeout(() => {
                if (type === 'subtheme' && data.theme_id) {
                    const s = document.getElementById('selectThemeSub');
                    if (s) {
                        s.value = data.theme_id;
                        if (s.disabled) addHiddenHelperInput('theme_id', s.value);
                    }
                }
                if (type === 'item') {
                    const st = document.getElementById('selectThemeItem');
                    const ss = document.getElementById('selectSubItem');
                    if (data.theme_id && st) {
                        st.value = data.theme_id;
                        if (st.disabled) addHiddenHelperInput('theme_id', st.value);
                    }
                    if (data.subtheme_id && ss) {
                        ss.value = data.subtheme_id;
                        if (ss.disabled) addHiddenHelperInput('subtheme_id', ss.value);
                    }
                    if (ss) {
                        ss.addEventListener('change', e => {
                            const themeId = e.target.selectedOptions[0]?.getAttribute('data-theme');
                            if (themeId && st) {
                                st.value = themeId;
                                updateHiddenHelperInput('theme_id', themeId);
                            }
                        });
                    }
                }
            }, 50);
        }

        function addHiddenHelperInput(name, value) {
            const fc = document.getElementById("formContent");
            fc.querySelector(`.helper-hidden-input[name="${name}"]`)?.remove();
            const inp = document.createElement('input');
            inp.type = 'hidden';
            inp.name = name;
            inp.value = value || '';
            inp.className = 'helper-hidden-input';
            fc.appendChild(inp);
        }

        function updateHiddenHelperInput(name, value) {
            const el = document.getElementById("formContent").querySelector(`.helper-hidden-input[name="${name}"]`);
            if (el) el.value = value || '';
        }

        document.getElementById('formData').addEventListener('submit', e => {
            e.preventDefault();
            const form = e.target;
            for (let s of form.querySelectorAll('select[required]')) {
                if (s.disabled) continue;
                if (!s.value) return notifError('Silakan pilih semua opsi yang tersedia!');
            }
            Swal.fire({
                title: currentMode === 'add' ? 'Simpan Data Baru?' : 'Simpan Perubahan?',
                icon: 'question',
                confirmButtonColor: '#696CFF',
                cancelButtonColor: '#8592A3',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(result => {
                if (!result.isConfirmed) return;
                const data = Object.fromEntries(new FormData(form));
                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                const method = currentMode === 'add' ? 'POST' : 'PUT';
                const url = currentMode === 'add' ?
                    `/admin/pelajaran/${lessonId}/materi/${currentType}` :
                    `/admin/pelajaran/${lessonId}/materi/${currentType}/${currentId}`;
                fetch(url, {
                        method,
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(data)
                    })
                    .then(res => res.json())
                    .then(r => {
                        if (r.success) {
                            notifSuccess('Data berhasil disimpan!');
                            setTimeout(() => location.reload(), 800);
                        } else {
                            if (r.errors) notifError(Object.values(r.errors).flat().join('\n') || r
                                .message);
                            else notifError(r.message || 'Terjadi kesalahan');
                        }
                    })
                    .catch(err => notifError(err.message || 'Terjadi kesalahan jaringan'))
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = 'Simpan';
                    });
            });
        });

        document.addEventListener("click", e => {
            if (!e.target.closest("#formPanel") && !e.target.closest(".btn-add-group")) {
                document.getElementById("formContent").innerHTML = "";
                document.getElementById("btnSimpan").style.display = "none";
                document.getElementById("formTitle").innerText = "Tambah Bab";
            }
        });

        function editItem(type, id) {
            fetch(`/admin/pelajaran/${lessonId}/materi/${type}/${id}/edit`)
                .then(res => res.json())
                .then(r => {
                    if (!r.success) return notifError('Data tidak ditemukan!');
                    showForm(type, 'edit', r.data);
                })
                .catch(() => notifError('Gagal mengambil data.'));
        }

        function deleteItem(type, id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                confirmButtonColor: '#696CFF',
                cancelButtonColor: '#8592A3',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(result => {
                if (!result.isConfirmed) return;
                fetch(`/admin/pelajaran/${lessonId}/materi/${type}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(res => res.json())
                    .then(r => {
                        if (r.success) {
                            notifSuccess('Data berhasil dihapus!');
                            setTimeout(() => location.reload(), 800);
                        } else notifError(r.message);
                    })
                    .catch(() => notifError('Gagal menghapus data.'));
            });
        }

        function previewVideo(encodedEmbed) {
            document.getElementById('previewContent').innerHTML = `<div class="video-wrapper">${atob(encodedEmbed)}</div>`;
            new bootstrap.Modal(document.getElementById('previewModal')).show();
        }
    </script>
@endsection
