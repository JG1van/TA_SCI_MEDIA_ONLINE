@extends('admin.layouts.app')

@section('title', 'Riwayat Layanan Pelanggan')
@section('page_title', 'Riwayat Layanan Pelanggan')

@section('content')

    {{-- ============================================================
     FILTER BAR
     ============================================================ --}}
    <div class="row g-3 mb-3">

        {{-- Pencarian teks --}}
        <div class="col-md-3">
            <label class="form-label">Cari Kode Ruangan</label>
            <input type="text" id="searchInput" class="form-control" placeholder="Ketik kode ruangan..." autocomplete="off">
        </div>

        {{-- Filter Tanggal --}}
        <div class="col-md-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" id="filterTanggal" class="form-control">
        </div>

        {{-- Filter Kategori --}}
        <div class="col-md-2">
            <label class="form-label">Kategori</label>
            <select id="filterKategori" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Filter Admin --}}
        <div class="col-md-2">
            <label class="form-label">Admin</label>
            <select id="filterAdmin" class="form-select">
                <option value="">Semua Admin</option>
                <option value="-">-</option>
                @foreach ($admins as $adm)
                    <option value="{{ $adm->username }}">{{ $adm->username }}</option>
                @endforeach
            </select>
        </div>

        {{-- Filter Penyelesaian --}}
        <div class="col-md-2">
            <label class="form-label">Status</label>
            <select id="filterResolution" class="form-select">
                <option value="">Semua</option>
                <option value="Admin">Admin</option>
                <option value="ChatBot">ChatBot</option>
                <option value="QnA">QnA</option>
            </select>
        </div>

        {{-- Reset --}}
        {{-- <div class="col-md-12">
            <label class="form-label">&nbsp;</label>
            <button id="resetFilter" class="btn btn-secondary w-100">Reset</button>
        </div> --}}

    </div>


    {{-- ============================================================
     TABEL UTAMA
     ============================================================ --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center w-100" id="riwayatTable">

            <thead class="table-light">
                <tr>
                    <th style="width:50px">No</th>
                    <th>Kode Ruangan</th>
                    <th>Waktu Selesai</th>
                    <th>Kategori</th>
                    <th>Status Penyelesaian</th>
                    <th>Rating</th>
                    <th style="width:150px">Aksi</th>
                </tr>
            </thead>

            <tbody id="riwayatBody">
                @forelse ($data as $index => $item)
                    @php
                        $completionTime = \Carbon\Carbon::parse($item->completion_time);
                        $adminUsername = $item->admin->username ?? '-';
                        $kategoriName = $item->question_category->name ?? '-';
                    @endphp

                    {{--
                    data-* menyimpan nilai bersih untuk filter JS.
                    Semua string di-lowercase dari PHP agar konsisten.
                --}}
                    <tr id="row{{ $item->id }}" data-room="{{ strtolower($item->room_code) }}"
                        data-date="{{ $completionTime->format('Y-m-d') }}" data-kategori="{{ $kategoriName }}"
                        data-admin="{{ $adminUsername }}" data-resolution="{{ $item->resolution_by }}">
                        <td class="row-number">{{ $index + 1 }}</td>

                        {{-- Kode Ruangan --}}
                        <td>
                            <span class="fw-semibold text-primary cell-room">
                                {{ $item->room_code }}
                            </span>
                        </td>

                        {{-- Waktu Selesai --}}
                        <td>
                            {{ $completionTime->format('d/m/Y') }}<br>
                            <small class="text-muted">{{ $completionTime->format('H:i:s') }}</small>
                        </td>

                        {{-- Kategori --}}
                        <td>{{ $kategoriName }}</td>

                        {{-- Status Penyelesaian --}}
                        <td>
                            @switch($item->resolution_by)
                                @case('Admin')
                                    <span class="badge bg-info">Admin</span>
                                @break

                                @case('ChatBot')
                                    <span class="badge bg-primary">ChatBot</span>
                                @break

                                @default
                                    <span class="badge bg-secondary">QnA</span>
                            @endswitch
                        </td>

                        {{-- Rating --}}
                        <td>
                            @if ($item->rating)
                                <span class="text-warning">⭐ {{ $item->rating }}/5</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                <button class="btn btn-info btn-sm"
                                    onclick="showDetail({
                                room_code:       '{{ $item->room_code }}',
                                kategori:        '{{ $kategoriName }}',
                                admin:           '{{ $adminUsername }}',
                                resolution:      '{{ $item->resolution_by }}',
                                created_at:      '{{ $item->created_at }}',
                                updated_at:      '{{ $item->updated_at }}',
                                completion_time: '{{ $item->completion_time }}',
                                rating:          '{{ $item->rating }}',
                                review:          `{{ $item->review ? addslashes($item->review) : 'Belum Ada Ulasan' }}`,
                                notes:           `{{ $item->notes ? addslashes($item->notes) : '' }}`
                            })">Detail</button>

                                @if (Auth::user()->role == 1)
                                    <button class="btn btn-danger btn-sm" onclick="hapusRiwayat('{{ $item->id }}')">
                                        Hapus
                                    </button>
                                @else
                                    <button class="btn btn-danger btn-sm" disabled style="cursor:not-allowed;opacity:0.5">
                                        Hapus
                                    </button>
                                @endif

                            </div>
                        </td>

                    </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-muted py-3">
                                Belum ada riwayat Layanan Pelanggan.
                            </td>
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

        {{-- Pesan kosong saat filter aktif tapi tidak ada hasil --}}
        <div id="emptyState" class="text-center text-muted py-4" style="display:none">
            Tidak ada data yang cocok dengan filter yang dipilih.
        </div>

    @endsection


    @section('js')

        {{-- ============================================================
     NOTIFIKASI GLOBAL
     ============================================================ --}}
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
        </script>

        {{-- ============================================================
     MODAL DETAIL
     ============================================================ --}}
        <script>
            function formatTanggal(tgl) {
                if (!tgl) return '-';
                return new Date(tgl).toLocaleString('id-ID');
            }

            function getBadge(resolution) {
                if (resolution === 'Admin') return '<span class="badge bg-info">Admin</span>';
                if (resolution === 'ChatBot') return '<span class="badge bg-primary">ChatBot</span>';
                return '<span class="badge bg-secondary">QnA</span>';
            }

            function showDetail(data) {
                Swal.fire({
                    title: 'Detail Layanan',
                    width: 1000,
                    html: `
        <div class="row text-start">
            <div class="col-md-5 border-end pe-3">
                <h6 class="mb-3">Informasi Layanan</h6>
                <div class="mb-2">
                    <small class="text-muted">Kode Ruangan</small><br>
                    <b>${data.room_code}</b>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Kategori Pertanyaan Terakhir Dipilih</small><br>
                    ${data.kategori}
                </div>
                <div class="mb-2">
                    <small class="text-muted">Status Penyelesaian</small><br>
                    ${getBadge(data.resolution)} (${data.admin})
                </div>
                <hr>
                <div class="mb-2">
                    <small class="text-muted">Waktu Dibuat</small><br>
                    ${formatTanggal(data.created_at)}
                </div>
                <div class="mb-2">
                    <small class="text-muted">Terakhir Diperbarui</small><br>
                    <small class="text-muted">(perubahan kategori atau status layanan)</small><br>
                    ${formatTanggal(data.updated_at)}
                </div>
                <div class="mb-2">
                    <small class="text-muted">Selesai</small><br>
                    ${formatTanggal(data.completion_time)}
                </div>
                <hr>
                <div class="mb-2">
                    <small class="text-muted">Rating</small><br>
                    ⭐ ${data.rating || '-'}
                </div>
                <div class="mb-2">
                    <small class="text-muted">Review</small><br>
                    ${data.review || '-'}
                </div>
            </div>
            <div class="col-md-7 ps-3">
                <h6 class="mb-3">Log Percakapan</h6>
                <div style="height:400px;overflow-y:auto;background:#f8f9fa;
                            border:1px solid #ddd;padding:10px;border-radius:6px;
                            font-size:13px;line-height:1.6">
                    ${data.notes ? data.notes.replace(/\n/g,'<br>') : 'Tidak ada percakapan'}
                </div>
            </div>
        </div>`,
                    confirmButtonText: 'Tutup'
                });
            }
        </script>

        {{-- ============================================================
     HAPUS RIWAYAT
     ============================================================ --}}
        <script>
            function hapusRiwayat(id) {
                Swal.fire({
                    title: 'Hapus Riwayat?',
                    text: 'Data riwayat akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#696CFF',
                    cancelButtonColor: '#D79771',
                }).then(result => {
                    if (!result.isConfirmed) return;

                    fetch(`/admin/layanan-pelanggan-admin/riwayat/${id}/hapus`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(result => {
                            if (result.success) {
                                document.getElementById(`row${id}`).remove();
                                // Update nomor urut setelah hapus
                                reindexRows();
                                notifSuccess(result.message);
                            } else {
                                notifError(result.message);
                            }
                        })
                        .catch(() => notifError('Terjadi kesalahan saat menghapus.'));
                });
            }

            // Hitung ulang nomor setelah baris dihapus
            function reindexRows() {
                let n = 1;
                document.querySelectorAll('#riwayatBody tr[data-room]').forEach(row => {
                    if (row.style.display !== 'none') {
                        row.querySelector('.row-number').textContent = n++;
                    }
                });
            }
        </script>

        {{-- ============================================================
     FILTER + HIGHLIGHT + DEBOUNCE
     ============================================================ --}}
        <script>
            (function() {
                'use strict';

                // ─── Elemen DOM ─────────────────────────────────────────────
                const searchInput = document.getElementById('searchInput');
                const filterTanggal = document.getElementById('filterTanggal');
                const filterKategori = document.getElementById('filterKategori');
                const filterAdmin = document.getElementById('filterAdmin');
                const filterResolution = document.getElementById('filterResolution');
                const resetBtn = document.getElementById('resetFilter');
                const countVisible = document.getElementById('countVisible');
                const emptyState = document.getElementById('emptyState');

                // Hanya baris yang punya data-room (bukan baris "Belum ada riwayat")
                const rows = Array.from(
                    document.querySelectorAll('#riwayatBody tr[data-room]')
                );

                // ─── Simpan teks asli kolom room untuk highlight ─────────────
                rows.forEach(row => {
                    const el = row.querySelector('.cell-room');
                    if (el) el.dataset.original = el.innerHTML;
                });

                // ─── Highlight keyword dalam text node ───────────────────────
                function applyHighlight(el, keyword) {
                    el.innerHTML = el.dataset.original;
                    if (!keyword) return;

                    const escaped = keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                    const regex = new RegExp(`(${escaped})`, 'gi');

                    const walker = document.createTreeWalker(el, NodeFilter.SHOW_TEXT);
                    const nodes = [];
                    while (walker.nextNode()) nodes.push(walker.currentNode);

                    nodes.forEach(node => {
                        if (!regex.test(node.textContent)) return;
                        regex.lastIndex = 0;
                        const span = document.createElement('span');
                    });
                }

                // ─── Filter utama ─────────────────────────────────────────────
                function filterTable() {
                    const keyword = searchInput.value.trim().toLowerCase();
                    const tanggal = filterTanggal.value; // Y-m-d
                    const kategori = filterKategori.value; // exact match
                    const admin = filterAdmin.value; // exact match
                    const resolution = filterResolution.value; // exact match

                    let visible = 0;

                    rows.forEach(row => {
                        // Setiap kondisi dibandingkan terhadap data-* yang sudah bersih
                        const matchKeyword = !keyword || row.dataset.room.includes(keyword);
                        const matchTanggal = !tanggal || row.dataset.date === tanggal;
                        const matchKategori = !kategori || row.dataset.kategori === kategori;
                        const matchAdmin = !admin || row.dataset.admin === admin;
                        const matchResolution = !resolution || row.dataset.resolution === resolution;

                        const show = matchKeyword && matchTanggal && matchKategori &&
                            matchAdmin && matchResolution;

                        row.style.display = show ? '' : 'none';

                        if (show) {
                            visible++;

                            // Nomor urut dinamis
                            const numCell = row.querySelector('.row-number');
                            if (numCell) numCell.textContent = visible;

                            // Highlight kode ruangan
                            const roomEl = row.querySelector('.cell-room');
                            if (roomEl) applyHighlight(roomEl, keyword);
                        }
                    });

                    countVisible.textContent = visible;
                    emptyState.style.display = (rows.length > 0 && visible === 0) ? 'block' : 'none';
                }

                // ─── Debounce untuk input teks (200ms) ───────────────────────
                let debounceTimer;
                searchInput.addEventListener('input', () => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(filterTable, 200);
                });

                // Select & date: langsung tanpa debounce
                filterTanggal.addEventListener('change', filterTable);
                filterKategori.addEventListener('change', filterTable);
                filterAdmin.addEventListener('change', filterTable);
                filterResolution.addEventListener('change', filterTable);

                resetBtn.addEventListener('click', () => {
                    searchInput.value = '';
                    filterTanggal.value = '';
                    filterKategori.value = '';
                    filterAdmin.value = '';
                    filterResolution.value = '';
                    filterTable();
                });

                // Inisialisasi saat load
                filterTable();

            }());
        </script>



    @endsection
