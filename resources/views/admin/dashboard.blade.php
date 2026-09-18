<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKK - Dashboard Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans antialiased text-slate-800">
    <div class="min-h-screen flex">

        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-indigo-900 text-white flex-col justify-between hidden md:flex">
            <div>
                <div class="p-5 flex items-center space-x-2 border-b border-indigo-800">
                    <div class="p-1.5 bg-white rounded-lg text-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold tracking-wider">BKK Panel</span>
                </div>

                <nav aria-label="Navigasi panel" class="p-4 space-y-1">
                    <a href="{{ route('dashboard') }}" aria-current="page" class="flex items-center space-x-3 px-4 py-3 bg-indigo-800 text-white rounded-xl font-medium transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('jobs.create') }}" class="flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 hover:text-white rounded-xl transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Tambah Lowongan</span>
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-indigo-800">
                <form method="POST" action="{{ route('logout') }}" x-data="{ busy: false }" @submit="busy = true">
                    @csrf
                    <button type="submit" :disabled="busy" :class="busy && 'opacity-60 cursor-not-allowed'"
                        class="w-full flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-red-600 hover:text-white rounded-xl transition focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <header class="bg-white border-b border-slate-200 min-h-16 flex items-center justify-between gap-3 px-4 sm:px-6 z-10 shadow-sm">
                <h2 class="text-lg sm:text-xl font-bold text-slate-800 truncate">Dashboard Utama</h2>
                <div class="flex items-center gap-2 shrink-0">
                    <span class="hidden sm:inline text-sm font-semibold text-slate-600 bg-slate-100 py-1.5 px-3 rounded-lg">
                        {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                    </span>
                    {{-- The sidebar is hidden below md, so mobile needs its own logout affordance. --}}
                    <form method="POST" action="{{ route('logout') }}" class="md:hidden" x-data="{ busy: false }" @submit="busy = true">
                        @csrf
                        <button type="submit" :disabled="busy" :class="busy && 'opacity-60 cursor-not-allowed'" aria-label="Keluar akun"
                            class="inline-flex items-center justify-center p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">

                @if (session('status'))
                    <div role="status" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Welcome Banner -->
                <div class="p-6 bg-indigo-600 text-white rounded-2xl shadow-xl shadow-indigo-100 flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
                    <div>
                        <h3 class="text-xl font-bold">Selamat Datang di Panel Utama BKK</h3>
                        <p class="text-indigo-100 text-sm mt-1">Kelola data lowongan kerja dan pantau statistik pelamar.</p>
                    </div>
                    <a href="{{ route('jobs.create') }}"
                        class="shrink-0 text-center px-5 py-2.5 bg-white text-indigo-600 font-semibold rounded-xl shadow-sm text-sm hover:bg-slate-50 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-indigo-600">
                        Tambah Lowongan Baru
                    </a>
                </div>

                <!-- Analytics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-4">
                        <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">{{ Auth::user()->role === 'admin' ? 'Perusahaan Mitra' : 'Profil Perusahaan' }}</span>
                            <h4 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $stats['companies'] }}</h4>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-4">
                        <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Lowongan Dibuka</span>
                            <h4 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $stats['openJobs'] }}</h4>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-4">
                        <div class="p-3.5 bg-sky-50 text-sky-600 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Pelamar</span>
                            <h4 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $stats['applicants'] }}</h4>
                        </div>
                    </div>
                </div>

                <!-- Recent Job Listings -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-slate-200 flex justify-between items-center gap-3">
                        <h4 class="font-bold text-slate-800">Daftar Lowongan Pekerjaan Terbaru</h4>
                        <span class="shrink-0 text-xs font-semibold text-slate-400">{{ $jobs->count() }} terbaru</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-400 uppercase text-xs font-bold border-b border-slate-200">
                                    <th class="p-4">Judul Lowongan</th>
                                    <th class="p-4">Perusahaan</th>
                                    <th class="p-4">Lokasi</th>
                                    <th class="p-4 text-center">Pelamar</th>
                                    <th class="p-4">Status</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @php
                                    $statusStyles = [
                                        'open' => 'bg-emerald-50 text-emerald-600',
                                        'pending' => 'bg-amber-50 text-amber-600',
                                        'closed' => 'bg-slate-100 text-slate-500',
                                    ];
                                    $statusLabels = ['open' => 'Aktif', 'pending' => 'Menunggu', 'closed' => 'Ditutup'];
                                @endphp
                                @forelse ($jobs as $job)
                                    <tr>
                                        <td class="p-4 font-semibold text-slate-800">{{ $job->title }}</td>
                                        <td class="p-4 text-slate-500">{{ $job->company->name ?? '-' }}</td>
                                        <td class="p-4 text-slate-500">{{ $job->location }}</td>
                                        <td class="p-4 text-center text-slate-600 font-semibold">{{ $job->applicants_count }}</td>
                                        <td class="p-4">
                                            <span class="inline-flex py-1 px-2.5 text-xs font-semibold rounded-full {{ $statusStyles[$job->status] ?? 'bg-slate-100 text-slate-500' }}">
                                                {{ $statusLabels[$job->status] ?? ucfirst($job->status) }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-center">
                                            @if ($job->status !== 'closed')
                                                <div x-data="{ confirming: false, busy: false }" class="inline-flex flex-col items-center gap-1">
                                                    <button type="button" x-show="!confirming" x-on:click="confirming = true"
                                                        class="text-slate-400 font-semibold hover:text-red-600 text-xs transition focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded px-1 py-0.5">
                                                        Tutup
                                                    </button>
                                                    <div x-show="confirming" x-cloak class="flex flex-col items-center gap-1">
                                                        <span class="text-[11px] text-slate-500">Tutup lowongan ini?</span>
                                                        <div class="flex items-center gap-1.5">
                                                            <form method="POST" action="{{ route('jobs.close', $job) }}" x-on:submit="busy = true">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" :disabled="busy" :class="busy && 'opacity-60 cursor-not-allowed'"
                                                                    class="py-1 px-2.5 bg-red-600 hover:bg-red-700 text-white text-[11px] font-semibold rounded-lg transition focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500">
                                                                    Ya, tutup
                                                                </button>
                                                            </form>
                                                            <button type="button" x-on:click="confirming = false" :disabled="busy"
                                                                class="py-1 px-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-[11px] font-semibold rounded-lg transition focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-400">
                                                                Batal
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-xs text-slate-300" aria-label="Tidak ada aksi">&mdash;</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-slate-400 text-sm">
                                            Belum ada lowongan.
                                            <a href="{{ route('jobs.create') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Tambah lowongan baru</a>
                                            untuk memulai.
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
