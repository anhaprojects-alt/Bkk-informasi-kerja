<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Lowongan Kerja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-slate-50 flex flex-col shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-x border-slate-200/50 relative">

        <!-- Header (3D Glassmorphism Header) -->
        <header class="p-5 sticky top-0 bg-white/90 backdrop-blur-md z-40 border-b border-slate-200/60 shadow-[0_4px_12px_rgba(0,0,0,0.03)]">
            <div class="flex items-center justify-between gap-3">
                <div class="min-w-0 flex items-center gap-3">
                    <x-partials.logo size="sm" :withText="false" />
                    <div class="min-w-0">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider truncate">Halo, {{ Auth::user()->name }}</p>
                        <h1 class="text-lg font-black text-slate-900 leading-none mt-0.5">Temukan Lowongan</h1>
                    </div>
                </div>
                <span class="shrink-0 py-1.5 px-3 bg-gradient-to-b from-blue-50 to-blue-100/60 text-blue-700 rounded-xl font-extrabold text-xs border border-blue-200/60 shadow-sm"
                    title="{{ $jobs->total() }} lowongan tersedia">{{ $jobs->total() }} Lowongan</span>
            </div>

            <!-- Search Field with Inset Depth -->
            <form method="GET" action="{{ route('jobs.index') }}" role="search" class="mt-4">
                <label for="q" class="sr-only">Cari lowongan</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="search" id="q" name="q" value="{{ $search }}" enterkeyhint="search" autocomplete="off"
                        placeholder="Cari posisi, lokasi, atau perusahaan..."
                        class="block w-full pl-10 pr-24 py-3 bg-slate-100/80 border border-slate-200/80 rounded-2xl text-xs font-medium focus:outline-none focus:border-blue-500 focus:bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] focus:shadow-none transition duration-150">
                    <div class="absolute inset-y-0 right-0 flex items-center gap-1.5 pr-2">
                        @if ($search !== '')
                            <a href="{{ route('jobs.index') }}" aria-label="Hapus pencarian"
                                class="inline-flex items-center justify-center h-7 w-7 text-slate-400 hover:text-slate-600 rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                        <button type="submit"
                            class="inline-flex items-center h-8 px-3.5 bg-gradient-to-b from-blue-600 to-blue-700 text-white text-[11px] font-bold rounded-xl shadow-sm border-b-2 border-blue-800 active:border-b-0 active:translate-y-[2px] transition-all">
                            Cari
                        </button>
                    </div>
                </div>
            </form>
        </header>

        <!-- Feed List -->
        <main class="flex-1 overflow-y-auto p-5 space-y-4 pb-28">
            @if (session('status'))
                <div role="status" class="p-3.5 bg-gradient-to-r from-emerald-50 to-emerald-100/50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($search !== '')
                <p class="text-xs font-bold text-slate-400 tracking-wide bg-slate-200/50 py-1 px-3 rounded-lg inline-block">
                    {{ $jobs->total() }} hasil untuk &ldquo;{{ $search }}&rdquo;
                </p>
            @endif

            @forelse ($jobs as $job)
                <!-- 3D Layered Card -->
                <a href="{{ route('jobs.show', $job) }}"
                    class="block p-5 bg-white border border-slate-200/70 rounded-3xl shadow-[0_8px_20px_rgba(0,0,0,0.02)] border-b-4 border-slate-200/90 hover:border-b-blue-500 hover:shadow-[0_12px_24px_rgba(30,64,175,0.08)] transform hover:scale-[1.01] transition-all duration-200 focus:outline-none">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0 space-y-1">
                            <h3 class="font-black text-slate-800 text-base tracking-tight truncate">{{ $job->title }}</h3>
                            <p class="text-xs font-bold text-blue-600/80 truncate">{{ $job->company->name ?? 'Perusahaan Mitra' }}</p>
                        </div>
                        @if (in_array($job->id, $appliedJobIds))
                            <span class="shrink-0 inline-flex py-1 px-2.5 text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-200/50 shadow-[inset_0_1px_2px_rgba(255,255,255,1)]">Dilamar</span>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-2 mt-4 pt-3 border-t border-slate-100 text-[11px] font-bold">
                        <span class="inline-flex items-center gap-1 py-1 px-2.5 bg-slate-100 text-slate-600 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $job->location }}
                        </span>
                        @if ($job->salary)
                            <span class="inline-flex py-1 px-2.5 bg-amber-50 border border-amber-200/40 text-amber-700 rounded-xl shadow-[inset_0_1px_2px_rgba(255,255,255,1)]">{{ $job->salary }}</span>
                        @endif
                    </div>
                </a>
            @empty
                <!-- 3D Empty State Presentation -->
                <div class="text-center py-16 bg-white border border-slate-200/60 rounded-3xl p-6 shadow-sm">
                    <div class="w-16 h-16 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 border-b-2 border-slate-200 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    @if ($search !== '')
                        <p class="text-sm font-semibold text-slate-500 mt-4">Tidak ada lowongan yang cocok dengan &ldquo;{{ $search }}&rdquo;.</p>
                        <a href="{{ route('jobs.index') }}" class="inline-block mt-4 py-3 px-5 bg-gradient-to-b from-blue-600 to-blue-700 text-white text-xs font-bold rounded-2xl shadow-md border-b-4 border-blue-900 active:border-b-0 active:translate-y-[4px] transition-all">Lihat Semua Lowongan</a>
                    @else
                        <p class="text-sm font-semibold text-slate-500 mt-4">Belum ada lowongan yang tersedia saat ini.</p>
                    @endif
                </div>
            @endforelse

            @if ($jobs->hasPages())
                <nav aria-label="Navigasi halaman" class="pt-3 pb-4">
                    {{ $jobs->onEachSide(1)->links() }}
                </nav>
            @endif
        </main>

        <!-- Bottom Navigation component -->
        @include('applicant.partials.bottom-nav', ['active' => 'jobs'])

    </div>
</body>
</html>
