<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Dashboard Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 font-sans antialiased text-slate-800">
    <div class="min-h-screen flex">

        <!-- Sidebar Navigation (3D Deep Oceanic Sidebar) -->
        <aside class="w-64 bg-slate-900 text-white flex-col justify-between hidden md:flex border-r border-slate-800 shadow-[10px_0_30px_rgba(0,0,0,0.05)]">
            <div>
                <div class="p-5 flex items-center border-b border-slate-800 bg-slate-950/30">
                    <!-- Inline customized full white/light logo representation -->
                    <x-partials.logo size="sm" :withText="true" :inverse="true" />
                </div>

                <nav aria-label="Navigasi panel" class="p-4 space-y-1.5">
                    <a href="{{ route('dashboard') }}" aria-current="page" class="flex items-center space-x-3 px-4 py-3.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl font-bold shadow-[0_4px_12px_rgba(29,78,216,0.3)] border border-blue-500/20 transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('jobs.create') }}" class="flex items-center space-x-3 px-4 py-3.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-2xl font-semibold transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Tambah Lowongan</span>
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-slate-800 bg-slate-950/20">
                <form method="POST" action="{{ route('logout') }}" x-data="{ busy: false }" x-on:submit="busy = true">
                    @csrf
                    <button type="submit" :disabled="busy" :class="busy && 'opacity-60 cursor-not-allowed'"
                        class="w-full flex items-center space-x-3 px-4 py-3.5 text-slate-400 hover:bg-red-600/10 hover:text-red-400 rounded-2xl font-bold transition focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar Panel</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <header class="bg-white border-b border-slate-200/80 min-h-20 flex items-center justify-between gap-3 px-6 z-30 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                <div class="flex items-center gap-3">
                    <div class="md:hidden">
                        <x-partials.logo size="sm" :withText="false" />
                    </div>
                    <h2 class="text-lg font-black text-slate-900 tracking-tight">Dashboard Utama</h2>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <span class="hidden sm:inline text-xs font-bold text-slate-600 bg-slate-100/80 border border-slate-200/50 py-2 px-4 rounded-xl shadow-[inset_0_1px_2px_rgba(255,255,255,1)]">
                        {{ Auth::user()->name }} <span class="text-blue-600/80 font-black">({{ ucfirst(Auth::user()->role) }})</span>
                    </span>

                    <form method="POST" action="{{ route('logout') }}" class="md:hidden" x-data="{ busy: false }" x-on:submit="busy = true">
                        @csrf
                        <button type="submit" :disabled="busy" :class="busy && 'opacity-60 cursor-not-allowed'" aria-label="Keluar akun"
                            class="inline-flex items-center justify-center p-2.5 text-slate-500 hover:text-red-600 hover:bg-red-50 border border-slate-200 shadow-sm rounded-xl transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 space-y-6">

                @if (session('status'))
                    <div role="status" class="p-4 bg-gradient-to-r from-emerald-50 to-emerald-100/50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-2xl shadow-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Premium 3D Welcome Banner -->
                <div class="p-6 bg-gradient-to-br from-blue-700 to-indigo-800 text-white rounded-3xl shadow-[0_15px_35px_rgba(30,64,175,0.2)] border border-blue-600/20 flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 relative overflow-hidden">
                    <div aria-hidden="true" class="absolute -right-8 -bottom-8 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                    <div class="space-y-1 z-10">
                        <h3 class="text-xl font-black tracking-tight">Selamat Datang di Panel Utama BKK</h3>
                        <p class="text-blue-100 text-xs font-medium">Kelola seluruh data lowongan kerja, validasi kemitraan, dan pantau statistik aplikasi pelamar dengan mudah.</p>
                    </div>
                    <a href="{{ route('jobs.create') }}"
                        class="shrink-0 text-center px-5 py-3 bg-white text-blue-700 font-bold rounded-2xl shadow-md border-b-4 border-slate-200 active:border-b-0 active:translate-y-[4px] text-xs uppercase tracking-wider transition-all duration-150 z-10">
                        Tambah Lowongan Baru
                    </a>
                </div>

                <!-- Analytics Cards (3D Soft Box) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-[0_8px_25px_rgba(0,0,0,0.01)] border-b-4 border-slate-200/90 flex items-center space-x-4">
                        <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl shadow-[inset_0_1px_2px_rgba(255,255,255,1)] border border-blue-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="space-y-0.5">
                            <span class="text-slate-400 text-[10px] font-black uppercase tracking-wider block">{{ Auth::user()->role === 'admin' ? 'Perusahaan Mitra' : 'Profil Perusahaan' }}</span>
                            <h4 class="text-2xl font-black text-slate-800 leading-none">{{ $stats['companies'] }}</h4>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-[0_8px_25px_rgba(0,0,0,0.01)] border-b-4 border-slate-200/90 flex items-center space-x-4">
                        <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl shadow-[inset_0_1px_2px_rgba(255,255,255,1)] border border-emerald-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div class="space-y-0.5">
                            <span class="text-slate-400 text-[10px] font-black uppercase tracking-wider block">Lowongan Dibuka</span>
                            <h4 class="text-2xl font-black text-slate-800 leading-none">{{ $stats['openJobs'] }}</h4>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-[0_8px_25px_rgba(0,0,0,0.01)] border-b-4 border-slate-200/90 flex items-center space-x-4">
                        <div class="p-4 bg-amber-50 text-amber-600 rounded-2xl shadow-[inset_0_1px_2px_rgba(255,255,255,1)] border border-amber-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="space-y-0.5">
                            <span class="text-slate-400 text-[10px] font-black uppercase tracking-wider block">Total Pelamar</span>
                            <h4 class="text-2xl font-black text-slate-800 leading-none">{{ $stats['applicants'] }}</h4>
                        </div>
                    </div>
                </div>

                <!-- Recent Job Listings (Structured 3D Card Panel) -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-slate-200/60 bg-slate-50/50 flex justify-between items-center gap-3">
                        <h4 class="font-black text-slate-800 text-sm tracking-tight">Daftar Lowongan Pekerjaan Terbaru</h4>
                        <span class="shrink-0 text-[11px] font-bold text-slate-400 uppercase bg-slate-200/60 px-2.5 py-0.5 rounded-lg">{{ $jobs->count() }} Terbaru</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black border-b border-slate-200 tracking-wider">
                                    <th class="p-4">Judul Lowongan</th>
                                    <th class="p-4">Perusahaan</th>
                                    <th class="p-4">Lokasi</th>
                                    <th class="p-4 text-center">Pelamar</th>
                                    <th class="p-4">Status</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                                @php
                                    $statusStyles = [
                                        'open' => 'bg-emerald-50 text-emerald-600 border-emerald-200/50',
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-200/50',
                                        'closed' => 'bg-slate-100 text-slate-500 border-slate-200/50',
                                    ];
                                    $statusLabels = ['open' => 'Aktif', 'pending' => 'Menunggu', 'closed' => 'Ditutup'];
                                @endphp
                                @forelse ($jobs as $job)
                                    <tr class="hover:bg-slate-50/40 transition">
                                        <td class="p-4 font-black text-slate-900 text-sm tracking-tight">{{ $job->title }}</td>
                                        <td class="p-4 text-slate-500 font-medium">{{ $job->company->name ?? '-' }}</td>
                                        <td class="p-4 text-slate-500 font-medium">{{ $job->location }}</td>
                                        <td class="p-4 text-center text-slate-800 font-bold">
                                            <span class="bg-slate-100 py-1 px-2.5 rounded-lg shadow-inner">{{ $job->applicants_count }}</span>
                                        </td>
                                        <td class="p-4">
                                            <span class="inline-flex py-0.5 px-2.5 font-bold uppercase tracking-wider rounded-lg border {{ $statusStyles[$job->status] ?? 'bg-slate-100 text-slate-500' }}">
                                                {{ $statusLabels[$job->status] ?? ucfirst($job->status) }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-center">
                                            @if ($job->status !== 'closed')
                                                <div x-data="{ confirming: false, busy: false }" class="inline-flex flex-col items-center gap-1">
                                                    <button type="button" x-show="!confirming" x-on:click="confirming = true"
                                                        class="text-red-500 font-bold hover:text-red-700 uppercase tracking-widest text-[10px] bg-red-50 px-2 py-1 rounded-lg border border-red-100 transition focus:outline-none">
                                                        Tutup
                                                    </button>
                                                    <div x-show="confirming" x-cloak class="flex flex-col items-center gap-1 bg-white p-2 border border-slate-200 shadow-xl rounded-xl absolute right-4 z-50">
                                                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wide">Tutup lowongan ini?</span>
                                                        <div class="flex items-center gap-1.5 mt-1">
                                                            <form method="POST" action="{{ route('jobs.close', $job) }}" x-on:submit="busy = true">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" :disabled="busy" :class="busy && 'opacity-60 cursor-not-allowed'"
                                                                    class="py-1 px-2.5 bg-gradient-to-b from-red-600 to-red-700 text-white text-[10px] font-bold rounded-lg border-b-2 border-red-900 active:border-b-0 active:translate-y-[1px] transition-all">
                                                                    Ya, Tutup
                                                                </button>
                                                            </form>
                                                            <button type="button" x-on:click="confirming = false" :disabled="busy"
                                                                class="py-1 px-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] font-bold rounded-lg border border-slate-200">
                                                                Batal
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-xs text-slate-300 font-normal" aria-label="Tidak ada aksi">&mdash;</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-slate-400 font-medium">
                                            Belum ada lowongan pekerjaan yang diterbitkan.
                                            <a href="{{ route('jobs.create') }}" class="font-bold text-blue-600 hover:text-blue-700 transition">Mulai tambah sekarang</a>.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>

    </div>
</body>
</html>
