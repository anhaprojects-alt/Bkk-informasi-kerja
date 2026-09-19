<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="manifest" href="/manifest.json">
    <title>BKK - Histori Lamaran Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800 pwa-optimized">

    <header class="bg-white border-b border-slate-200 h-14 sticky top-0 z-50 flex items-center">
        <div class="linkedin-container flex items-center justify-between">
            <div class="flex items-center gap-3">
                <x-partials.logo size="sm" :withText="false" />
                <h1 class="text-base font-black text-slate-900 tracking-tight">Lamaran Saya</h1>
            </div>
        </div>
    </header>

    <div class="linkedin-container mt-6 pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <aside class="lg:col-span-3 hidden lg:block">
                <div class="glass-card p-4 space-y-4">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Filter Status</p>
                    <div class="space-y-2">
                        <button class="w-full text-left px-3 py-2 bg-blue-50 text-blue-700 rounded-lg text-xs font-black uppercase tracking-wider">Semua Lamaran</button>
                        <button class="w-full text-left px-3 py-2 text-slate-500 hover:bg-slate-50 rounded-lg text-xs font-bold uppercase tracking-wider transition">Menunggu</button>
                        <button class="w-full text-left px-3 py-2 text-slate-500 hover:bg-slate-50 rounded-lg text-xs font-bold uppercase tracking-wider transition">Diterima</button>
                    </div>
                </div>
            </aside>

            <main class="lg:col-span-9 space-y-4">
                @forelse ($applications as $app)
                    <div class="glass-card p-5 group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="h-6 w-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <div class="min-w-0">
                                    @if ($app->jobListing)
                                        <h3 class="font-black text-slate-900 text-base leading-tight">
                                            <a href="{{ route('jobs.show', $app->jobListing) }}" class="hover:text-blue-600 hover:underline">{{ $app->jobListing->title }}</a>
                                        </h3>
                                        <p class="text-sm font-bold text-slate-500 mt-0.5">{{ $app->jobListing->company->name ?? 'Mitra BKK' }}</p>
                                    @else
                                        <h3 class="font-bold text-slate-400 italic">Lowongan Terhapus</h3>
                                    @endif
                                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-2 tracking-widest flex items-center gap-1.5">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Dilamar {{ $app->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            @php
                                $colors = [
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'accepted' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'rejected' => 'bg-red-50 text-red-600 border-red-100',
                                ];
                                $label = ['pending' => 'Menunggu', 'accepted' => 'Diterima', 'rejected' => 'Ditolak'];
                            @endphp
                            <span class="shrink-0 px-3 py-1.5 rounded-lg border text-[10px] font-black uppercase tracking-widest {{ $colors[$app->status] ?? 'bg-slate-50' }}">
                                {{ $label[$app->status] ?? $app->status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 rounded-xl p-12 text-center">
                        <p class="text-slate-500 font-bold">Anda belum melamar pekerjaan apapun.</p>
                        <a href="{{ route('jobs.index') }}" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white font-black rounded-full text-sm">Cari Lowongan</a>
                    </div>
                @endforelse
            </main>

        </div>
    </div>

    @include('applicant.partials.bottom-nav', ['active' => 'applications'])
</body>
</html>
