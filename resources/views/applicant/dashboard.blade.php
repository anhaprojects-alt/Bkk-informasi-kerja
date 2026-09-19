<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Smart Analytics Dashboard</title>
    <link rel="manifest" href="/manifest.json">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800 pwa-optimized">

    <!-- Top Navigation (Professional Fixed Bar) -->
    <header class="bg-white border-b border-slate-200 h-14 sticky top-0 z-50 flex items-center">
        <div class="linkedin-container flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <x-partials.logo size="sm" :withText="false" />
                <div class="relative group hidden sm:block">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </span>
                    <input type="text" placeholder="Cari peluang..." class="bg-[#eef3f8] border-none rounded-md py-1.5 pl-10 pr-4 text-sm w-64 focus:ring-2 focus:ring-blue-600 transition-all">
                </div>
            </div>

            <div class="flex items-center gap-4 text-slate-500">
                <span class="flex h-3 w-3 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-600"></span>
                </span>
                <div class="hidden sm:flex flex-col items-end leading-none">
                    <p class="text-xs font-black text-slate-800">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Profil Premium</p>
                </div>
            </div>
        </div>
    </header>

    <div class="linkedin-container mt-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- LEFT SIDEBAR: Mini Profile Card -->
            <aside class="lg:col-span-3 space-y-4">
                <div class="glass-card relative">
                    <div class="h-14 bg-gradient-to-r from-blue-600 to-indigo-800"></div>
                    <div class="px-4 pb-4">
                        <div class="relative -mt-8 mb-3 flex justify-center">
                            <div class="w-16 h-16 bg-white rounded-full p-1 border-2 border-white shadow-md">
                                <div class="w-full h-full bg-slate-100 rounded-full flex items-center justify-center text-blue-600">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                            </div>
                        </div>
                        <div class="text-center border-b border-slate-100 pb-4">
                            <h2 class="font-black text-slate-900 leading-tight">{{ Auth::user()->name }}</h2>
                            <p class="text-[11px] text-slate-500 font-medium mt-1 leading-relaxed px-4">Alumni Professional & Pencari Kerja Publik</p>
                        </div>
                        <div class="py-3 space-y-2">
                            <div class="flex justify-between text-[11px] font-bold">
                                <span class="text-slate-400 uppercase tracking-tighter">Profil Terlihat</span>
                                <span class="text-blue-600">124</span>
                            </div>
                            <div class="flex justify-between text-[11px] font-bold">
                                <span class="text-slate-400 uppercase tracking-tighter">Koneksi Baru</span>
                                <span class="text-blue-600">42</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-card hidden lg:block">
                    <div class="p-4 space-y-3">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Navigasi Cepat</p>
                        <a href="{{ route('jobs.index') }}" class="flex items-center gap-3 text-sm font-bold text-slate-600 hover:text-blue-600 transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Lowongan Tersimpan
                        </a>
                        <a href="{{ route('applications.mine') }}" class="flex items-center gap-3 text-sm font-bold text-slate-600 hover:text-blue-600 transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            Histori Lamaran
                        </a>
                    </div>
                </div>
            </aside>

            <!-- CENTER CONTENT: Analytics Feed -->
            <main class="lg:col-span-6 space-y-5 pb-24 lg:pb-8">

                <!-- 1. AI Match Score Widget (Premium) -->
                <div class="glass-card p-6 bg-gradient-to-br from-white to-blue-50/30">
                    <div class="flex items-center justify-between mb-6">
                        <div class="space-y-1">
                            <h3 class="font-black text-slate-900 text-lg tracking-tight">Intelijen Karir Anda</h3>
                            <p class="text-xs font-medium text-slate-500">Skor kecocokan profil terhadap tren industri terkini.</p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center text-white font-black text-lg shadow-lg shadow-blue-200">
                            {{ $compatibilityScore }}%
                        </div>
                    </div>

                    <div class="w-full bg-slate-100 rounded-full h-3 mb-6 shadow-inner p-0.5 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full" style="width: {{ $compatibilityScore }}%"></div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 border-t border-slate-100 pt-6">
                        <div class="text-center">
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-wider">Dilamar</p>
                            <p class="text-xl font-black text-slate-800">{{ $totalApplied }}</p>
                        </div>
                        <div class="text-center border-x border-slate-100">
                            <p class="text-[10px] font-black uppercase text-emerald-600 tracking-wider">Diterima</p>
                            <p class="text-xl font-black text-emerald-700">{{ $acceptedCount }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] font-black uppercase text-blue-600 tracking-wider">Proses</p>
                            <p class="text-xl font-black text-blue-700">{{ $pendingCount }}</p>
                        </div>
                    </div>
                </div>

                <!-- 2. Market Insights Graph (Taktil 3D) -->
                <div class="glass-card p-6">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6 border-l-4 border-blue-600 pl-3">Sebaran Industri Terserap</h3>

                    <div class="flex items-end justify-between h-32 gap-3 px-2">
                        <div class="flex-1 bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg shadow-sm h-[30%] relative group">
                            <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">Tech</span>
                        </div>
                        <div class="flex-1 bg-gradient-to-t from-indigo-600 to-indigo-400 rounded-t-lg shadow-sm h-[80%] relative group">
                            <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">Fin</span>
                        </div>
                        <div class="flex-1 bg-gradient-to-t from-amber-500 to-amber-300 rounded-t-lg shadow-sm h-[60%] relative group">
                            <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">Sale</span>
                        </div>
                        <div class="flex-1 bg-gradient-to-t from-emerald-600 to-emerald-400 rounded-t-lg shadow-sm h-[50%] relative group">
                            <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">Art</span>
                        </div>
                    </div>
                    <div class="flex justify-between mt-4 text-[9px] font-black text-slate-400 uppercase tracking-widest px-2">
                        <span>IT</span><span>Finance</span><span>Marketing</span><span>Creative</span>
                    </div>
                </div>

                <!-- 3. Smart Recommendations List -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between px-2">
                        <h3 class="text-xs font-black uppercase text-slate-400 tracking-widest">Rekomendasi Cerdas</h3>
                        <a href="{{ route('jobs.index') }}" class="text-[10px] font-black text-blue-600 uppercase">Lihat Semua</a>
                    </div>

                    @foreach ($recommendations as $rec)
                        <a href="{{ route('jobs.show', $rec) }}" class="glass-card p-4 block hover:shadow-md transition-all border-b-2 hover:border-blue-600">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex gap-3 min-w-0">
                                    <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="h-6 w-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-800 text-sm truncate">{{ $rec->title }}</h4>
                                        <p class="text-[11px] text-slate-400 font-medium truncate">{{ $rec->company->name ?? 'Mitra BKK' }}</p>
                                        <p class="text-[10px] text-slate-400 mt-1 font-bold">{{ $rec->location }}</p>
                                    </div>
                                </div>
                                <span class="shrink-0 text-[10px] font-black text-blue-600 bg-blue-50 py-1 px-2 rounded-md">98% Match</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </main>

            <!-- RIGHT SIDEBAR: Community & Highlights -->
            <aside class="lg:col-span-3 hidden lg:block space-y-4">
                <div class="glass-card p-4">
                    <h3 class="text-xs font-black uppercase text-slate-800 tracking-wider mb-4">Wawasan Pasar Kerja</h3>
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-tighter">Lokasi Terpopuler</p>
                            <p class="text-xs font-bold text-blue-700 bg-blue-50 px-2 py-1 rounded-md inline-block">{{ $marketStats['topHiringLocation'] }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-tighter">Tren Kompensasi</p>
                            <p class="text-xs font-bold text-amber-700 bg-amber-50 px-2 py-1 rounded-md inline-block">{{ $marketStats['averageSalaryInsight'] }}</p>
                        </div>
                        <div class="space-y-1 border-t border-slate-100 pt-4">
                            <p class="text-[10px] text-slate-400 leading-relaxed font-medium">Berdasarkan data dari <span class="font-bold text-slate-600">{{ $marketStats['totalActiveJobs'] }} lowongan aktif</span> dalam sistem hari ini.</p>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-4 bg-blue-600 text-white relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition duration-700"></div>
                    <h3 class="font-black text-sm tracking-tight relative z-10 leading-tight">Lengkapi Profil Anda untuk verifikasi Prioritas</h3>
                    <p class="text-[10px] text-blue-100 mt-2 font-medium relative z-10 leading-relaxed">Profil yang lengkap meningkatkan peluang dilirik perusahaan hingga 75%.</p>
                    <button class="mt-4 w-full bg-white text-blue-600 py-2 rounded-lg font-black text-[10px] uppercase tracking-widest shadow-sm">Lengkapi Sekarang</button>
                </div>
            </aside>

        </div>
    </div>

    <!-- Floating Bottom Dock (Mobile Only) -->
    @include('applicant.partials.bottom-nav', ['active' => 'dashboard'])

</body>
</html>
