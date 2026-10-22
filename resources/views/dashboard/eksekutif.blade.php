<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#070b14">
    <title>Dashboard Eksekutif | Command Center Kota Magelang</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --bg-base: #070b14;
            --bg-card: rgba(15, 23, 42, 0.75);
            --bg-card-hover: rgba(30, 41, 59, 0.85);
            --border-card: rgba(255, 255, 255, 0.08);
            --border-glow: rgba(56, 189, 248, 0.3);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-dim: #64748b;
            --accent-cyan: #06b6d4;
            --accent-blue: #3b82f6;
            --accent-emerald: #10b981;
            --accent-amber: #f59e0b;
            --accent-rose: #f43f5e;
            --chart-grid: rgba(255, 255, 255, 0.06);
            --chart-text: #94a3b8;
        }

        body.light-mode {
            --bg-base: #f1f5f9;
            --bg-card: rgba(255, 255, 255, 0.92);
            --bg-card-hover: #ffffff;
            --border-card: rgba(226, 232, 240, 0.9);
            --border-glow: rgba(37, 99, 235, 0.3);
            --text-main: #0f172a;
            --text-muted: #475569;
            --text-dim: #94a3b8;
            --chart-grid: rgba(0, 0, 0, 0.06);
            --chart-text: #64748b;
        }

        body.light-mode .text-white { color: var(--text-main) !important; }
        body.light-mode .text-slate-300 { color: #334155 !important; }
        body.light-mode .text-slate-400 { color: #475569 !important; }
        body.light-mode .text-slate-500 { color: #64748b !important; }
        body.light-mode .text-slate-600 { color: #475569 !important; }
        body.light-mode .opd-rail-item:hover,
        body.light-mode .opd-rail-item.is-active { color: var(--text-main); }

        * { box-sizing: border-box; }
        html, body { width: 100%; height: 100%; margin: 0; overflow: hidden; }
        body {
            background: var(--bg-base);
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: background 0.3s ease, color 0.3s ease;
            user-select: none;
        }

        .mono { font-family: 'JetBrains Mono', monospace; }

        /* Ambient Glow Effect */
        .ambient-glow {
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(circle at 15% 15%, rgba(6, 182, 212, 0.08), transparent 45%),
                radial-gradient(circle at 85% 20%, rgba(59, 130, 246, 0.08), transparent 40%),
                radial-gradient(circle at 50% 85%, rgba(16, 185, 129, 0.05), transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .screen {
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
        }

        /* Top Header */
        .topbar {
            height: 72px;
            min-width: 0;
            padding: 0 1.8vw;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-card);
            z-index: 20;
            flex-shrink: 0;
        }

        /* Glass Panel */
        .glass-panel {
            background: var(--bg-card);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-card);
            border-radius: 14px;
            transition: all 0.25s ease;
        }

        .glass-panel:hover {
            border-color: var(--border-glow);
        }

        /* TV Controls Bar */
        .control-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-card);
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .control-btn:hover {
            background: rgba(56, 189, 248, 0.15);
            border-color: var(--accent-cyan);
            color: var(--text-main);
            transform: translateY(-1px);
        }

        .control-btn.active {
            background: var(--accent-cyan);
            color: #041019;
            border-color: var(--accent-cyan);
            font-weight: 700;
        }

        /* Layout Grid */
        .dashboard-main {
            flex: 1;
            min-height: 0;
            display: grid;
            grid-template-columns: minmax(0, 1fr) 290px;
            gap: 16px;
            padding: 14px 1.8vw;
            position: relative;
        }

        .dashboard-main.rail-collapsed {
            grid-template-columns: minmax(0, 1fr);
        }

        /* Swiper Content */
        .swiper, .swiper-wrapper, .swiper-slide {
            width: 100%;
            height: 100%;
        }

        .slide-container {
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 14px;
            min-height: 0;
        }

        /* Metrics Card */
        .metric-card {
            min-width: 0;
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-card);
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--card-accent, var(--accent-cyan));
            border-radius: 4px 0 0 4px;
        }

        .metric-value {
            font-size: clamp(16px, 1.9vw, 26px);
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.15;
            color: var(--text-main);
            font-variant-numeric: tabular-nums;
            overflow-wrap: anywhere;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.2px;
            text-transform: uppercase;
        }

        .badge-success { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
        .badge-warning { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); }
        .badge-danger { background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.3); }
        .badge-info { background: rgba(6, 182, 212, 0.15); color: #38bdf8; border: 1px solid rgba(6, 182, 212, 0.3); }
        .badge-neutral { background: rgba(148, 163, 184, 0.15); color: var(--text-muted); border: 1px solid rgba(148, 163, 184, 0.2); }

        /* OPD Navigator Rail */
        .opd-rail {
            display: flex;
            flex-direction: column;
            min-height: 0;
            background: var(--bg-card);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-card);
            border-radius: 14px;
            padding: 12px;
        }

        .opd-rail-list {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding-right: 4px;
            scrollbar-width: thin;
            scrollbar-color: var(--border-card) transparent;
        }

        .opd-rail-item {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
            padding: 9px 12px;
            border-radius: 10px;
            border: 1px solid transparent;
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-muted);
            cursor: pointer;
            text-align: left;
            transition: all 0.2s ease;
        }

        .opd-rail-item-header {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .opd-rail-charts {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 6px;
            padding-left: 28px;
        }

        .opd-rail-chart {
            min-width: 0;
            padding: 5px 6px 3px;
            border: 1px solid var(--border-card);
            border-radius: 7px;
            background: rgba(255, 255, 255, 0.025);
        }

        .opd-rail-chart-title {
            display: block;
            overflow: hidden;
            color: var(--text-muted);
            font-size: 9px;
            font-weight: 600;
            line-height: 1.2;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .opd-rail-chart-canvas {
            position: relative;
            width: 100%;
            height: 38px;
        }

        .opd-rail-item.is-active .opd-rail-chart {
            border-color: rgba(6, 182, 212, 0.35);
        }

        .opd-rail-item:hover {
            background: rgba(255, 255, 255, 0.06);
            color: var(--text-main);
            border-color: var(--border-card);
        }

        .opd-rail-item.is-active {
            background: rgba(6, 182, 212, 0.12);
            border-color: var(--accent-cyan);
            color: var(--text-main);
            font-weight: 700;
            box-shadow: inset 3px 0 var(--accent-cyan);
        }

        /* Bottom Bar */
        .bottombar {
            height: 48px;
            padding: 0 1.8vw;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--bg-card);
            backdrop-filter: blur(14px);
            border-top: 1px solid var(--border-card);
            font-size: 12px;
            color: var(--text-muted);
            z-index: 20;
            flex-shrink: 0;
        }

        /* Progress Bar */
        .progress-track {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: rgba(255, 255, 255, 0.05);
            z-index: 30;
        }

        .progress-fill {
            height: 100%;
            width: 100%;
            background: linear-gradient(90deg, var(--accent-cyan), var(--accent-blue));
            transform-origin: left;
            transform: scaleX(0);
        }

        /* Pulse Animation */
        .live-pulse {
            position: relative;
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
        }

        .live-pulse::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.4);
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.7); opacity: 1; }
            100% { transform: scale(2.2); opacity: 0; }
        }

        /* Keep the entire dashboard reachable on smaller and shorter screens. */
        @media (max-width: 1200px), (max-height: 800px) {
            html, body {
                height: auto;
                min-height: 100%;
                overflow-x: hidden;
                overflow-y: auto;
            }

            .screen {
                width: 100%;
                height: auto;
                min-height: 100vh;
                min-height: 100dvh;
            }

            .topbar {
                height: auto;
                min-height: 72px;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px 16px;
                padding: 12px 16px;
            }

            .topbar > div:first-child,
            .topbar > div:last-child {
                flex: 1 1 260px;
            }

            .topbar > div:nth-child(2) {
                order: 3;
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .dashboard-main {
                display: flex;
                flex: 1 0 auto;
                flex-direction: column;
                gap: 12px;
                padding: 12px 16px;
            }

            .executive-swiper,
            .executive-swiper .swiper-wrapper,
            .executive-swiper .swiper-slide {
                height: auto;
            }

            .executive-swiper {
                min-height: 65vh;
                min-height: 65dvh;
                overflow: visible;
            }

            .executive-swiper .swiper-slide {
                min-height: 65vh;
                min-height: 65dvh;
            }

            .slide-container {
                height: auto;
                min-height: 65vh;
                min-height: 65dvh;
            }

            .opd-rail {
                display: flex;
                order: -1;
                padding: 8px;
            }

            .opd-rail > div:first-child {
                display: none;
            }

            .opd-rail-list {
                flex-direction: row;
                overflow-x: auto;
                overflow-y: hidden;
                min-height: 0;
                padding: 2px;
            }

            .opd-rail-item {
                flex: 0 0 220px;
            }

            .bottombar {
                position: sticky;
                bottom: 0;
                gap: 8px;
                min-height: 48px;
                height: auto;
                padding: 8px 16px;
            }
        }

        @media (max-width: 640px) {
            .topbar > div:first-child,
            .topbar > div:last-child {
                flex-basis: 100%;
                justify-content: center;
                text-align: center;
            }

            .dashboard-main { padding: 10px; }
            .slide-container { gap: 10px; }
            .metric-card { padding: 10px; }
            .bottombar { align-items: flex-start; flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="ambient-glow"></div>

    <main class="screen">
        <!-- TOPBAR: Brand & Executive Controls -->
        <header class="topbar">
            <!-- Left: City & Dashboard Identity -->
            <div class="flex items-center gap-3.5">
                <img class="w-10 h-10 object-contain drop-shadow-md" src="{{ asset('images/cmdcenterlogo.png') }}" alt="Logo Magelang">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-extrabold tracking-wide uppercase text-white tracking-wider">COMMAND CENTER KOTA MAGELANG</span>
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-cyan-500/20 text-cyan-400 border border-cyan-500/30">EKSEKUTIF</span>
                    </div>
                    <div class="text-[11px] text-slate-400 font-medium">Sistem Monitoring Pimpinan Terintegrasi Kota Magelang</div>
                </div>
            </div>

            <!-- Middle: TV Presentation Controls -->
            <div class="flex items-center gap-2">
                <form method="GET" action="{{ route('dashboard.eksekutif') }}" class="flex items-center gap-2">
                    <label for="dashboard-year" class="sr-only">Tahun data dashboard</label>
                    <select class="control-btn" id="dashboard-year" name="year" aria-label="Pilih tahun data dashboard" onchange="this.form.submit()">
                        @foreach ($years as $availableYear)
                            <option value="{{ $availableYear }}" @selected($year === $availableYear)>{{ $availableYear }}</option>
                        @endforeach
                    </select>
                </form>

                <!-- Autoplay Switcher -->
                <button class="control-btn" id="btn-toggle-autoplay" title="Putar / Jeda Rotasi Layar">
                    <i class="fa-solid fa-pause text-xs" id="icon-autoplay"></i>
                    <span id="text-autoplay">JEDA</span>
                </button>

                <!-- Speed Selector -->
                <div class="flex items-center bg-white/5 border border-white/10 rounded-lg p-0.5">
                    <button class="px-2.5 py-1 text-[11px] font-bold rounded text-slate-400 hover:text-white transition duration-150 speed-btn" data-speed="10000">10s</button>
                    <button class="px-2.5 py-1 text-[11px] font-bold rounded text-slate-400 hover:text-white transition duration-150 speed-btn active" data-speed="15000">15s</button>
                    <button class="px-2.5 py-1 text-[11px] font-bold rounded text-slate-400 hover:text-white transition duration-150 speed-btn" data-speed="25000">25s</button>
                </div>

                <!-- Manual Prev / Next -->
                <button class="control-btn" id="btn-prev-slide" title="Slide Sebelumnya">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <button class="control-btn" id="btn-next-slide" title="Slide Selanjutnya">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>

                <!-- Fullscreen Toggle -->
                <button class="control-btn" id="btn-fullscreen" title="Layar Penuh (F11)">
                    <i class="fa-solid fa-expand text-xs"></i>
                    <span>TV MODE</span>
                </button>

                <!-- Theme Switcher -->
                <button class="control-btn" id="btn-toggle-theme" title="Ubah Mode Gelap/Terang">
                    <i class="fa-solid fa-moon text-xs" id="icon-theme"></i>
                </button>
            </div>

            <!-- Right: System Status & Realtime Clock -->
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold">
                    <span class="live-pulse"></span>
                    <span>SISTEM AKTIF</span>
                </div>
                <div class="text-right">
                    <div class="text-xs text-slate-400 font-medium" id="live-date">-- -- ----</div>
                    <time class="text-base font-extrabold text-cyan-400 mono tracking-wider" id="live-clock">--:--:-- WIB</time>
                    <div class="text-[10px] text-slate-500">
                        Data terakhir berubah: {{ $lastDataUpdate ?? 'Belum ada data' }}
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN DASHBOARD CONTENT (SWIPER + SECTOR RAIL) -->
        <section class="dashboard-main" aria-label="Monitoring Eksekutif">
            <!-- Left/Center Main Swiper -->
            <div class="swiper executive-swiper">
                <div class="swiper-wrapper">
                    
                    <!-- SLIDE 0: RINGKASAN MAKRO KOTA (CITY EXECUTIVE PULSE) -->
                    <article class="swiper-slide" data-slide-id="city-summary" data-slide-title="Ringkasan Makro Kota">
                        <div class="slide-container">
                            <!-- Header Slide -->
                            <div class="flex items-center justify-between pb-2 border-b border-white/10">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-0.5 text-[11px] font-extrabold rounded-md bg-cyan-500 text-slate-950">UTAMA</span>
                                        <span class="text-xs font-semibold text-cyan-400 uppercase tracking-wider">PANORAMA EKSEKUTIF</span>
                                        <span class="text-xs text-slate-500">/</span>
                                        <span class="text-xs text-slate-400">{{ $citySummary['period'] }}</span>
                                    </div>
                                    <h1 class="text-2xl lg:text-3xl font-black tracking-tight text-white mt-1">Ringkasan Makro Kota Magelang</h1>
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 rounded-lg bg-white/5 border border-white/10 text-xs font-bold text-slate-300 mono">SLIDE 01 / {{ str_pad((string) ($opds->count() + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>

                            <!-- Executive Alert Banner (if exists) -->
                            @if (!empty($citySummary['alerts']))
                                <div class="grid grid-cols-1 md:grid-cols-{{ count($citySummary['alerts']) }} gap-3">
                                    @foreach ($citySummary['alerts'] as $alert)
                                        <div class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-{{ $alert['type'] === 'danger' ? 'rose' : ($alert['type'] === 'warning' ? 'amber' : 'sky') }}-500/15 border border-{{ $alert['type'] === 'danger' ? 'rose' : ($alert['type'] === 'warning' ? 'amber' : 'sky') }}-500/30 text-{{ $alert['type'] === 'danger' ? 'rose' : ($alert['type'] === 'warning' ? 'amber' : 'sky') }}-300 text-xs font-medium">
                                            <i class="fa-solid fa-triangle-exclamation text-base"></i>
                                            <div>
                                                <strong class="font-bold text-white">{{ $alert['title'] }}:</strong> {{ $alert['desc'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- 8 Strategic City KPIs Grid -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @foreach ($citySummary['metrics'] as $metric)
                                    <div class="metric-card">
                                        <div class="flex items-start justify-between gap-2 mb-1">
                                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wide leading-tight">{{ $metric['label'] }}</span>
                                            <span class="status-badge badge-{{ $metric['badge_type'] }}">{{ $metric['badge'] }}</span>
                                        </div>
                                        <div>
                                            <div class="metric-value">{{ $metric['value'] }}</div>
                                            @if (!empty($metric['sub']))
                                                <div class="text-[11px] text-slate-400 mt-0.5 truncate">{{ $metric['sub'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Macro Charts Grid -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3.5 flex-1 min-h-[190px]">
                                @foreach ($citySummary['charts'] as $cIndex => $chart)
                                    <div class="glass-panel p-3.5 flex flex-col min-h-0">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="text-sm font-bold text-white flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                                                {{ $chart['title'] }}
                                            </h3>
                                            <span class="text-[10px] text-slate-400 uppercase font-semibold">Grafik Analitik</span>
                                        </div>
                                        <div class="relative flex-1 min-h-[140px] w-full">
                                            <canvas id="chart-city-{{ $cIndex }}"></canvas>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </article>

                    <!-- SLIDES 1..N: INDIVIDUAL OPD / SEKTORAL SLIDES -->
                    @foreach ($opds as $opd)
                        <article class="swiper-slide" data-slide-id="opd-{{ $opd->id }}" data-slide-title="{{ $opd->name }}">
                            <div class="slide-container">
                                <!-- Slide Header -->
                                <div class="flex items-center justify-between pb-2 border-b border-white/10">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-0.5 text-[11px] font-bold rounded-md bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                                {{ $opd->dashboard_data['category'] ?? 'SEKTORAL' }}
                                            </span>
                                            <span class="text-xs text-slate-500">/</span>
                                            <span class="text-xs text-slate-400">{{ $opd->dashboard_data['period'] ?? 'Sistem Terintegrasi' }}</span>
                                        </div>
                                        <h1 class="text-2xl lg:text-3xl font-black tracking-tight text-white mt-1">{{ $opd->name }}</h1>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-3 py-1 rounded-lg bg-white/5 border border-white/10 text-xs font-bold text-slate-300 mono">
                                            SLIDE {{ str_pad((string) ($loop->iteration + 1), 2, '0', STR_PAD_LEFT) }} / {{ str_pad((string) ($opds->count() + 1), 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                </div>

                                @if ($opd->dashboard_data['available'])
                                    <!-- OPD KPI Metric Cards -->
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                                        @foreach ($opd->dashboard_data['metrics'] as $metric)
                                            <div class="metric-card">
                                                <div class="flex items-start justify-between gap-1 mb-1">
                                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-tight leading-tight">{{ $metric['label'] }}</span>
                                                    @if (!empty($metric['badge']))
                                                        <span class="status-badge badge-{{ $metric['badge_type'] ?? 'neutral' }} text-[10px]">{{ $metric['badge'] }}</span>
                                                    @endif
                                                </div>
                                                <div class="metric-value">{{ $metric['value'] }}</div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- OPD Charts Grid -->
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3.5 flex-1 min-h-[200px]">
                                        @foreach ($opd->dashboard_data['charts'] as $cIdx => $chart)
                                            <div class="glass-panel p-3.5 flex flex-col min-h-0">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                                                        <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                                                        {{ $chart['title'] }}
                                                    </h3>
                                                    <span class="text-[10px] text-slate-400 uppercase font-semibold">{{ $opd->dashboard_data['period'] }}</span>
                                                </div>
                                                <div class="relative flex-1 min-h-[150px] w-full">
                                                    <canvas id="chart-{{ $opd->id }}-{{ $cIdx }}"></canvas>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- Empty / Unconnected State -->
                                    <div class="flex-1 flex items-center justify-center">
                                        <div class="glass-panel p-8 max-w-lg text-center border-dashed border-slate-700">
                                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 text-2xl">
                                                <i class="fa-solid fa-server animate-pulse"></i>
                                            </div>
                                            <h2 class="text-lg font-bold text-white mb-1">Integrasi Data Sedang Disiapkan</h2>
                                            <p class="text-xs text-slate-400 leading-relaxed mb-4">{{ $opd->dashboard_data['message'] }}</p>
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-white/5 border border-white/10 text-xs font-semibold text-slate-300">
                                                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                                Status: Data belum terhubung
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <!-- Right Sidebar: Quick OPD Navigator -->
            <aside class="opd-rail" aria-label="Daftar Sektor OPD">
                <div class="flex items-center justify-between pb-3 mb-2 border-b border-white/10">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-layer-group text-cyan-400 text-xs"></i>
                        <h2 class="text-xs font-extrabold uppercase tracking-wider text-white">DAFTAR SEKTOR</h2>
                    </div>
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-white/5 border border-white/10 text-slate-400 mono">
                        {{ str_pad((string) ($opds->count() + 1), 2, '0', STR_PAD_LEFT) }} MENU
                    </span>
                </div>

                <nav class="opd-rail-list" aria-label="Pilih Slide">
                    <!-- City Summary Button -->
                    <button class="opd-rail-item is-active" type="button" data-slide-target="0">
                        <div class="opd-rail-item-header">
                            <span class="text-xs font-extrabold text-cyan-400 mono">01</span>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-bold text-white truncate">Ringkasan Makro Kota</div>
                                <div class="text-[10px] text-cyan-300/80 truncate">APBD, PAD, Proyek, Penduduk</div>
                            </div>
                            <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                        </div>
                        @if (!empty($citySummary['charts']))
                            <div class="opd-rail-charts" aria-hidden="true">
                                @foreach ($citySummary['charts'] as $cIndex => $chart)
                                    <div class="opd-rail-chart">
                                        <span class="opd-rail-chart-title">{{ $chart['title'] }}</span>
                                        <div class="opd-rail-chart-canvas">
                                            <canvas id="preview-chart-city-{{ $cIndex }}"></canvas>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </button>

                    <!-- Individual OPDs -->
                    @foreach ($opds as $opd)
                        <button class="opd-rail-item" type="button" data-slide-target="{{ $loop->iteration }}">
                            <div class="opd-rail-item-header">
                                <span class="text-xs font-extrabold text-slate-400 mono">{{ str_pad((string) ($loop->iteration + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-bold text-white truncate">{{ $opd->name }}</div>
                                    <div class="text-[10px] text-slate-400 truncate">
                                        {{ $opd->dashboard_data['available'] ? ($opd->dashboard_data['metrics'][0]['label'] . ': ' . $opd->dashboard_data['metrics'][0]['value']) : 'Menunggu API' }}
                                    </div>
                                </div>
                                <span class="w-2 h-2 rounded-full {{ $opd->dashboard_data['available'] ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                            </div>
                            @if ($opd->dashboard_data['available'] && !empty($opd->dashboard_data['charts']))
                                <div class="opd-rail-charts" aria-hidden="true">
                                    @foreach ($opd->dashboard_data['charts'] as $cIdx => $chart)
                                        <div class="opd-rail-chart">
                                            <span class="opd-rail-chart-title">{{ $chart['title'] }}</span>
                                            <div class="opd-rail-chart-canvas">
                                                <canvas id="preview-chart-{{ $opd->id }}-{{ $cIdx }}"></canvas>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </button>
                    @endforeach
                </nav>
            </aside>
        </section>

        <!-- BOTTOMBAR: Meta Info & Realtime Countdown -->
        <footer class="bottombar">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-2 text-slate-400">
                    <i class="fa-solid fa-rotate text-cyan-400 animate-spin" style="animation-duration: 6s;"></i>
                    <span id="label-countdown">Beralih otomatis dalam 15 detik...</span>
                </span>
                <span class="text-slate-600">|</span>
                <span class="text-slate-400 hidden sm:inline">Pembaruan data otomatis setiap 5 menit</span>
            </div>

            <div class="flex items-center gap-4">
                <button class="text-xs text-slate-400 hover:text-cyan-400 font-semibold transition" id="btn-refresh-data">
                    <i class="fa-solid fa-arrows-rotate mr-1"></i> Segarkan Data
                </button>
                <div class="text-xs font-extrabold text-slate-300 mono" id="label-slide-count">01 / {{ str_pad((string) ($opds->count() + 1), 2, '0', STR_PAD_LEFT) }}</div>
            </div>
        </footer>

        <!-- Bottom Animated Progress Bar -->
        <div class="progress-track" aria-hidden="true">
            <div class="progress-fill" id="progress-fill"></div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script>
        // Datasets injected from Laravel backend
        const citySummaryData = {{ Illuminate\Support\Js::from($citySummary) }};
        const dashboardOpds = {{ Illuminate\Support\Js::from($opds->map(fn ($opd) => ['id' => $opd->id, 'dashboard' => $opd->dashboard_data])->values()) }};

        // Theme management
        let isDarkMode = true;
        const getChartTextColor = () => isDarkMode ? '#94a3b8' : '#475569';
        const getChartGridColor = () => isDarkMode ? 'rgba(255, 255, 255, 0.06)' : 'rgba(0, 0, 0, 0.06)';

        const chartInstances = [];

        // Chart Initialization Helper
        const createDashboardChart = (canvasId, chartConfig, compact = false) => {
            const canvas = document.getElementById(canvasId);
            if (!canvas) return null;

            const isDoughnut = chartConfig.type === 'doughnut';
            const datasets = chartConfig.datasets.map((dataset) => {
                const colors = Array.isArray(dataset.color) ? dataset.color : [dataset.color];
                return {
                    label: dataset.label,
                    data: dataset.data,
                    borderColor: isDoughnut ? (isDarkMode ? '#0f172a' : '#ffffff') : colors[0],
                    backgroundColor: isDoughnut ? colors : chartConfig.type === 'line' ? 'rgba(6, 182, 212, 0.15)' : colors[0],
                    borderWidth: isDoughnut ? 3 : chartConfig.type === 'line' ? 2.5 : 0,
                    borderRadius: chartConfig.type === 'bar' ? 6 : 0,
                    pointRadius: chartConfig.type === 'line' ? (compact ? 1.5 : 4) : 0,
                    pointHoverRadius: compact ? 0 : 6,
                    pointBackgroundColor: colors[0],
                    fill: chartConfig.type === 'line',
                    tension: 0.38
                };
            });

            const instance = new Chart(canvas, {
                type: chartConfig.type,
                data: { labels: chartConfig.labels, datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: compact ? 0 : 600 },
                    plugins: {
                        legend: {
                            display: !compact && (isDoughnut || datasets.length > 1),
                            position: 'bottom',
                            labels: {
                                color: getChartTextColor(),
                                usePointStyle: true,
                                padding: 14,
                                font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }
                            }
                        },
                        tooltip: {
                            enabled: !compact,
                            backgroundColor: isDarkMode ? 'rgba(15, 23, 42, 0.95)' : 'rgba(255, 255, 255, 0.95)',
                            titleColor: isDarkMode ? '#f8fafc' : '#0f172a',
                            bodyColor: isDarkMode ? '#94a3b8' : '#334155',
                            borderColor: isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                            borderWidth: 1,
                            padding: 10,
                            boxPadding: 4,
                            usePointStyle: true
                        }
                    },
                    scales: isDoughnut ? {} : {
                        x: {
                            display: !compact,
                            grid: { display: !compact, color: getChartGridColor() },
                            ticks: {
                                display: !compact,
                                color: getChartTextColor(),
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 8,
                                font: { family: 'Plus Jakarta Sans', size: 10, weight: '600' }
                            },
                            border: { display: false }
                        },
                        y: {
                            display: !compact,
                            beginAtZero: true,
                            grid: { display: !compact, color: getChartGridColor() },
                            ticks: {
                                display: !compact,
                                color: getChartTextColor(),
                                precision: 0,
                                font: { family: 'JetBrains Mono', size: 10 },
                                callback: (val) => chartConfig.unit === 'miliar' ? `Rp ${val} M` : new Intl.NumberFormat('id-ID').format(val)
                            },
                            border: { display: false }
                        }
                    }
                }
            });

            chartInstances.push(instance);
            return instance;
        };

        // Render compact previews in the sector navigator using the same chart data.
        if (citySummaryData && citySummaryData.charts) {
            citySummaryData.charts.forEach((chart, idx) => {
                createDashboardChart(`preview-chart-city-${idx}`, chart, true);
            });
        }

        dashboardOpds.forEach(({ id, dashboard }) => {
            if (!dashboard.available || !dashboard.charts) return;
            dashboard.charts.forEach((chart, idx) => {
                createDashboardChart(`preview-chart-${id}-${idx}`, chart, true);
            });
        });

        // Render City Macro Charts
        if (citySummaryData && citySummaryData.charts) {
            citySummaryData.charts.forEach((chart, idx) => {
                createDashboardChart(`chart-city-${idx}`, chart);
            });
        }

        // Render OPD Charts
        dashboardOpds.forEach(({ id, dashboard }) => {
            if (!dashboard.available || !dashboard.charts) return;
            dashboard.charts.forEach((chart, idx) => {
                createDashboardChart(`chart-${id}-${idx}`, chart);
            });
        });

        // Realtime Clock & Date
        const updateClock = () => {
            const now = new Date();
            const timeFormatter = new Intl.DateTimeFormat('id-ID', {
                timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false
            });
            const dateFormatter = new Intl.DateTimeFormat('id-ID', {
                timeZone: 'Asia/Jakarta', weekday: 'long', day: '2-digit', month: 'short', year: 'numeric'
            });

            document.getElementById('live-clock').textContent = timeFormatter.format(now) + ' WIB';
            document.getElementById('live-date').textContent = dateFormatter.format(now);
        };
        updateClock();
        setInterval(updateClock, 1000);

        // Slider Setup
        let currentDelay = 15000;
        let isAutoplayRunning = true;
        const totalSlides = document.querySelectorAll('.executive-swiper .swiper-slide').length;
        const progressFill = document.getElementById('progress-fill');
        const labelCountdown = document.getElementById('label-countdown');
        const labelSlideCount = document.getElementById('label-slide-count');
        const railItems = [...document.querySelectorAll('[data-slide-target]')];

        const swiper = new Swiper('.executive-swiper', {
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 800,
            loop: totalSlides > 1,
            allowTouchMove: false,
            autoplay: totalSlides > 1 ? { delay: currentDelay, disableOnInteraction: false, pauseOnMouseEnter: false } : false,
            on: {
                autoplayTimeLeft(instance, timeLeft, progress) {
                    if (isAutoplayRunning) {
                        progressFill.style.transform = `scaleX(${1 - progress})`;
                        labelCountdown.textContent = `Beralih otomatis dalam ${Math.ceil(timeLeft / 1000)} detik...`;
                    }
                },
                slideChange(instance) {
                    const currentIndex = instance.realIndex;
                    labelSlideCount.textContent = `${String(currentIndex + 1).padStart(2, '0')} / ${String(totalSlides).padStart(2, '0')}`;
                    
                    railItems.forEach((item, idx) => {
                        const isActive = idx === currentIndex;
                        item.classList.toggle('is-active', isActive);
                        if (isActive) item.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                    });
                }
            }
        });

        // Autoplay Toggle Button
        const btnToggleAutoplay = document.getElementById('btn-toggle-autoplay');
        const iconAutoplay = document.getElementById('icon-autoplay');
        const textAutoplay = document.getElementById('text-autoplay');

        btnToggleAutoplay.addEventListener('click', () => {
            if (isAutoplayRunning) {
                swiper.autoplay.stop();
                isAutoplayRunning = false;
                iconAutoplay.className = 'fa-solid fa-play text-xs';
                textAutoplay.textContent = 'PUTAR';
                labelCountdown.textContent = 'Rotasi otomatis dijeda';
                progressFill.style.transform = 'scaleX(0)';
            } else {
                swiper.autoplay.start();
                isAutoplayRunning = true;
                iconAutoplay.className = 'fa-solid fa-pause text-xs';
                textAutoplay.textContent = 'JEDA';
            }
        });

        // Speed Buttons
        document.querySelectorAll('.speed-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.speed-btn').forEach(b => b.classList.remove('active', 'text-white', 'bg-cyan-500/20'));
                btn.classList.add('active', 'text-white', 'bg-cyan-500/20');
                
                currentDelay = Number(btn.dataset.speed);
                swiper.params.autoplay.delay = currentDelay;
                if (isAutoplayRunning) {
                    swiper.autoplay.stop();
                    swiper.autoplay.start();
                }
            });
        });

        // Prev & Next Buttons
        document.getElementById('btn-prev-slide').addEventListener('click', () => {
            swiper.slidePrev();
            if (isAutoplayRunning) swiper.autoplay.start();
        });
        document.getElementById('btn-next-slide').addEventListener('click', () => {
            swiper.slideNext();
            if (isAutoplayRunning) swiper.autoplay.start();
        });

        // Rail Navigation Clicks
        railItems.forEach(item => {
            item.addEventListener('click', () => {
                const target = Number(item.dataset.slideTarget);
                if (totalSlides > 1) swiper.slideToLoop(target);
                else swiper.slideTo(target);
                if (isAutoplayRunning) swiper.autoplay.start();
            });
        });

        // Fullscreen Toggle
        const btnFullscreen = document.getElementById('btn-fullscreen');
        btnFullscreen.addEventListener('click', () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => console.log(err));
                btnFullscreen.classList.add('active');
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
                btnFullscreen.classList.remove('active');
            }
        });

        // Theme Toggle (Dark / Light)
        const btnToggleTheme = document.getElementById('btn-toggle-theme');
        const iconTheme = document.getElementById('icon-theme');
        btnToggleTheme.addEventListener('click', () => {
            isDarkMode = !isDarkMode;
            document.body.classList.toggle('light-mode', !isDarkMode);
            iconTheme.className = isDarkMode ? 'fa-solid fa-moon text-xs' : 'fa-solid fa-sun text-xs text-amber-500';
            
            // Re-render chart styles
            chartInstances.forEach(chart => {
                if (chart.options.scales && chart.options.scales.x) {
                    chart.options.scales.x.grid.color = getChartGridColor();
                    chart.options.scales.x.ticks.color = getChartTextColor();
                    chart.options.scales.y.grid.color = getChartGridColor();
                    chart.options.scales.y.ticks.color = getChartTextColor();
                }
                if (chart.options.plugins.legend) {
                    chart.options.plugins.legend.labels.color = getChartTextColor();
                }
                chart.update();
            });
        });

        // Manual Data Refresh (Re-fetches current page)
        document.getElementById('btn-refresh-data').addEventListener('click', () => {
            window.location.reload();
        });

        // Auto reload page every 5 minutes for clean sync
        setTimeout(() => {
            window.location.reload();
        }, 5 * 60 * 1000);
    </script>
</body>
</html>