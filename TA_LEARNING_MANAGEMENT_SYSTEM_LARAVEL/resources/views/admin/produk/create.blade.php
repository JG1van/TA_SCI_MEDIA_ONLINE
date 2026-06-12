@extends('admin.layouts.app')

@section('title', 'Tambah Produk')
@section('page_title', 'Tambah Produk Pembelajaran')

@section('content')
    <form action="{{ route('admin.produk.store') }}" method="POST" id="formProduk">
        @csrf

        {{-- Nama Produk --}}
        <div class="mb-3">
            <label for="name" class="form-label required">Nama Produk</label>
            <input autocomplete="off" type="text" class="form-control" id="name" name="name"
                placeholder="Masukkan nama produk" required>
        </div>

        {{-- Tabel Materi --}}
        <label class="form-label">Daftar Materi</label>
        <div class="table-responsive mb-2" style="overflow-x: auto;">
            <table class="table table-striped table-bordered table-hover align-middle text-center" id="tabelMateri"
                style="min-width: 600px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Materi</th>
                        <th>Kelas</th>
                        <th>Semester</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#modalMateri">
            + Tambah Materi
        </button>

        {{-- Kelas --}}
        <div class="mb-3">
            <label for="grade" class="form-label required">Kelas</label>
            <select name="grade" id="grade" class="form-select" required>
                <option value="">== Pilih ==</option>
                @for ($i = 1; $i <= 6; $i++)
                    <option value="{{ $i }}">Kelas {{ $i }}</option>
                @endfor
                <option value="0">Belum Ditentukan</option>
            </select>
        </div>

        {{-- Hak Akses Kelas --}}
        <div class="mb-3">
            <label class="form-label required">Hak Akses Kelas</label>
            <div class="d-flex flex-wrap gap-2">
                @for ($i = 1; $i <= 6; $i++)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="grade_category[]" value="{{ $i }}"
                            id="hakAkses{{ $i }}">
                        <label class="form-check-label" for="hakAkses{{ $i }}">Kelas {{ $i }}</label>
                    </div>
                @endfor
            </div>
        </div>

        {{-- Semester --}}
        <div class="mb-3">
            <label for="semester" class="form-label required">Semester</label>
            <select name="semester" id="semester" class="form-select" required>
                <option value="">== Pilih ==</option>
                <option value="1">Ganjil (1)</option>
                <option value="2">Genap (2)</option>
                <option value="0">Belum Ditentukan</option>
            </select>
        </div>

        <input type="hidden" name="materi_json" id="materiJson">

        <button type="button" class="btn btn-primary w-100" onclick="konfirmasiSimpan()">
            Simpan Produk
        </button>
    </form>

    {{-- Modal Tambah Materi --}}
    <div class="modal fade" id="modalMateri" tabindex="-1" aria-labelledby="modalMateriLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMateriLabel">Pilih Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    {{-- Filter & Pencarian --}}
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-sm-5">
                            <input type="text" id="searchLesson" class="form-control form-control-sm"
                                placeholder="Cari nama pelajaran...">
                        </div>
                        <div class="col-6 col-sm-3">
                            <select id="filterKelas" class="form-select form-select-sm">
                                <option value="">Semua Kelas</option>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}">Kelas {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-6 col-sm-3">
                            <select id="filterSemester" class="form-select form-select-sm">
                                <option value="">Semua Semester</option>
                                <option value="1">Ganjil (1)</option>
                                <option value="2">Genap (2)</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-1 d-flex align-items-center">
                            <span id="jumlahDipilih" class="badge bg-primary">0 dipilih</span>
                        </div>
                    </div>

                    <div class="table-responsive" style="overflow-x: auto; max-height: 300px; overflow-y: auto;">
                        <table class="table table-striped table-bordered table-hover align-middle text-center"
                            id="tabelLesson" style="min-width: 650px;">
                            <thead class="sticky-top table-light">
                                <tr>
                                    <th style="width:40px;">
                                        <input type="checkbox" id="checkAll" title="Pilih semua">
                                    </th>
                                    <th>No</th>
                                    <th>Nama Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Semester</th>
                                    <th>Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lessons as $index => $lesson)
                                    <tr data-id="{{ $lesson->id }}" data-nama="{{ $lesson->name }}"
                                        data-grade="{{ $lesson->grade }}" data-semester="{{ $lesson->semester }}"
                                        data-category="{{ $lesson->category }}">
                                        <td>
                                            <input type="checkbox" class="checkLesson" value="{{ $lesson->id }}"
                                                data-id="{{ $lesson->id }}" data-nama="{{ $lesson->name }}"
                                                data-grade="{{ $lesson->grade }}"
                                                data-semester="{{ $lesson->semester }}"
                                                data-category="{{ $lesson->category }}">
                                        </td>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="text-start">{{ $lesson->name }}</td>
                                        <td>Kelas {{ $lesson->grade }}</td>
                                        <td>
                                            @if ($lesson->semester == 1)
                                                Ganjil (1)
                                            @elseif ($lesson->semester == 2)
                                                Genap (2)
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($lesson->category == 1)
                                                <span class="badge bg-info text-dark">Teori</span>
                                            @elseif ($lesson->category == 2)
                                                <span class="badge bg-warning text-dark">Soal</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnTambahTerpilih">
                        Tambahkan yang Dipilih
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const materiData = [];
            const tabelBody = document.querySelector("#tabelMateri tbody");

            // ── Label helpers ─────────────────────────────────────────
            function labelSemester(val) {
                if (val == 1) return 'Ganjil (1)';
                if (val == 2) return 'Genap (2)';
                return '<span class="text-muted">-</span>';
            }

            function labelKategori(val) {
                if (val == 1) return '<span class="badge bg-info text-dark">Teori</span>';
                if (val == 2) return '<span class="badge bg-warning text-dark">Soal</span>';
                return '<span class="text-muted">-</span>';
            }

            // ── Render tabel materi utama ─────────────────────────────
            function renderTabelMateri() {
                tabelBody.innerHTML = '';
                if (materiData.length === 0) {
                    tabelBody.innerHTML = `<tr><td colspan="6" class="text-muted">Belum ada materi.</td></tr>`;
                    document.getElementById("materiJson").value = "";
                    return;
                }
                materiData.forEach((item, index) => {
                    tabelBody.insertAdjacentHTML('beforeend', `
                        <tr>
                            <td>${index + 1}</td>
                            <td class="text-start">${item.nama}</td>
                            <td>Kelas ${item.grade}</td>
                            <td>${labelSemester(item.semester)}</td>
                            <td>${labelKategori(item.category)}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="hapusMateri(${index})">Hapus</button>
                            </td>
                        </tr>`);
                });
                document.getElementById("materiJson").value = JSON.stringify(materiData);
            }

            // ── Hapus materi ──────────────────────────────────────────
            window.hapusMateri = function(index) {
                Swal.fire({
                    title: 'Hapus Materi?',
                    text: 'Yakin ingin menghapus materi ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#696CFF',
                    cancelButtonColor: '#8592A3',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // un-check di modal jika masih terbuka
                        const removedId = materiData[index].id;
                        const cb = document.querySelector(`.checkLesson[data-id="${removedId}"]`);
                        if (cb) cb.checked = false;

                        materiData.splice(index, 1);
                        renderTabelMateri();
                        updateJumlahDipilih();
                        updateCheckAll();

                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            timer: 1000,
                            showConfirmButton: false
                        });
                    }
                });
            };

            // ── Tambahkan yang dipilih dari modal ─────────────────────
            document.getElementById("btnTambahTerpilih").addEventListener("click", function() {
                const checked = document.querySelectorAll(".checkLesson:checked");
                if (checked.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Belum ada yang dipilih!',
                        timer: 1200,
                        showConfirmButton: false
                    });
                    return;
                }
                let ditambah = 0;
                checked.forEach(cb => {
                    const id = cb.dataset.id;
                    if (!materiData.find(m => m.id == id)) {
                        materiData.push({
                            id: id,
                            nama: cb.dataset.nama,
                            grade: cb.dataset.grade,
                            semester: cb.dataset.semester,
                            category: cb.dataset.category,
                        });
                        ditambah++;
                    }
                });
                renderTabelMateri();
                bootstrap.Modal.getInstance(document.getElementById("modalMateri")).hide();

                const pesanDuplikat = checked.length - ditambah > 0 ?
                    ` (${checked.length - ditambah} sudah ada, dilewati)` : '';
                Swal.fire({
                    icon: 'success',
                    title: `${ditambah} materi ditambahkan!${pesanDuplikat}`,
                    timer: 1400,
                    showConfirmButton: false
                });
            });

            // ── Check All ─────────────────────────────────────────────
            document.getElementById("checkAll").addEventListener("change", function() {
                const visibleCheckboxes = document.querySelectorAll(
                    "#tabelLesson tbody tr:not([style*='none']) .checkLesson");
                visibleCheckboxes.forEach(cb => cb.checked = this.checked);
                updateJumlahDipilih();
            });

            document.addEventListener("change", function(e) {
                if (e.target.classList.contains("checkLesson")) {
                    updateJumlahDipilih();
                    updateCheckAll();
                }
            });

            function updateJumlahDipilih() {
                const n = document.querySelectorAll(".checkLesson:checked").length;
                document.getElementById("jumlahDipilih").textContent = n + ' dipilih';
            }

            function updateCheckAll() {
                const all = document.querySelectorAll("#tabelLesson tbody tr:not([style*='none']) .checkLesson");
                const checked = document.querySelectorAll(
                    "#tabelLesson tbody tr:not([style*='none']) .checkLesson:checked");
                document.getElementById("checkAll").checked = all.length > 0 && all.length === checked.length;
            }

            // ── Reset checkbox saat modal dibuka ──────────────────────
            document.getElementById("modalMateri").addEventListener("show.bs.modal", function() {
                // Sinkronkan checkbox dengan materiData yang ada
                document.querySelectorAll(".checkLesson").forEach(cb => {
                    cb.checked = !!materiData.find(m => m.id == cb.dataset.id);
                });
                updateJumlahDipilih();
                updateCheckAll();
            });

            // ── Filter & Pencarian ────────────────────────────────────
            function applyFilter() {
                const search = document.getElementById("searchLesson").value.toLowerCase();
                const kelas = document.getElementById("filterKelas").value;
                const semester = document.getElementById("filterSemester").value;

                document.querySelectorAll("#tabelLesson tbody tr").forEach(row => {
                    const nama = row.dataset.nama?.toLowerCase() ?? '';
                    const grade = row.dataset.grade ?? '';
                    const sem = row.dataset.semester ?? '';

                    const matchNama = nama.includes(search);
                    const matchKelas = kelas === '' || grade == kelas;
                    const matchSem = semester === '' || sem == semester;

                    row.style.display = (matchNama && matchKelas && matchSem) ? '' : 'none';
                });
                updateCheckAll();
            }

            document.getElementById("searchLesson").addEventListener("keyup", applyFilter);
            document.getElementById("filterKelas").addEventListener("change", applyFilter);
            document.getElementById("filterSemester").addEventListener("change", applyFilter);

            // ── Konfirmasi simpan produk ───────────────────────────────
            window.konfirmasiSimpan = function() {
                const nama = document.getElementById("name").value.trim();
                const grade = document.getElementById("grade").value || "0";
                const hakAkses = document.querySelectorAll('input[name="grade_category[]"]:checked');
                const semester = document.getElementById("semester").value || "0";

                if (!nama) return Swal.fire('Peringatan', 'Nama produk harus diisi.', 'warning');
                if (hakAkses.length === 0) return Swal.fire('Peringatan',
                    'Pilih setidaknya satu hak akses kelas.', 'warning');

                Swal.fire({
                    title: 'Simpan Produk?',
                    text: 'Pastikan semua data sudah benar.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#696CFF',
                    cancelButtonColor: '#8592A3',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("grade").value = grade;
                        document.getElementById("semester").value = semester;
                        document.getElementById("formProduk").submit();
                    }
                });
            };

            renderTabelMateri();
        });
    </script>
@endsection
