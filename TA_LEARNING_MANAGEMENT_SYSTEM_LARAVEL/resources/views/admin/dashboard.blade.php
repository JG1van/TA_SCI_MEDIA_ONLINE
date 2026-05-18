@extends('admin.layouts.app')

@section('title', 'Dashboard LMS')
@section('page_title', 'Dashboard Learning Management System')

@push('head')
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
@endpush

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- ===================== DASHBOARD LMS ===================== --}}
        <div id="dashboardLMS">

            {{-- HERO + QUICK STATS --}}
            <div class="row g-4 mb-4">

                {{-- Hero --}}
                <div class="col-lg-7 anim-up anim-d1">
                    <div class="hero-card h-100" id="switchDashboard">
                        <div class="d-flex align-items-center justify-content-between h-100">
                            <div class="flex-grow-1 pe-3" style="position:relative;z-index:1;">
                                <div class="hero-label">Learning Management System</div>
                                <h3 style="color: white">
                                    Halo, {{ Auth::user()->username ?? 'Admin' }} 👋
                                </h3>
                                <p><span id="clock" data-time="{{ now()->format('Y-m-d H:i:s') }}"></span></p>
                                <div class="switch-hint">
                                    <i class="bi bi-arrow-right-circle"></i>
                                    Klik untuk membuka Dashboard Layanan Pelanggan
                                </div>
                            </div>
                            <div class="d-none d-md-block">
                                <img src="{{ asset('images/ilustrasi-selamat-datang-2.png') }}" class="hero-img">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Stats 2x2 --}}
                <div class="col-lg-5">
                    <div class="row g-3 h-100">

                        <div class="col-6 anim-up anim-d2">
                            <div class="stat-card h-100">
                                <div class="stat-icon bg-blue-soft">
                                    <i class="bi bi-journal-text"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Materi</div>
                                    <div class="stat-value">{{ $totalMateri }}</div>
                                    <div class="stat-sub">Pelajaran aktif</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 anim-up anim-d3">
                            <div class="stat-card h-100">
                                <div class="stat-icon bg-green-soft">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Siswa</div>
                                    <div class="stat-value">{{ $totalSiswa }}</div>
                                    <div class="stat-sub">Terdaftar</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 anim-up anim-d4">
                            <div class="stat-card h-100">
                                <div class="stat-icon bg-teal-soft">
                                    <i class="bi bi-person-video3"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Guru</div>
                                    <div class="stat-value">{{ $totalGuru }}</div>
                                    <div class="stat-sub">Pengajar</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 anim-up anim-d5">
                            <div class="stat-card h-100">
                                <div class="stat-icon bg-orange-soft">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Kelas</div>
                                    <div class="stat-value">{{ $totalKelas }}</div>
                                    <div class="stat-sub">Kelas aktif</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ADDITIONAL STATS --}}
            <div class="section-header anim-up anim-d1">Detail Konten</div>
            <div class="row g-3 mb-4">

                <div class="col-md-4 anim-up anim-d2">
                    <div class="stat-card">
                        <div class="stat-icon bg-purple-soft">
                            <i class="bi bi-play-circle"></i>
                        </div>
                        <div>
                            <div class="stat-label">Produk Pembelajaran</div>
                            <div class="stat-value">{{ $totalProduk }}</div>
                            <div class="stat-sub">Modul tersedia</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 anim-up anim-d3">
                    <div class="stat-card">
                        <div class="stat-icon bg-blue-soft">
                            <i class="bi bi-book"></i>
                        </div>
                        <div>
                            <div class="stat-label">Mata Pelajaran</div>
                            <div class="stat-value">{{ $totalMapel }}</div>
                            <div class="stat-sub">Mapel terdaftar</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 anim-up anim-d4">
                    <div class="stat-card">
                        <div class="stat-icon bg-green-soft">
                            <i class="bi bi-key"></i>
                        </div>
                        <div>
                            <div class="stat-label">Kode Serial</div>
                            <div class="stat-value">{{ $totalSerial }}</div>
                            <div class="stat-sub">Serial aktif</div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- CHARTS --}}
            <div class="section-header anim-up anim-d1">Visualisasi Data</div>
            <div class="row g-4 anim-up anim-d2">

                <div class="col-md-6">
                    <div class="chart-card h-100">
                        <div class="chart-head">
                            <div class="icon-dot"></div>
                            <span class="title">Distribusi Materi per Mapel</span>
                        </div>
                        <div class="chart-body" style="height:280px;">
                            <canvas id="materiChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="chart-card h-100">
                        <div class="chart-head">
                            <div class="icon-dot" style="background: linear-gradient(135deg, #06d6a0, #118ab2);"></div>
                            <span class="title">Jumlah Siswa per Kelas</span>
                        </div>
                        <div class="chart-body" style="height:280px;">
                            <canvas id="kelasChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        {{-- ===================== DASHBOARD SUPPORT ===================== --}}
        <div id="dashboardSupport" style="display:none;">

            {{-- SUPPORT HERO BACK --}}
            <div class="support-hero mb-4" id="switchBack">
                <div class="d-flex align-items-center justify-content-between">
                    <div style="position:relative;z-index:1;">
                        <div class="badge-tag">
                            <i class="bi bi-headset"></i>
                            Layanan Pelanggan
                        </div>
                        <h3 style="color: white">Dashboard CS</h3>
                        <p class="mb-0" style="opacity:.75;font-size:.9rem;" style="color: white">
                            Halo, <strong>{{ Auth::user()->username ?? 'Admin' }}</strong>
                        </p>
                        <div class="hint">
                            <i class="bi bi-arrow-left-circle me-1"></i>
                            Klik untuk kembali ke Dashboard LMS
                        </div>
                    </div>
                    <div class="d-none d-md-flex align-items-center gap-3" style="position:relative;z-index:1;">
                        <div class="text-end">
                            <div style="font-size:11px;opacity:.55;text-transform:uppercase;letter-spacing:1px;">Percakapan
                            </div>
                            <div style="font-size:2.5rem;font-weight:800;line-height:1;">{{ $totalRooms }}</div>
                            <div style="font-size:11px;opacity:.55;">Total</div>
                        </div>
                        <div style="width:1px;height:60px;background:rgba(255,255,255,.15);"></div>
                        <div class="text-end">
                            <div style="font-size:11px;opacity:.55;text-transform:uppercase;letter-spacing:1px;">Bulan Ini
                            </div>
                            <div style="font-size:2.5rem;font-weight:800;line-height:1;">{{ $totalRoomsThisMonth }}</div>
                            <div style="font-size:11px;opacity:.55;">Percakapan</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SUPPORT QUICK STATS --}}
            <div class="section-header" style="--lms-primary:#0f3460;--lms-accent:#e94560;">Statistik Dukungan</div>
            <div class="row g-4 mb-4">

                <div class="col-md-3">
                    <div class="sup-stat">
                        <div class="sup-icon" style="background:rgba(15,52,96,.1);color:#0f3460;">
                            <i class="bi bi-chat-dots fs-5"></i>
                        </div>
                        <div class="sup-label">Total Percakapan</div>
                        <div class="sup-value">{{ $totalRooms }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="sup-stat">
                        <div class="sup-icon" style="background:rgba(0,180,216,.1);color:#00b4d8;">
                            <i class="bi bi-calendar-event fs-5"></i>
                        </div>
                        <div class="sup-label">Percakapan Bulan Ini</div>
                        <div class="sup-value">{{ $totalRoomsThisMonth }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="sup-stat">
                        <div class="sup-icon" style="background:rgba(255,209,102,.15);color:#e8900a;">
                            <i class="bi bi-tags fs-5"></i>
                        </div>
                        <div class="sup-label">Pertanyaan Aktif</div>
                        <div class="sup-value">{{ $totalActiveCategories }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="sup-stat">
                        <div class="sup-icon" style="background:rgba(233,69,96,.1);color:#e94560;">
                            <i class="bi bi-question-circle fs-5"></i>
                        </div>
                        <div class="sup-label">Belum Terjawab</div>
                        <div class="sup-value" style="color:#e94560;">{{ $totalUnanswered }}</div>
                    </div>
                </div>

            </div>

            {{-- SUPPORT CHARTS ROW 1 --}}
            <div class="section-header">Analisis Percakapan</div>
            <div class="row g-4 mb-4">

                <div class="col-md-6">
                    <div class="chart-card h-100">
                        <div class="chart-head">
                            <div class="icon-dot" style="background:linear-gradient(135deg,#e94560,#f72585);"></div>
                            <span class="title">5 Pertanyaan Paling Sering Tidak Terjawab</span>
                        </div>
                        <div class="chart-body" style="height:280px;">
                            <canvas id="topUnansweredChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="chart-card h-100">
                        <div class="chart-head">
                            <div class="icon-dot" style="background:linear-gradient(135deg,#0f3460,#00b4d8);"></div>
                            <span class="title">5 Kategori Percakapan Terpopuler</span>
                        </div>
                        <div class="chart-body" style="height:280px;">
                            <canvas id="topCategoryChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            {{-- SUPPORT CHARTS ROW 2 --}}
            <div class="row g-4 mb-4">

                <div class="col-md-4">
                    <div class="chart-card h-100">
                        <div class="chart-head">
                            <div class="icon-dot" style="background:linear-gradient(135deg,#7209b7,#e94560);"></div>
                            <span class="title">Distribusi Penyelesaian</span>
                        </div>
                        <div class="chart-body" style="height:280px;">
                            <canvas id="resolutionChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="chart-card h-100">
                        <div class="chart-head">
                            <div class="icon-dot" style="background:linear-gradient(135deg,#0f3460,#00b4d8);"></div>
                            <span class="title">Tren Percakapan — 12 Bulan Terakhir</span>
                        </div>
                        <div class="chart-body" style="height:280px;">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            {{-- WORD ANALYSIS --}}
            <div class="section-header">Analisis Kata Pelanggan</div>

            <div class="row g-4 mb-4">

                <div class="col-md-8">
                    <div class="chart-card h-100">
                        <div class="chart-head">
                            <div class="icon-dot" style="background:linear-gradient(135deg,#4361ee,#f72585);"></div>
                            <span class="title">Word Cloud — Kata Pelanggan</span>
                        </div>

                        <div class="chart-body">
                            <div class="wc-wrapper">

                                @php
                                    $totalWords = count($topPelaporWords);
                                @endphp

                                @if ($totalWords > 0)

                                    @php
                                        $maxCount = max($topPelaporWords);
                                        $globalScale = max(0.9, 1.2 - $totalWords / 60);
                                        $repeat = $totalWords < 15 ? ceil(30 / $totalWords) : 1;

                                        $step = max(1, intval(340 / $totalWords));
                                        $hues = range(0, 340, $step);

                                        shuffle($hues);

                                        $hi = 0;
                                    @endphp

                                    @for ($i = 0; $i < $repeat; $i++)
                                        @foreach ($topPelaporWords as $word => $count)
                                            @php
                                                $normalized = $count / $maxCount;
                                                $size = (14 + $normalized * 38) * $globalScale;
                                                $rotate = rand(-12, 12);

                                                $hue = $hues[$hi % count($hues)];
                                                $hi++;
                                            @endphp

                                            <span
                                                style="
                                        font-size:{{ round($size, 1) }}px;
                                        transform: rotate({{ $rotate }}deg);
                                        color: hsl({{ $hue }}, 65%, 38%);
                                        font-weight: {{ $normalized > 0.6 ? 800 : ($normalized > 0.3 ? 600 : 400) }};
                                        white-space: nowrap;
                                    ">
                                                {{ $word }}
                                            </span>
                                        @endforeach
                                    @endfor
                                @else
                                    <div class="text-center text-muted py-5">
                                        Tidak ada data kata pelanggan.
                                    </div>

                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="chart-card h-100">

                        <div class="chart-head">
                            <div class="icon-dot"></div>
                            <span class="title">Top Kata</span>
                        </div>

                        <div class="chart-body" style="max-height:370px;overflow-y:auto;">

                            @forelse ($topPelaporWords as $word => $count)
                                <div class="word-list-item">
                                    <span class="wl-word">{{ $word }}</span>
                                    <span class="wl-badge">{{ $count }}</span>
                                </div>

                            @empty

                                <div class="text-center text-muted py-4">
                                    Tidak ada data.
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            /* =======================================================
               SMART COLOR GENERATOR — no clash, evenly distributed
            ======================================================= */
            function generatePalette(count) {
                const palette = [];
                const saturation = 68;
                const lightness = 55;
                for (let i = 0; i < count; i++) {
                    // distribute hues evenly + slight jitter
                    const hue = (i * (360 / count) + Math.random() * 18) % 360;
                    palette.push(`hsl(${Math.round(hue)}, ${saturation}%, ${lightness}%)`);
                }
                // shuffle
                for (let i = palette.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [palette[i], palette[j]] = [palette[j], palette[i]];
                }
                return palette;
            }

            // Shared Chart.js defaults
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            Chart.defaults.font.size = 12;
            Chart.defaults.color = '#6b7280';

            /* =======================================================
               SWITCH DASHBOARD
            ======================================================= */
            const lms = document.getElementById("dashboardLMS");
            const support = document.getElementById("dashboardSupport");
            let supportLoaded = false;

            document.getElementById("switchDashboard").addEventListener("click", function() {
                lms.style.display = "none";
                support.style.display = "block";
                setTimeout(() => {
                    if (!supportLoaded) {
                        initSupportCharts();
                        supportLoaded = true;
                    }
                }, 150);
            });

            document.getElementById("switchBack").addEventListener("click", function() {
                lms.style.display = "block";
                support.style.display = "none";
            });

            /* =======================================================
               LMS CHARTS
            ======================================================= */
            const materiLabels = {!! json_encode($materiPerMapel->pluck('mapel')) !!};
            const materiData = {!! json_encode($materiPerMapel->pluck('total')) !!};
            const kelasLabels = {!! json_encode($siswaPerKelas->pluck('kelas')) !!};
            const kelasData = {!! json_encode($siswaPerKelas->pluck('total')) !!};

            const doughnutOptions = {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            borderRadius: 6,
                            padding: 14,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    }
                }
            };

            if (materiData.length > 0) {
                const mc = generatePalette(materiData.length);
                new Chart(document.getElementById("materiChart"), {
                    type: "doughnut",
                    data: {
                        labels: materiLabels,
                        datasets: [{
                            data: materiData,
                            backgroundColor: mc,
                            borderWidth: 0,
                            hoverOffset: 8
                        }]
                    },
                    options: doughnutOptions
                });
            }

            if (kelasData.length > 0) {
                const kc = generatePalette(kelasData.length);
                new Chart(document.getElementById("kelasChart"), {
                    type: "doughnut",
                    data: {
                        labels: kelasLabels,
                        datasets: [{
                            data: kelasData,
                            backgroundColor: kc,
                            borderWidth: 0,
                            hoverOffset: 8
                        }]
                    },
                    options: doughnutOptions
                });
            }

            /* =======================================================
               SUPPORT CHARTS (lazy init)
            ======================================================= */
            function initSupportCharts() {

                /* --- Trend 1 Tahun --- */
                const trendLabelsRaw = {!! json_encode($trendChart->pluck('month') ?? []) !!};
                const trendData = {!! json_encode($trendChart->pluck('total') ?? []) !!};

                if (trendLabelsRaw.length > 0) {
                    const trendLabels = trendLabelsRaw.map(item => {
                        if (!String(item).includes("-")) return item;
                        const [y, m] = item.split("-");
                        return new Date(y, m - 1).toLocaleDateString("id-ID", {
                            month: "short",
                            year: "numeric"
                        });
                    });

                    new Chart(document.getElementById("trendChart"), {
                        type: "line",
                        data: {
                            labels: trendLabels,
                            datasets: [{
                                label: "Percakapan",
                                data: trendData,
                                borderColor: "#0f3460",
                                backgroundColor: "rgba(15,52,96,0.08)",
                                fill: true,
                                tension: 0.45,
                                pointBackgroundColor: "#0f3460",
                                pointRadius: 4,
                                pointHoverRadius: 7,
                                borderWidth: 2.5
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    border: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,.05)'
                                    },
                                    border: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                /* --- Resolution Doughnut --- */
                const resLabels = {!! json_encode($resolutionChart->pluck('resolution_by')) !!};
                const resData = {!! json_encode($resolutionChart->pluck('total')) !!};

                if (resData.length > 0) {
                    new Chart(document.getElementById("resolutionChart"), {
                        type: "doughnut",
                        data: {
                            labels: resLabels,
                            datasets: [{
                                data: resData,
                                backgroundColor: generatePalette(resData.length),
                                borderWidth: 0,
                                hoverOffset: 8
                            }]
                        },
                        options: {
                            ...doughnutOptions,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 12,
                                        borderRadius: 6,
                                        padding: 14
                                    }
                                }
                            }
                        }
                    });
                }

                /* --- Top 5 Kategori --- */
                const topCatLabels = {!! json_encode($topCategories->pluck('name')) !!};
                const topCatData = {!! json_encode($topCategories->pluck('total')) !!};

                if (topCatData.length > 0) {
                    const cc = generatePalette(topCatData.length);
                    new Chart(document.getElementById("topCategoryChart"), {
                        type: "bar",
                        data: {
                            labels: topCatLabels,
                            datasets: [{
                                data: topCatData,
                                backgroundColor: cc,
                                borderRadius: 10,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    border: {
                                        display: false
                                    },
                                    ticks: {
                                        maxRotation: 25,
                                        font: {
                                            size: 11
                                        }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,.05)'
                                    },
                                    border: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                /* --- Top 5 Unanswered --- */
                const topUnLabels = {!! json_encode($topUnanswered->pluck('keyword')) !!};
                const topUnData = {!! json_encode($topUnanswered->pluck('count')) !!};

                if (topUnData.length > 0) {
                    const uc = generatePalette(topUnData.length);
                    new Chart(document.getElementById("topUnansweredChart"), {
                        type: "bar",
                        data: {
                            labels: topUnLabels,
                            datasets: [{
                                label: "Jumlah",
                                data: topUnData,
                                backgroundColor: uc,
                                borderRadius: 10,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    border: {
                                        display: false
                                    },
                                    ticks: {
                                        maxRotation: 25,
                                        font: {
                                            size: 11
                                        }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,.05)'
                                    },
                                    border: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }
            }

        });
    </script>

    <script>
        const clockElement = document.getElementById('clock');
        let serverTime = new Date(clockElement.dataset.time);

        function updateClock() {
            serverTime.setSeconds(serverTime.getSeconds() + 1);

            let day = serverTime.getDate().toString().padStart(2, '0');
            let month = serverTime.toLocaleString('id-ID', {
                month: 'long'
            });
            let year = serverTime.getFullYear();

            let hours = serverTime.getHours().toString().padStart(2, '0');
            let minutes = serverTime.getMinutes().toString().padStart(2, '0');
            let seconds = serverTime.getSeconds().toString().padStart(2, '0');

            clockElement.innerHTML = `${day} ${month} ${year} — ${hours}:${minutes}:${seconds}`;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endsection
