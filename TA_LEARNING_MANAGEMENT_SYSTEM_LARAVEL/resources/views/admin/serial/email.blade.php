@extends('admin.layouts.app')

@section('title', 'Riwayat Email')
@section('page_title', 'Riwayat Email Serial')

@section('content')

    {{-- ============================================================
     FILTER BAR
     ============================================================ --}}
    <div class="row g-2 mb-3">

        {{-- Pencarian teks --}}
        <div class="col-md-3">
            <label class="form-label">Cari Serial / Email / Subject</label>
            <input type="text" id="searchInput" class="form-control" placeholder="Ketik untuk mencari..." autocomplete="off">
        </div>

        {{-- Filter Jenis Email --}}
        <div class="col-md-3">
            <label class="form-label">Jenis Email</label>
            <select id="filterType" class="form-select">
                <option value="">Semua</option>
                <option value="Serial">Serial</option>
                <option value="Peringatan">Peringatan</option>
                <option value="Kedaluwarsa">Kedaluwarsa</option>
            </select>
        </div>

        {{-- Filter Status --}}
        <div class="col-md-2">
            <label class="form-label">Status</label>
            <select id="filterStatus" class="form-select">
                <option value="">Semua</option>
                <option value="Berhasil">Berhasil</option>
                <option value="Gagal">Gagal</option>
            </select>
        </div>

        {{-- Filter Metode --}}
        <div class="col-md-2">
            <label class="form-label">Metode</label>
            <select id="filterSource" class="form-select">
                <option value="">Semua</option>
                <option value="Otomatis">Otomatis</option>
                <option value="Login_Admin">Login Admin</option>
                <option value="Manual">Manual</option>
            </select>
        </div>

        {{-- Reset --}}
        <div class="col-md-2">
            <label class="form-label">&nbsp;</label>
            <button id="resetFilter" class="btn btn-secondary w-100">Reset</button>
        </div>

    </div>
    {{-- ============================================================
     TABEL UTAMA
     ============================================================ --}}
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover align-middle text-center" id="logTable">

            <thead class="table-light">
                <tr>
                    <th style="width:50px">No</th>
                    <th>Waktu</th>
                    <th>Serial</th>
                    <th>Email Tujuan</th>
                    <th>Subject</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Metode</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($emails as $i => $log)
                    @php $waktu = \Carbon\Carbon::parse($log->created_at); @endphp

                    {{--
                    PENTING: data-* attribute dipakai JS untuk filter.
                    Simpan nilai mentah (tanpa badge HTML) di sini.
                --}}
                    <tr data-serial="{{ strtolower($log->serial->serial ?? '') }}"
                        data-email="{{ strtolower($log->email_to) }}" data-subject="{{ strtolower($log->subject) }}"
                        data-type="{{ $log->email_type }}" data-status="{{ $log->status }}"
                        data-source="{{ $log->source }}">
                        {{-- Nomor: dirender ulang oleh JS saat filter aktif --}}
                        <td class="row-number">{{ $i + 1 }}</td>

                        {{-- Waktu --}}
                        <td>
                            {{ $waktu->format('d/m/Y') }}<br>
                            <small class="text-muted">{{ $waktu->format('H:i') }}</small>
                        </td>

                        {{-- Serial --}}
                        <td class="fw-bold cell-serial" style="word-break:break-word">
                            {{ $log->serial->serial ?? '-' }}
                        </td>

                        {{-- Email --}}
                        <td class="cell-email" style="word-break:break-word">
                            {{ $log->email_to }}
                        </td>

                        {{-- Subject --}}
                        <td class="cell-subject text-start" style="word-break:break-word">
                            {{ $log->subject }}
                        </td>

                        {{-- Jenis --}}
                        <td>
                            @if ($log->email_type === 'Peringatan')
                                <span class="badge bg-warning text-dark">Peringatan</span>
                            @elseif ($log->email_type === 'Kedaluwarsa')
                                <span class="badge bg-danger">Kedaluwarsa</span>
                            @else
                                <span class="badge bg-secondary">Serial</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            @if ($log->status === 'Berhasil')
                                <span class="badge bg-success">Berhasil</span>
                            @else
                                <span class="badge bg-danger">Gagal</span>
                            @endif
                        </td>

                        {{-- Metode / Source --}}
                        <td>
                            @if ($log->source === 'Otomatis')
                                <span class="badge bg-primary">Otomatis</span>
                            @elseif ($log->source === 'Login_Admin')
                                <span class="badge bg-info text-dark">Login Admin</span>
                            @else
                                <span class="badge bg-secondary">Manual</span>
                            @endif
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-muted py-3">Belum ada riwayat email.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{-- Pesan jika hasil filter kosong --}}
    <div id="emptyState" class="text-center text-muted py-4" style="display:none">
        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
        Tidak ada data yang cocok dengan filter yang dipilih.
    </div>


    {{-- ============================================================
     JAVASCRIPT — FILTER + HIGHLIGHT + DEBOUNCE
     ============================================================ --}}
    <script>
        (function() {
            'use strict';

            // ─── Elemen DOM ─────────────────────────────────────────────
            const searchInput = document.getElementById('searchInput');
            const filterType = document.getElementById('filterType');
            const filterStatus = document.getElementById('filterStatus');
            const filterSource = document.getElementById('filterSource');
            const resetBtn = document.getElementById('resetFilter');
            const countVisible = document.getElementById('countVisible');
            const emptyState = document.getElementById('emptyState');
            const table = document.getElementById('logTable');

            // Ambil semua baris data (kecuali baris "empty" yang tidak punya data-*)
            const rows = Array.from(
                table.querySelectorAll('tbody tr[data-serial]')
            );

            // ─── Highlight keyword dalam teks ───────────────────────────
            // Menyimpan teks asli agar bisa di-restore saat keyword dihapus
            rows.forEach(row => {
                ['cell-serial', 'cell-email', 'cell-subject'].forEach(cls => {
                    const el = row.querySelector('.' + cls);
                    if (el) el.dataset.original = el.innerHTML;
                });
            });

            function applyHighlight(el, keyword) {
                // Restore dulu ke teks asli
                el.innerHTML = el.dataset.original;
                if (!keyword) return;

                // Escape karakter regex spesial
                const escaped = keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const regex = new RegExp(`(${escaped})`, 'gi');

                // Hanya highlight text node, bukan tag HTML
            }

            function walkTextNodes(el, callback) {
                const walker = document.createTreeWalker(el, NodeFilter.SHOW_TEXT);
                const nodes = [];
                while (walker.nextNode()) nodes.push(walker.currentNode);
                nodes.forEach(callback);
            }

            // ─── Filter utama ────────────────────────────────────────────
            function filterTable() {
                const keyword = searchInput.value.trim().toLowerCase();
                const type = filterType.value;
                const status = filterStatus.value;
                const source = filterSource.value;

                let visible = 0;

                rows.forEach(row => {
                    const matchKeyword = !keyword ||
                        row.dataset.serial.includes(keyword) ||
                        row.dataset.email.includes(keyword) ||
                        row.dataset.subject.includes(keyword);

                    const matchType = !type || row.dataset.type === type;
                    const matchStatus = !status || row.dataset.status === status;
                    const matchSource = !source || row.dataset.source === source;

                    const show = matchKeyword && matchType && matchStatus && matchSource;

                    row.style.display = show ? '' : 'none';

                    if (show) {
                        visible++;
                        // Update nomor urut hanya untuk baris yang tampil
                        const numCell = row.querySelector('.row-number');
                        if (numCell) numCell.textContent = visible;

                        // Terapkan highlight ke kolom teks
                        ['cell-serial', 'cell-email', 'cell-subject'].forEach(cls => {
                            const el = row.querySelector('.' + cls);
                            if (el) applyHighlight(el, keyword);
                        });
                    }
                });

                // Update counter
                countVisible.textContent = visible;

                // Tampilkan/sembunyikan empty state
                emptyState.style.display = visible === 0 ? 'block' : 'none';
            }

            // ─── Debounce (200ms) untuk input teks ──────────────────────
            let debounceTimer;

            function debounce(fn, delay = 200) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(fn, delay);
            }

            // ─── Event listener ─────────────────────────────────────────
            searchInput.addEventListener('input', () => debounce(filterTable));
            filterType.addEventListener('change', filterTable);
            filterStatus.addEventListener('change', filterTable);
            filterSource.addEventListener('change', filterTable);

            resetBtn.addEventListener('click', () => {
                searchInput.value = '';
                filterType.value = '';
                filterStatus.value = '';
                filterSource.value = '';
                filterTable();
            });

            // Jalankan saat load untuk inisialisasi counter
            filterTable();

        }()); // IIFE — tidak mengotori global scope
    </script>

@endsection
