<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Lowongan Kerja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-white flex flex-col shadow-xl">

        <!-- Header -->
        <header class="p-6 pb-4 sticky top-0 bg-white/90 backdrop-blur z-10 border-b border-slate-100">
            <div class="flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider truncate">Halo, {{ Auth::user()->name }}</p>
                    <h1 class="text-xl font-extrabold text-slate-900 mt-0.5">Temukan Lowongan</h1>
                </div>
                <span class="shrink-0 p-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-bold text-sm"
                    title="{{ $jobs->total() }} lowongan tersedia">{{ $jobs->total() }}</span>
            </div>

            <form method="GET" action="{{ route('jobs.index') }}" role="search" class="mt-4">
                <label for="q" class="sr-only">Cari lowongan</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="search" id="q" name="q" value="{{ $search }}" enterkeyhint="search" autocomplete="off"
                        placeholder="Cari posisi, lokasi, atau perusahaan..."
                        class="block w-full pl-10 pr-24 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                    <div class="absolute inset-y-0 right-0 flex items-center gap-1 pr-1.5">
                        @if ($search !== '')
                            <a href="{{ route('jobs.index') }}" aria-label="Hapus pencarian"
                                class="inline-flex items-center justify-center h-8 w-8 text-slate-400 hover:text-slate-600 rounded-lg transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                        <button type="submit"
                            class="inline-flex items-center h-8 px-3 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-1">
                            Cari
                        </button>
                    </div>
                </div>
            </form>
        </header>

        <!-- Feed -->
        <main class="flex-1 overflow-y-auto p-6 pt-4 space-y-3.5 pb-24">
            @if (session('status'))
                <div role="status" class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl">
                    {{ session('status') }}
                </div>
            @endif

            @if ($search !== '')
                <p class="text-xs text-slate-400">
                    {{ $jobs->total() }} hasil untuk &ldquo;{{ $search }}&rdquo;
                </p>
            @endif

            @forelse ($jobs as $job)
                <a href="{{ route('jobs.show', $job) }}"
                    class="block p-4 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-indigo-300 hover:shadow-md transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                    <div class="flex items-start justify-between">
                        <div class="min-w-0">
                            <h3 class="font-bold text-slate-800 truncate">{{ $job->title }}</h3>
                            <p class="text-sm text-slate-500 mt-0.5">{{ $job->company->name ?? 'Perusahaan' }}</p>
                        </div>
                        @if (in_array($job->id, $appliedJobIds))
                            <span class="shrink-0 ml-2 inline-flex py-1 px-2.5 text-[11px] font-semibold bg-emerald-50 text-emerald-600 rounded-full">Dilamar</span>
                        @endif
                    </div>
                    <div class="flex flex-wrap items-center gap-2 mt-3 text-xs">
                        <span class="inline-flex items-center gap-1 py-1 px-2.5 bg-slate-100 text-slate-600 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $job->location }}
                        </span>
                        @if ($job->salary)
                            <span class="inline-flex py-1 px-2.5 bg-indigo-50 text-indigo-600 rounded-full font-semibold">{{ $job->salary }}</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="text-center py-16">
                    <div class="w-16 h-16 mx-auto bg-slate-100 rounded-full flex items-center justify-center text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true" focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    @if ($search !== '')
                        <p class="text-sm text-slate-500 mt-4">Tidak ada lowongan yang cocok dengan &ldquo;{{ $search }}&rdquo;.</p>
                        <a href="{{ route('jobs.index') }}" class="inline-block mt-4 py-2.5 px-5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition">Lihat Semua Lowongan</a>
                    @else
                        <p class="text-sm text-slate-500 mt-4">Belum ada lowongan yang tersedia saat ini.</p>
                    @endif
                </div>
            @endforelse

            @if ($jobs->hasPages())
                <nav aria-label="Navigasi halaman" class="pt-2">
                    {{ $jobs->onEachSide(1)->links() }}
                </nav>
            @endif
        </main>

        <!-- Bottom Navigation -->
        @include('applicant.partials.bottom-nav', ['active' => 'jobs'])

    </div>
</body>
</html>
