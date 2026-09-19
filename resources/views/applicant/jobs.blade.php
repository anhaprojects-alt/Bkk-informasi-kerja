<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Jaringan Lowongan Kerja</title>
    <link rel="manifest" href="/manifest.json">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800 pwa-optimized">

    <!-- Top Navigation Bar -->
    <header class="bg-white border-b border-slate-200 h-14 sticky top-0 z-50 flex items-center">
        <div class="linkedin-container flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <x-partials.logo size="sm" :withText="false" />
                <form action="{{ route('jobs.index') }}" method="GET" class="relative group hidden sm:block">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </span>
                    <input type="search" name="q" value="{{ $search }}" placeholder="Cari posisi, perusahaan..." class="bg-[#eef3f8] border-none rounded-md py-1.5 pl-10 pr-4 text-sm w-72 focus:ring-2 focus:ring-blue-600 transition-all">
                </form>
            </div>

            <div class="flex items-center gap-2">
                <span class="py-1 px-3 bg-blue-50 text-blue-700 rounded-full font-black text-[10px] uppercase border border-blue-100">
                    {{ $jobs->total() }} Peluang Tersedia
                </span>
            </div>
        </div>
    </header>

    <div class="linkedin-container mt-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- LEFT SIDEBAR: Personal Navigation -->
            <aside class="lg:col-span-3 space-y-4">
                <div class="glass-card">
                    <div class="p-4 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-black">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-black text-slate-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase truncate">Pelamar Aktif</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-slate-100 space-y-3">
                            <a href="{{ route('applicant.dashboard') }}" class="flex items-center justify-between group">
                                <span class="text-xs font-bold text-slate-500 group-hover:text-blue-600">Analitik Saya</span>
                                <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-1.5 rounded">Baru</span>
                            </a>
                            <a href="{{ route('applications.mine') }}" class="flex items-center justify-between group">
                                <span class="text-xs font-bold text-slate-500 group-hover:text-blue-600">Lamaran Saya</span>
                                <span class="text-[10px] font-bold text-slate-400">#{{ count(Auth::user()->applications) }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-4 hidden lg:block">
                    <p class="text-[10px] font-black uppercase text-slate-400 mb-3 tracking-widest">Pencarian Populer</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="text-[11px] font-bold text-slate-600 bg-slate-100 px-2 py-1 rounded hover:bg-slate-200 cursor-pointer transition">#Laravel</span>
                        <span class="text-[11px] font-bold text-slate-600 bg-slate-100 px-2 py-1 rounded hover:bg-slate-200 cursor-pointer transition">#Remote</span>
                        <span class="text-[11px] font-bold text-slate-600 bg-slate-100 px-2 py-1 rounded hover:bg-slate-200 cursor-pointer transition">#Fullstack</span>
                    </div>
                </div>
            </aside>

            <!-- CENTER CONTENT: Job Feed -->
            <main class="lg:col-span-6 space-y-4 pb-24 lg:pb-8">

                <!-- Mobile Search Bar (Only visible on Mobile) -->
                <div class="sm:hidden mb-4">
                    <form action="{{ route('jobs.index') }}" method="GET" class="relative">
                        <input type="search" name="q" value="{{ $search }}" placeholder="Cari posisi..." class="w-full bg-white border border-slate-200 rounded-xl py-3 px-4 shadow-sm focus:ring-2 focus:ring-blue-600">
                    </form>
                </div>

                @if ($search !== '')
                    <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center justify-between">
                        <p class="text-sm font-bold text-slate-600">Hasil untuk: <span class="text-blue-600">"{{ $search }}"</span></p>
                        <a href="{{ route('jobs.index') }}" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-red-500">Hapus</a>
                    </div>
                @endif

                @forelse ($jobs as $job)
                    <!-- LinkedIn Style Job Card -->
                    <div class="glass-card group hover:shadow-md transition-shadow">
                        <div class="p-4 flex gap-4">
                            <!-- Company Logo Placeholder -->
                            <div class="w-12 h-12 bg-slate-100 border border-slate-200 rounded-md flex items-center justify-center shrink-0">
                                <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-black text-blue-600 text-base leading-tight group-hover:underline cursor-pointer">
                                        <a href="{{ route('jobs.show', $job) }}">{{ $job->title }}</a>
                                    </h3>
                                    @php $isApplied = in_array($job->id, $appliedJobIds); @endphp
                                    @if ($isApplied)
                                        <span class="shrink-0 text-[9px] font-black uppercase text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">Sudah Dilamar</span>
                                    @endif
                                </div>
                                <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $job->company->name ?? 'Mitra BKK' }}</p>
                                <p class="text-xs text-slate-500 mt-1 font-medium">{{ $job->location }}</p>

                                <div class="flex items-center gap-3 mt-3 text-[11px] font-bold">
                                    <span class="text-emerald-600">Aktif</span>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-slate-400">{{ $job->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex justify-between items-center">
                            @if ($job->salary)
                                <span class="text-xs font-black text-slate-600">{{ $job->salary }}</span>
                            @else
                                <span class="text-xs font-bold text-slate-400 italic">Gaji rahasia</span>
                            @endif
                            <a href="{{ route('jobs.show', $job) }}" class="px-4 py-1.5 border-2 border-blue-600 text-blue-600 rounded-full font-black text-xs hover:bg-blue-600 hover:text-white transition-all">Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                            <svg class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <h4 class="font-black text-slate-900 text-lg">Peluang belum ditemukan</h4>
                        <p class="text-slate-500 text-sm mt-1 font-medium">Coba gunakan kata kunci lain atau bersihkan filter.</p>
                        <a href="{{ route('jobs.index') }}" class="mt-6 inline-block px-6 py-2 bg-blue-600 text-white font-black rounded-full text-sm">Lihat Semua</a>
                    </div>
                @endforelse

                @if ($jobs->hasPages())
                    <div class="pt-4 pb-8">
                        {{ $jobs->onEachSide(1)->links() }}
                    </div>
                @endif
            </main>

            <!-- RIGHT SIDEBAR: Professional Insights -->
            <aside class="lg:col-span-3 hidden lg:block space-y-4">
                <div class="glass-card p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">Tips Karir Premium</h3>
                        <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div class="space-y-4">
                        <div class="group cursor-pointer">
                            <p class="text-xs font-bold text-slate-700 group-hover:text-blue-600 transition leading-tight">Cara Menulis Surat Lamaran yang "Menjual" di Mata HRD</p>
                            <p class="text-[10px] text-slate-400 mt-1 font-medium">2.412 Pembaca</p>
                        </div>
                        <div class="group cursor-pointer pt-3 border-t border-slate-50">
                            <p class="text-xs font-bold text-slate-700 group-hover:text-blue-600 transition leading-tight">Tren Gaji Developer 2026: Apa Saja yang Berubah?</p>
                            <p class="text-[10px] text-slate-400 mt-1 font-medium">1.890 Pembaca</p>
                        </div>
                    </div>
                </div>

                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest text-center px-4">
                    BKK &copy; 2026. Semua Hak Dilindungi.
                </div>
            </aside>

        </div>
    </div>

    <!-- Mobile Navigation Dock -->
    @include('applicant.partials.bottom-nav', ['active' => 'jobs'])

</body>
</html>
