@extends('admin.layouts.app')

@section('title', 'Riwayat Serial')
@section('page_title', 'Riwayat Serial')

@section('content')
    {{-- ============================================================
     FILTER BAR
     ============================================================ --}}
    <div class="row g-2 mb-3">

        {{-- Pencarian teks --}}
        <div class="col-md-4">
            <label class="form-label">Cari Serial</label>
            <input type="text" id="searchInput" class="form-control" placeholder="Ketik serial..." autocomplete="off">
        </div>

        {{-- Filter Status --}}
        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select id="filterStatus" class="form-select">
                <option value="">Semua</option>
                <option value="Baru">Baru</option>
                <option value="Perpanjang">Perpanjang</option>
            </select>
        </div>

        {{-- Filter Tanggal --}}
        <div class="col-md-3">
            <label class="form-label">Tanggal</label>
            <input type="date" id="filterTanggal" class="form-control">
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
    <div class="table-responsive mt-3">
        <table class="table table-striped table-bordered table-hover align-middle text-center" id="logTable">

            <thead class="table-light">
                <tr>
                    <th style="width:50px">No</th>
                    <th>Tanggal</th>
                    <th>Serial</th>
                    <th>Aktif (bulan)</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($logs as $i => $log)
                    @php
                        $waktu = \Carbon\Carbon::parse($log->created_at);
                    @endphp

                    {{--
                    data-* menyimpan nilai mentah untuk filter JS.
                    data-date pakai format Y-m-d agar cocok dengan input[type=date].
                --}}
                    <tr data-serial="{{ strtolower($log->serial->serial ?? '') }}" data-status="{{ $log->status }}"
                        data-date="{{ $waktu->format('Y-m-d') }}">
                        <td class="row-number">{{ $i + 1 }}</td>

                        {{-- Tanggal — tampilan tetap lengkap --}}
                        <td>
                            {{ $waktu->format('d/m/Y') }}<br>
                            <small class="text-muted">{{ $waktu->format('H:i') }}</small>
                        </td>

                        {{-- Serial --}}
                        <td class="fw-bold cell-serial" style="word-break:break-word">
                            {{ $log->serial->serial ?? '-' }}
                        </td>

                        {{-- Aktif --}}
                        <td>{{ $log->active }}</td>

                        {{-- Status --}}
                        <td>
                            @if ($log->status === 'Baru')
                                <span class="badge bg-success">Baru</span>
                            @elseif ($log->status === 'Perpanjang')
                                <span class="badge bg-warning text-dark">Perpanjang</span>
                            @else
                                <span class="badge bg-secondary">Tidak Terbaca</span>
                            @endif
                        </td>

                    </tr>

                @empty
                    <tr id="emptyOriginal">
                        <td colspan="5" class="text-muted py-3">Belum ada riwayat serial.</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="5"></th>
                </tr>
            </tfoot>

        </table>
    </div>

    {{-- Pesan kosong saat filter aktif tapi tidak ada hasil --}}
    <div id="emptyState" class="text-center text-muted py-4" style="display:none">
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
            const filterStatus = document.getElementById('filterStatus');
            const filterTanggal = document.getElementById('filterTanggal');
            const resetBtn = document.getElementById('resetFilter');
            const countVisible = document.getElementById('countVisible');
            const emptyState = document.getElementById('emptyState');
            const table = document.getElementById('logTable');

            // Hanya baris yang punya data-* (bukan baris "Belum ada riwayat")
            const rows = Array.from(table.querySelectorAll('tbody tr[data-serial]'));

            // ─── Simpan teks asli kolom serial untuk highlight ──────────
            rows.forEach(row => {
                const el = row.querySelector('.cell-serial');
                if (el) el.dataset.original = el.innerHTML;
            });

            // ─── Highlight keyword dalam text node ──────────────────────
            function applyHighlight(el, keyword) {
                el.innerHTML = el.dataset.original; // reset dulu
                if (!keyword) return;

                const escaped = keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const regex = new RegExp(`(${escaped})`, 'gi');

                // Jalan hanya di text node, aman dari tag HTML
                const walker = document.createTreeWalker(el, NodeFilter.SHOW_TEXT);
                const nodes = [];
                while (walker.nextNode()) nodes.push(walker.currentNode);
            }

            // ─── Filter utama ────────────────────────────────────────────
            function filterTable() {
                const keyword = searchInput.value.trim().toLowerCase();
                const status = filterStatus.value;
                const tanggal = filterTanggal.value; // format: "Y-m-d" dari input[type=date]

                let visible = 0;

                rows.forEach(row => {
                    const matchKeyword = !keyword || row.dataset.serial.includes(keyword);
                    const matchStatus = !status || row.dataset.status === status;

                    // Cocokkan data-date (Y-m-d) dengan nilai input tanggal (Y-m-d)
                    const matchTanggal = !tanggal || row.dataset.date === tanggal;

                    const show = matchKeyword && matchStatus && matchTanggal;
                    row.style.display = show ? '' : 'none';

                    if (show) {
                        visible++;

                        // Nomor urut dinamis — hanya baris yang tampil
                        const numCell = row.querySelector('.row-number');
                        if (numCell) numCell.textContent = visible;

                        // Highlight serial
                        const serialEl = row.querySelector('.cell-serial');
                        if (serialEl) applyHighlight(serialEl, keyword);
                    }
                });

                countVisible.textContent = visible;
                emptyState.style.display = (rows.length > 0 && visible === 0) ? 'block' : 'none';
            }

            // ─── Debounce untuk input teks (200ms) ──────────────────────
            let debounceTimer;
            searchInput.addEventListener('input', () => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(filterTable, 200);
            });

            // Select dan date langsung (tidak perlu debounce)
            filterStatus.addEventListener('change', filterTable);
            filterTanggal.addEventListener('change', filterTable);

            resetBtn.addEventListener('click', () => {
                searchInput.value = '';
                filterStatus.value = '';
                filterTanggal.value = '';
                filterTable();
            });

            // Inisialisasi counter saat load
            filterTable();

        }());
    </script>
@endsection
