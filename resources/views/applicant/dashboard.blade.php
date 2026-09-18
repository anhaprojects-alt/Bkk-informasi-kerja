<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Smart Analytics Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-slate-50 flex flex-col shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-x border-slate-200/50 relative">

        <!-- Header -->
        <header class="p-5 sticky top-0 bg-white/90 backdrop-blur-md z-40 border-b border-slate-200/60 shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="flex items-center gap-3">
                <x-partials.logo size="sm" :withText="false" />
                <div>
                    <h1 class="text-base font-black text-slate-900 tracking-tight">Smart Analytics</h1>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Performa & Intelijen Karir</p>
                </div>
            </div>
            <!-- Intelligent Status Pulse Badge -->
            <span class="flex h-3 w-3 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-600"></span>
            </span>
        </header>

        <!-- Main Insights Feed -->
        <main class="flex-1 overflow-y-auto p-5 space-y-5 pb-28">

            <!-- 1. AI Compatibility Score Progress Gauge (3D Neon Wave) -->
            <div class="p-5 bg-gradient-to-br from-blue-700 to-indigo-900 text-white rounded-3xl shadow-[0_12px_30px_rgba(30,64,175,0.2)] border border-blue-600/30 relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/5 rounded-full blur-xl pointer-events-none"></div>
                <div class="relative z-10 flex items-center justify-between gap-4">
                    <div class="space-y-1">
                        <span class="text-[9px] font-black uppercase tracking-widest text-blue-200 bg-blue-800/60 px-2 py-0.5 rounded-md">Alur Karir Cerdas</span>
                        <h2 class="text-base font-black tracking-tight mt-1">Kesesuaian Profil Anda</h2>
                        <p class="text-[11px] text-blue-100/90 leading-tight">Berdasarkan kalkulasi algoritma minat lowongan saat ini.</p>
                    </div>
                    <!-- Circular 3D progress metric simulation -->
                    <div class="shrink-0 w-16 h-16 rounded-full bg-slate-900/40 border border-white/10 flex flex-col items-center justify-center p-1 shadow-[inset_0_4px_6px_rgba(0,0,0,0.2)]">
                        <span class="text-lg font-black text-amber-400 leading-none">{{ $compatibilityScore }}%</span>
                        <span class="text-[8px] uppercase tracking-wider text-slate-300 font-bold mt-0.5">Match</span>
                    </div>
                </div>

                <!-- Custom Bar Gauge Track -->
                <div class="w-full bg-slate-950/40 rounded-full h-2 mt-4 shadow-inner overflow-hidden p-0.5">
                    <div class="bg-gradient-to-r from-amber-400 to-amber-300 h-full rounded-full shadow-[0_0_8px_#fbbf24]" style="width: {{ $compatibilityScore }}%"></div>
                </div>
            </div>

            <!-- 2. Application Funnel Tracking Mini 3D Box Grid -->
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-white p-3 rounded-2xl border border-slate-200/80 border-b-4 border-slate-200 text-center space-y-1">
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Dilamar</span>
                    <h3 class="text-lg font-black text-slate-800 leading-none shadow-sm inline-block bg-slate-100 px-2 py-1 rounded-lg">{{ $totalApplied }}</h3>
                </div>
                <div class="bg-white p-3 rounded-2xl border border-slate-200/80 border-b-4 border-slate-200 text-center space-y-1">
                    <span class="text-[9px] font-bold text-emerald-600 uppercase tracking-wider block">Diterima</span>
                    <h3 class="text-lg font-black text-emerald-700 leading-none shadow-sm inline-block bg-emerald-50 border border-emerald-100 px-2 py-1 rounded-lg">{{ $acceptedCount }}</h3>
                </div>
                <div class="bg-white p-3 rounded-2xl border border-slate-200/80 border-b-4 border-slate-200 text-center space-y-1">
                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider block">Proses</span>
                    <h3 class="text-lg font-black text-blue-700 leading-none shadow-sm inline-block bg-blue-50 border border-blue-100 px-2 py-1 rounded-lg">{{ $pendingCount }}</h3>
                </div>
            </div>

            <!-- 3. Smart Intelligence Market Exploration Graphic Widget -->
            <section class="bg-white p-5 rounded-3xl border border-slate-200/60 shadow-[0_4px_15px_rgba(0,0,0,0.02)] space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-l-4 border-blue-500 pl-2">Riset Pasar Kerja Intelijen</h3>

                <div class="space-y-3 font-semibold text-xs text-slate-600">
                    <div class="flex justify-between items-center bg-slate-50 p-2.5 rounded-xl border border-slate-200/40">
                        <span>Lowongan Aktif Sistem</span>
                        <span class="text-slate-900 font-black bg-white px-2 py-0.5 rounded-md shadow-sm border">{{ $marketStats['totalActiveJobs'] }} Instansi</span>
                    </div>
                    <div class="flex justify-between items-center bg-slate-50 p-2.5 rounded-xl border border-slate-200/40">
                        <span>Pusat Rekrutmen Terpadat</span>
                        <span class="text-blue-700 font-black bg-white px-2 py-0.5 rounded-md shadow-sm border">{{ $marketStats['topHiringLocation'] }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-slate-50 p-2.5 rounded-xl border border-slate-200/40">
                        <span>Tren Kompensasi Terkini</span>
                        <span class="text-amber-700 font-black bg-white px-2 py-0.5 rounded-md shadow-sm border">{{ $marketStats['averageSalaryInsight'] }}</span>
                    </div>
                </div>

                <!-- 3D Bar Graph Simulation using Tailwind CSS height animations -->
                <div class="pt-3 flex items-end justify-between px-4 h-24 bg-slate-50 rounded-2xl border border-slate-200/40 shadow-inner">
                    <div class="w-6 bg-gradient-to-t from-blue-600 to-blue-400 h-1/3 rounded-t-md shadow-md" title="IT & Tech"></div>
                    <div class="w-6 bg-gradient-to-t from-indigo-600 to-indigo-400 h-4/5 rounded-t-md shadow-md" title="Finance"></div>
                    <div class="w-6 bg-gradient-to-t from-amber-500 to-amber-300 h-2/3 rounded-t-md shadow-md" title="Marketing"></div>
                    <div class="w-6 bg-gradient-to-t from-blue-700 to-blue-500 h-1/2 rounded-t-md shadow-md" title="Engineering"></div>
                    <div class="w-6 bg-gradient-to-t from-emerald-600 to-emerald-400 h-3/4 rounded-t-md shadow-md" title="Creative"></div>
                </div>
                <div class="flex justify-between text-[8px] uppercase font-black text-slate-400 tracking-wider px-2">
                    <span>Tech</span>
                    <span>Finance</span>
                    <span>Sales</span>
                    <span>Eng</span>
                    <span>Art</span>
                </div>
            </section>

            <!-- 4. Top Curated Personalized Highlights Recommendations -->
            <section class="space-y-3">
                <div class="flex justify-between items-center">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-l-4 border-blue-500 pl-2">Rekomendasi Cerdas Khusus</h3>
                    <a href="{{ route('jobs.index') }}" class="text-[10px] font-black uppercase text-blue-600 tracking-wider hover:underline">Semua</a>
                </div>

                <div class="space-y-3">
                    @foreach ($recommendations as $rec)
                        <a href="{{ route('jobs.show', $rec) }}" class="block p-4 bg-white border border-slate-200/80 rounded-2xl border-b-2 hover:border-blue-500 shadow-sm transition">
                            <div class="flex justify-between items-start gap-2">
                                <div class="min-w-0">
                                    <h4 class="font-bold text-slate-800 text-sm truncate leading-tight">{{ $rec->title }}</h4>
                                    <p class="text-[11px] text-slate-400 font-semibold mt-0.5 truncate">{{ $rec->company->name ?? 'Mitra BKK' }}</p>
                                </div>
                                <span class="shrink-0 text-[10px] font-bold text-blue-600 bg-blue-50/60 py-0.5 px-2 rounded-lg border border-blue-100">95% Match</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

        </main>

        <!-- Floating Bottom Dock Nav component -->
        @include('applicant.partials.bottom-nav', ['active' => 'dashboard'])

    </div>
</body>
</html>
