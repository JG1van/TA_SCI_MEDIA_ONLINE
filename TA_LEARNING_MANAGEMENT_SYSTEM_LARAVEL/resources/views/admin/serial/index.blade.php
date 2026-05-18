@extends('admin.layouts.app')

@section('title', 'Manajemen Serial')
@section('page_title', 'Manajemen Serial')

@section('content')
    {{-- ===============================
     🔔 NOTIFIKASI UTAMA
================================ --}}
    @if (
        (isset($expiringSoonSerials) && $expiringSoonSerials->count()) ||
            (isset($expiredSerials) && $expiredSerials->count()))
        <div class="alert alert-warning border-0 shadow">
            <h5 class="fw-bold bg-warning text-dark p-2 rounded-top">
                ⚠️ PEMBERITAHUAN SERIAL DENGAN MASA AKTIF MENDEKATI / TELAH BERAKHIR
            </h5>

            <div class="bg-light p-3 rounded-bottom">

                {{-- ⏰ Akan Expired --}}
                @if ($expiringSoonSerials->count())
                    <p class="mb-2">
                        ⏰ <strong>{{ $expiringSoonSerials->count() }}</strong> serial
                        akan berakhir masa aktifnya dalam waktu kurang dari 1 bulan.
                    </p>
                @endif

                {{-- 🚨 Sudah Expired (<=14 bulan) --}}
                @if ($expiredSerials->count())
                    <p class="mb-2 text-danger">
                        🚨 <strong>{{ $expiredSerials->count() }}</strong> serial
                        telah berakhir masa aktifnya dan memerlukan tindakan.
                    </p>
                @endif

                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalExpiringSoon">
                    <i class="fas fa-cogs me-2"></i>Mulai Tindakan
                </button>

            </div>
        </div>
    @endif


    {{-- ===============================
     ⚠️ EXPIRED > 14 BULAN
================================ --}}
    @if (isset($expiredMoreThan14Months) && $expiredMoreThan14Months->count())
        <div class="alert alert-danger border-0 shadow">
            <h5 class="fw-bold text-white bg-danger p-2 rounded-top">
                ⚠️ PERINGATAN SISTEM: SERIAL KADALUWARSA > 14 Bulan
            </h5>

            <div class="bg-light text-dark p-3 rounded-bottom">
                <p class="mb-2">
                    Ditemukan <strong>{{ $expiredMoreThan14Months->count() }}</strong> serial yang
                    <strong>telah melewati masa expired lebih dari 14 Bulan</strong>.
                </p>

                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalExpiredDelete">
                    <i class="fas fa-trash me-2"></i>Mulai Tindakan
                </button>
            </div>
        </div>
    @endif
    {{--   Pencarian & Tombol Tambah --}}
    <div class="row g-3 align-items-end mb-3">

        <div class="col-md-6">
            <label class="form-label">Pencarian</label>
            <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" id="searchInput"
                type="text" class="form-control" placeholder="Cari Serial / Produk / Pengguna..." />
        </div>
        <div class="col-md-2">
            <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#modalRiwayat">
                <i class="fas fa-history me-2"></i>Riwayat
            </button>
        </div>
        <div class="col-md-4 ">
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus me-2"></i>Tambah Serial
            </button>
        </div>

    </div>

    {{--   Tabel Serial --}}
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover align-middle text-center ">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Serial</th>
                    <th>Produk</th>
                    <th>Paket Kelas</th>
                    <th>Aktif (bulan)</th>
                    <th>Kedaluwarsa</th>
                    <th>Sisa Hari</th>
                    <th>Pengguna</th>
                    <th>Pemberitahuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="serialBody">
                @forelse ($data as $i => $s)
                    <tr id="row{{ $s->id }}">
                        <td>{{ $i + 1 }}</td>
                        <td class="fw-bold serial-cell" style="cursor:pointer; font-size: 10px;"
                            title="Klik untuk menyalin">
                            {{ $s->serial }}
                        </td>
                        <td>
                            @if ($s->product)
                                {{ $s->product->name }}
                            @else
                                <span class="text-muted">Belum Ditentukan</span>
                            @endif
                        </td>
                        <td>{{ $s->paket }}</td>
                        <td>{{ $s->active }}</td>
                        <td>
                            @if ($s->expired_at)
                                {{ \Carbon\Carbon::parse($s->expired_at)->format('d/m/Y') }}
                            @else
                                <span class="text-muted">Belum Aktif</span>
                            @endif
                        </td>
                        <td>
                            @if ($s->expired_at)
                                @php
                                    $diff = \Carbon\Carbon::today()->diffInDays(
                                        \Carbon\Carbon::parse($s->expired_at),
                                        false,
                                    );
                                @endphp

                                @if ($diff > 0)
                                    <span class="badge bg-success">+{{ $diff }} </span>
                                @elseif ($diff == 0)
                                    <span class="badge bg-warning text-dark">0 </span>
                                @else
                                    <span class="badge bg-danger">{{ $diff }} </span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($s->user)
                                {{ $s->user->name }}
                            @else
                                <span class="text-muted">Belum Ditentukan</span>
                            @endif
                        </td>
                        <td>
                            @if ($s->notif == 'Tidak_ada')
                                <span class="badge bg-secondary">Tidak Ada</span>
                            @elseif ($s->notif == 'Peringatan')
                                <span class="badge bg-warning text-dark">Peringatan</span>
                            @elseif ($s->notif == 'Kedaluwarsa')
                                <span class="badge bg-danger">Kedaluwarsa</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                <!-- EDIT -->
                                <button class="btn btn-warning btn-sm" onclick="editSerial({{ $s->id }})">
                                    Edit
                                </button>

                                <!-- HAPUS -->
                                <button class="btn btn-danger btn-sm"
                                    onclick="hapusSerial({{ $s->id }}, '{{ $s->serial }}')">
                                    Hapus
                                </button>

                                <!-- PERPANJANG -->
                                @if ($s->expired_at)
                                    <button class="btn btn-info btn-sm" onclick="perpanjangSerial({{ $s->id }})">
                                        Perpanjang
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        Belum Aktif
                                    </button>
                                @endif

                                <!-- KIRIM EMAIL -->
                                <button class="btn btn-success btn-sm" onclick="openEmailModal({{ $s->id }})">
                                    Kirim Email
                                </button>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-muted text-center">Tidak ada data serial.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="8"></th>
                </tr>
            </tfoot>
        </table>
    </div>

    {{--   Modal Tambah Serial --}}
    <div class="modal fade p-5" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog custom-modal mt-5">
            <form id="formTambah" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Serial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-12">
                        <label class="form-label">Produk</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">== Pilih ==</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Paket Kelas</label>
                        <select name="paket" class="form-select" required>
                            <option value="">== Pilih Paket ==</option>
                            @for ($i = 1; $i <= 9; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Aktif (bulan)</label>
                        <select name="active" class="form-select" required>
                            <option value="">== Pilih ==</option>
                            @for ($i = 6; $i <= 120; $i += 6)
                                <option value="{{ $i }}">{{ $i }} bulan</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="input-group">
                            <input type="text" id="tambahUserName" class="form-control" placeholder="Belum dipilih"
                                readonly>
                            <input type="hidden" id="tambahUserId" name="user_id">
                            <button type="button" class="btn btn-primary btn-sm" onclick="openUserPopup('tambah')">
                                Pilih
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{--   Modal Edit Serial --}}
    <div class="modal fade p-5" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog custom-modal mt-5">
            <form id="formEdit" class="modal-content">
                @csrf
                @method('PUT')
                <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="hidden"
                    id="editId" name="id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Serial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-12">
                        <label class="form-label">Produk</label>
                        <select id="editProductId" name="product_id" class="form-select" required>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Paket Kelas</label>
                        <select id="editPaket" name="paket" class="form-select" required>
                            @for ($i = 1; $i <= 9; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="input-group">
                            <input type="text" id="editUserName" class="form-control" placeholder="Belum dipilih"
                                readonly>
                            <input type="hidden" id="editUserId" name="user_id">
                            <button type="button" class="btn btn-primary btn-sm" onclick="openUserPopup('edit')">
                                Pilih
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    {{--   Modal Perpanjang Serial --}}
    <div class="modal fade p-5" id="modalExtend" tabindex="-1" aria-labelledby="modalExtendLabel" aria-hidden="true">
        <div class="modal-dialog modal-md mt-5 custom-modal">
            <form id="formExtend" class="modal-content">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modalExtendLabel">
                        Perpanjang Masa Aktif Serial
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- ID -->
                    <input type="hidden" id="extendId" name="id">

                    <!-- EXPIRED RAW (UNTUK LOGIC JS) -->
                    <input type="hidden" id="extendExpiredRaw">

                    <!-- SERIAL -->
                    <div class="mb-3">
                        <label class="form-label">Serial</label>
                        <input type="text" id="extendSerial" class="form-control" readonly>
                    </div>

                    <!-- EXPIRED SAAT INI -->
                    <div class="mb-3">
                        <label class="form-label">Expired Saat Ini</label>
                        <input type="text" id="extendExpired" class="form-control" readonly>
                    </div>

                    <!-- TAMBAH BULAN -->
                    <div class="mb-3">
                        <label class="form-label">Tambah (bulan)</label>
                        <select id="extendMonths" name="extend_months" class="form-select" required>
                            <option value="">== Pilih ==</option>
                            @for ($i = 6; $i <= 120; $i += 6)
                                <option value="{{ $i }}">{{ $i }} bulan</option>
                            @endfor
                        </select>
                        <small class="text-muted">
                            Jika serial masih aktif, perpanjangan dihitung dari tanggal expired terakhir agar sisa masa
                            aktif tidak hilang.
                            Jika serial sudah expired, perpanjangan dihitung dari tanggal hari ini sebagai aktivasi ulang
                            layanan.
                            <br><br>
                            Cara perhitungan:
                            <br>
                            • Jika belum expired → expired baru = expired lama + jumlah bulan
                            <br>
                            • Jika sudah expired → expired baru = tanggal hari ini + jumlah bulan
                        </small>
                    </div>

                    <!-- PREVIEW -->
                    <div class="mb-3">
                        <label class="form-label">Perkiraan Tanggal Baru</label>
                        <input type="text" id="extendNewExpired" class="form-control" readonly>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        Simpan Perpanjangan
                    </button>
                </div>

            </form>
        </div>
    </div>
    <div class="modal fade p-5" id="emailModal" tabindex="-1">
        <div class="modal-dialog modal-md mt-5 custom-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kirim Serial ke Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="email_serial_id">

                    <label>Email Pelanggan</label>
                    <input type="email" id="email_to" class="form-control">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" onclick="kirimEmail()">Kirim</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Pilih User -->
    <div class="modal fade p-5" id="modalPilihUser" tabindex="-1">
        <div class="modal-dialog modal-md mt-5 custom-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="text"
                        id="searchUserInput" class="form-control mb-3" placeholder="Cari nama user...">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover align-middle text-center"
                            id="studentTable">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody id="userTablePopup">
                                @forelse ($users->where('role', 1) as $u)
                                    <tr class="user-item" data-id="{{ $u->id }}" data-name="{{ $u->name }}"
                                        data-username="{{ $u->username }}" data-email="{{ $u->email }}"
                                        style="cursor:pointer;">

                                        <td>{{ $u->name ?? '-' }}</td>
                                        <td>{{ $u->username ?? '-' }}</td>
                                        <td>{{ $u->email ?? '-' }}</td>

                                        <td>
                                            <button class="btn btn-primary btn-sm"
                                                onclick="pilihUser('{{ $u->id }}', '{{ $u->name }}')">
                                                Pilih
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-muted text-center">
                                            Belum ada data pengguna / guru.
                                        </td>
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
        </div>
    </div>
    <div class="modal fade p-5" id="modalExpiredDelete" tabindex="-1">
        <div class="modal-dialog custom-modal mt-5">
            <div class="modal-content">

                <div class="modal-header bg-danger text-dark">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Hapus Serial Expired > 14 Bulan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-2">
                        <input type="checkbox" id="checkAllExpired">
                        <label for="checkAllExpired" class="fw-semibold">
                            Pilih Semua
                        </label>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>Serial</th>
                                    <th>Kedaluwarsa</th>
                                    <th>Pengguna</th>
                                    <th>Pemberitahuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expiredSerials as $s)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="expired-check" value="{{ $s->id }}">
                                        </td>
                                        <td class="fw-bold" style="font-size:11px">
                                            {{ $s->serial }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($s->expired_at)->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            {{ $s->user->name ?? '-' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark">
                                                {{ $s->notif }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button class="btn btn-danger" onclick="hapusExpiredMassal()">
                        <i class="fas fa-trash me-2"></i>Hapus Terpilih
                    </button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade p-5" id="modalExpiringSoon" tabindex="-1">
        <div class="modal-dialog mt-5 custom-modal modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">
                        <i class="fas fa-bell me-2"></i>
                        Daftar Serial dengan Masa Aktif Mendekati / Telah Berakhir
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-2">
                        <input type="checkbox" id="checkAllWarning">
                        <label class="fw-semibold">Pilih Semua (yang punya email)</label>
                    </div>

                    {{-- TABLE (SCROLL KE BAWAH SAJA) --}}
                    <div style="max-height:260px; overflow-y:auto; overflow-x:hidden;">
                        <table class="table table-bordered align-middle text-center w-100" style="table-layout:fixed;">
                            <thead class="table-light" style="position: sticky; top: 0; z-index: 2;">
                                <tr>
                                    <th style="width: 60px; white-space: nowrap;">Pilih</th>
                                    <th style="width: 120px; white-space: nowrap;">Serial</th>
                                    <th style="width: 140px; white-space: nowrap;">Kedaluwarsa</th>
                                    <th style="width: 160px; white-space: nowrap;">Pemberitahuan</th>
                                    <th style="white-space: nowrap;">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notificationSerials as $s)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="warning-check" value="{{ $s->id }}"
                                                {{ $s->user && $s->user->email ? '' : 'disabled' }}>
                                        </td>
                                        <td class="fw-bold" style="font-size:10px; word-break:break-word;">
                                            {{ $s->serial }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($s->expired_at)->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            @if ($s->notif == 'Tidak_ada')
                                                <span class="badge bg-secondary">Tidak Ada</span>
                                            @elseif ($s->notif == 'Peringatan')
                                                <span class="badge bg-warning text-dark">Peringatan</span>
                                            @elseif ($s->notif == 'Kedaluwarsa')
                                                <span class="badge bg-danger">Kedaluwarsa</span>
                                            @endif
                                        </td>
                                        <td style="word-break:break-word;">
                                            @if ($s->user && $s->user->email)
                                                {{ $s->user->email }}
                                            @else
                                                <span class="text-muted">Email Tidak Ada</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                {{-- TOMBOL --}}
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button id="btnEmailWarningBulk" class="btn btn-warning" onclick="kirimEmailWarningBulk()">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Email Terpilih
                    </button>
                </div>

                {{-- PANDUAN DI PALING BAWAH --}}
                <div class="px-3 pb-3">
                    <div class="alert alert-light border small mt-2">
                        <b>Ketentuan Pengiriman Email:</b><br><br>

                        <b>Notifikasi Peringatan</b><br>
                        Email akan dikirim jika:
                        <br>• Kedaluwarsa kurang dari 1 bulan dari hari ini
                        <br>• Pemberitahuan belum berstatus "Peringatan"
                        <br>• Pengguna memiliki email
                        <br><br>

                        <b>Notifikasi Kedaluwarsa</b><br>
                        Email akan dikirim jika:
                        <br>• Tanggal sekarang sudah mencapai atau melewati tanggal Kedaluwarsa
                        <br>• Pemberitahuan belum berstatus "Kedaluwarsa"
                        <br>• Pengguna memiliki email
                        <br><br>

                        <b>Catatan:</b>
                        <br>• Email hanya dikirim satu kali untuk setiap status
                        <br>• Berlaku untuk status Peringatan dan Kedaluwarsa
                        <br><br>

                        <b>Cara Pengiriman Email:</b>
                        <br>• Otomatis setiap hari pukul 08.00
                        <br>• Saat admin login dengan jeda 6 jam
                        <br>• Manual melalui tombol Kirim Email
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Pilihan Riwayat -->
    <div class="modal fade" id="modalRiwayat" tabindex="-1">
        <div class="modal-dialog mt-5 custom-modal modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-history me-2"></i>Pilih Riwayat
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">

                    <div class="d-grid gap-3">

                        <a href="{{ route('admin.serial.riwayat.serial') }}" class="btn btn-primary">
                            <i class="fas fa-key me-2"></i>Riwayat Serial
                        </a>

                        <a href="{{ route('admin.serial.riwayat.email') }}" class="btn btn-success">
                            <i class="fas fa-envelope me-2"></i>Riwayat Email
                        </a>

                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection

@section('js')

    <script>
        document.getElementById('checkAllWarning')?.addEventListener('change', function() {
            document.querySelectorAll('.warning-check:not(:disabled)').forEach(cb => {
                cb.checked = this.checked;
            });
        });
        async function kirimEmailWarningBulk() {
            const ids = Array.from(
                document.querySelectorAll('.warning-check:checked')
            ).map(cb => cb.value);

            if (ids.length === 0) {
                return notifError('Pilih minimal satu serial.');
            }

            const btn = document.getElementById('btnEmailWarningBulk');
            const originalHtml = btn.innerHTML;

            // 🔄 AKTIFKAN SPINNER
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';

            try {
                const res = await fetch("{{ route('admin.serial.expiring.email') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        ids
                    })
                });

                const result = await res.json();

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Proses Selesai',
                        html: `
            <div style="text-align:center;">
                <b>Total diproses:</b> ${result.total}<br>
                <b>Berhasil dikirim:</b> ${result.sent}<br>
                <b>Dilewatkan:</b> ${result.skipped}
            </div>
        `,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    notifError(result.message);
                }

            } catch {
                notifError('Terjadi kesalahan server.');
            }

            // 🔁 KEMBALIKAN TOMBOL
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        }

        const notifSuccess = (msg) => Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: msg,
            timer: 1800,
            showConfirmButton: false
        });
        const notifError = (msg) => Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: msg,
            confirmButtonText: 'Tutup'
        });

        document.addEventListener("DOMContentLoaded", () => {

            /* SEARCH TABLE */
            const searchInput = document.getElementById("searchInput");
            if (searchInput) {
                searchInput.addEventListener("keyup", function() {
                    const keyword = this.value.toLowerCase();
                    document.querySelectorAll("#serialBody tr").forEach(row => {
                        const text = row.innerText?.toLowerCase() || "";
                        row.style.display = text.includes(keyword) ? "" : "none";
                    });
                });
            }

            /* COPY SERIAL */
            document.getElementById('serialBody')?.addEventListener('click', (e) => {
                const target = e.target.closest('.serial-cell');
                if (!target) return;

                const serial = target.innerText.trim();
                navigator.clipboard.writeText(serial).then(() => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Serial disalin!',
                        text: serial,
                        timer: 1200,
                        showConfirmButton: false
                    });
                }).catch(() => notifError('Gagal menyalin serial.'));
            });

        });

        function openEmailModal(id) {
            document.getElementById('email_serial_id').value = id;
            document.getElementById('email_to').value = '';
            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('emailModal')
            ).show();
        }


        async function kirimEmail() {
            const id = document.getElementById('email_serial_id').value;
            const email = document.getElementById('email_to').value;

            if (!email) return notifError('Email wajib diisi.');

            const btn = document.querySelector("#emailModal .btn-primary");
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';

            try {
                const res = await fetch("{{ route('admin.serial.email.info') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        serial_id: id,
                        email
                    })
                });

                const data = await res.json();

                if (data.success) {
                    notifSuccess(data.message);
                    bootstrap.Modal.getInstance(
                        document.getElementById('emailModal')
                    ).hide();
                } else {
                    notifError(data.message);
                }

            } catch {
                notifError('Terjadi kesalahan server.');
            }

            btn.disabled = false;
            btn.innerHTML = 'Kirim';
        }


        document.getElementById('checkAllExpired')?.addEventListener('change', function() {
            document.querySelectorAll('.expired-check').forEach(cb => {
                cb.checked = this.checked;
            });
        });


        function hapusExpiredMassal() {
            const ids = Array.from(
                document.querySelectorAll('.expired-check:checked')
            ).map(cb => cb.value);

            if (ids.length === 0) {
                return notifError('Pilih minimal satu serial.');
            }

            Swal.fire({
                title: 'Hapus Serial?',
                text: `Akan menghapus ${ids.length} serial secara permanen`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                confirmButtonColor: '#dc3545'
            }).then(async (res) => {
                if (!res.isConfirmed) return;

                try {
                    const response = await fetch(
                        "{{ route('admin.serial.expired.bulk_delete') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                ids
                            })
                        }
                    );

                    const result = await response.json();

                    if (result.success) {
                        notifSuccess(result.message);
                        setTimeout(() => location.reload(), 800);
                    } else {
                        notifError(result.message);
                    }

                } catch {
                    notifError('Terjadi kesalahan server.');
                }
            });
        }

        function openUserPopup(target) {
            targetForm = target;
            document.getElementById("searchUserInput").value = "";
            filterUserList("");
            bootstrap.Modal.getOrCreateInstance(document.getElementById("modalPilihUser")).show();
        }

        // === FILTER LIST USER REALTIME ===
        document.getElementById("searchUserInput").addEventListener("keyup", function() {
            filterUserList(this.value.toLowerCase());
        });

        function filterUserList(keyword) {
            document.querySelectorAll("#userTablePopup .user-item").forEach(item => {
                const name = item.dataset.name.toLowerCase();
                const username = item.dataset.username.toLowerCase();
                const email = item.dataset.email.toLowerCase();

                item.style.display =
                    name.includes(keyword) ||
                    username.includes(keyword) ||
                    email.includes(keyword) ?
                    "" :
                    "none";
            });
        }


        // === PILIH USER ===
        function pilihUser(id, name) {
            if (targetForm === "tambah") {
                document.getElementById("tambahUserId").value = id;
                document.getElementById("tambahUserName").value = name;
            } else if (targetForm === "edit") {
                document.getElementById("editUserId").value = id;
                document.getElementById("editUserName").value = name;
            }

            bootstrap.Modal.getInstance(document.getElementById("modalPilihUser")).hide();
            targetForm = "";
        }

        //   Tambah Serial
        document.getElementById("formTambah").addEventListener("submit", async function(e) {
            e.preventDefault();
            const btn = this.querySelector("button[type='submit']");
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            try {
                const res = await fetch("{{ route('admin.serial.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: new FormData(this)
                });
                const result = await res.json();
                if (result.success) {
                    notifSuccess(result.message);
                    setTimeout(() => location.reload(), 800);
                } else notifError(result.message);
            } catch (err) {
                notifError(err.message);
            }
            btn.disabled = false;
            btn.innerHTML = 'Simpan';
        });

        //   Edit Serial
        async function editSerial(id) {
            const res = await fetch(`/admin/serial/${id}/edit`);
            const result = await res.json();
            if (result.success) {
                const s = result.data;
                document.getElementById("editId").value = s.id;
                document.getElementById("editProductId").value = s.product_id;
                document.getElementById("editPaket").value = s.paket;
                document.getElementById("editUserId").value = s.user_id ?? "";
                document.getElementById("editUserName").value = s.user ? s.user.name : "Belum dipilih";
                new bootstrap.Modal(document.getElementById("modalEdit")).show();
            } else notifError(result.message);
        }

        document.getElementById("formEdit").addEventListener("submit", async function(e) {
            e.preventDefault();
            const id = document.getElementById("editId").value;
            const btn = this.querySelector("button[type='submit']");
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            try {
                const res = await fetch(`/admin/serial/${id}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "X-HTTP-Method-Override": "PUT"
                    },
                    body: new FormData(this)
                });
                const result = await res.json();
                if (result.success) {
                    notifSuccess(result.message);
                    setTimeout(() => location.reload(), 800);
                } else notifError(result.message);
            } catch (err) {
                notifError(err.message);
            }
            btn.disabled = false;
            btn.innerHTML = 'Simpan Perubahan';
        });

        //   Hapus Serial
        function hapusSerial(id, serial) {
            Swal.fire({
                title: 'Hapus Serial?',
                text: `Yakin ingin menghapus "${serial}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#B05B3B',
                cancelButtonColor: '#D79771',
                reverseButtons: true
            }).then(async result => {
                if (result.isConfirmed) {
                    const res = await fetch(`/admin/serial/${id}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    });
                    const out = await res.json();
                    if (out.success) {
                        notifSuccess(out.message);
                        document.getElementById(`row${id}`).remove();
                    } else notifError(out.message);
                }
            });
        }

        //   Klik untuk salin serial
        document.querySelectorAll('.serial-cell').forEach(cell => {
            cell.addEventListener('click', () => {
                const serial = cell.innerText.trim();
                navigator.clipboard.writeText(serial);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Serial disalin!',
                    text: serial,
                    timer: 1200,
                    showConfirmButton: false
                });
            });
        });

        //   Perpanjang Serial
        function perpanjangSerial(id) {
            fetch(`/admin/serial/${id}/edit`)
                .then(res => res.json())
                .then(result => {
                    if (result.success) {
                        const s = result.data;
                        document.getElementById("extendId").value = s.id;
                        document.getElementById("extendSerial").value = s.serial;
                        document.getElementById("extendExpiredRaw").value = s.expired_at ?? "";

                        document.getElementById("extendExpired").value = s.expired_at ?
                            new Date(s.expired_at).toLocaleDateString('id-ID') :
                            '-';
                        document.getElementById("extendMonths").value = "";
                        document.getElementById("extendNewExpired").value = "";
                        new bootstrap.Modal(document.getElementById("modalExtend")).show();
                    } else notifError(result.message);
                })
                .catch(err => notifError(err.message));
        }

        //   Update perkiraan tanggal baru saat user pilih bulan
        document.getElementById("extendMonths").addEventListener("change", function() {

            const raw = document.getElementById("extendExpiredRaw").value;
            const months = parseInt(this.value);
            if (!months) return;

            let baseDate = new Date();

            if (raw) {
                const expiredDate = new Date(raw);
                const today = new Date();

                // RULE FINAL
                if (expiredDate > today) {
                    baseDate = expiredDate;
                } else {
                    baseDate = today;
                }
            }

            baseDate.setMonth(baseDate.getMonth() + months);

            document.getElementById("extendNewExpired").value =
                baseDate.toLocaleDateString('id-ID');

        });
        //   Submit perpanjangan
        document.getElementById("formExtend").addEventListener("submit", async function(e) {
            e.preventDefault();
            const id = document.getElementById("extendId").value;
            const btn = this.querySelector("button[type='submit']");
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            try {
                const res = await fetch(`/admin/serial/${id}/extend`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        extend_months: document.getElementById("extendMonths").value
                    })
                });
                const result = await res.json();
                if (result.success) {
                    notifSuccess(result.message);
                    setTimeout(() => location.reload(), 800);
                } else notifError(result.message);
            } catch (err) {
                notifError(err.message);
            }
            btn.disabled = false;
            btn.innerHTML = 'Simpan Perpanjangan';
        });
    </script>
@endsection
