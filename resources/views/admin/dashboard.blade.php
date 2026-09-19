<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - {{ Auth::user()->role === 'admin' ? 'Management Panel' : 'Recruitment Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800">
    <div class="min-h-screen flex">

        <!-- Sidebar Navigation (Professional Deep Sidebar) -->
        <aside class="w-64 bg-slate-900 text-white flex-col justify-between hidden md:flex border-r border-slate-800 shadow-xl">
            <div>
                <div class="p-6 border-b border-slate-800 bg-slate-950/20">
                    <x-partials.logo size="sm" :withText="true" :inverse="true" />
                </div>

                <nav aria-label="Navigasi panel" class="p-4 space-y-2 mt-4">
                    <p class="text-[10px] font-black uppercase text-slate-500 tracking-[0.2em] px-4 mb-2">Menu Utama</p>

                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl font-bold transition duration-150">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" /></svg>
                        <span>Dashboard</span>
                    </a>

                    @if(Auth::user()->role === 'admin')
                        <!-- ADMIN ONLY MENUS -->
                        <p class="text-[10px] font-black uppercase text-slate-500 tracking-[0.2em] px-4 pt-4 mb-2">Management</p>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl font-bold transition duration-150">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            <span>Manajemen User</span>
                        </a>
                    @endif

                    <p class="text-[10px] font-black uppercase text-slate-500 tracking-[0.2em] px-4 pt-4 mb-2">Lowongan</p>
                    <a href="{{ route('jobs.create') }}" class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('jobs.create') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl font-bold transition duration-150">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        <span>Tambah Lowongan</span>
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-slate-800 bg-slate-950/20">
                <a href="{{ route('settings.profile') }}" class="flex items-center space-x-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl font-bold transition mb-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span>Pengaturan Profil</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" x-data="{ busy: false }" x-on:submit="busy = true">
                    @csrf
                    <button type="submit" :disabled="busy" class="w-full flex items-center space-x-3 px-4 py-3 text-red-400 hover:bg-red-600/10 rounded-xl font-bold transition focus:outline-none">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b border-slate-200 min-h-16 flex items-center justify-between px-6 z-30 shadow-sm sticky top-0">
                <h2 class="text-lg font-black text-slate-900 tracking-tight">
                    @if(Auth::user()->role === 'admin')
                        System Management
                    @else
                        Partner Recruitment Dashboard
                    @endif
                </h2>
                <div class="flex items-center gap-3">
                    <div class="bg-slate-100 py-1.5 px-4 rounded-full border border-slate-200">
                        <span class="text-xs font-black text-slate-600 uppercase tracking-widest">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 space-y-8">
                @if (session('status'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-2xl shadow-sm">
                        {{ session('status') }}
                    </div>
                @endif

                @if(Auth::user()->role === 'admin')
                    <!-- ADMIN VIEW -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="glass-card p-6 border-b-4 border-blue-600">
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Total Pengguna</p>
                            <h4 class="text-3xl font-black text-slate-900 leading-none">{{ $stats['totalUsers'] }}</h4>
                        </div>
                        <div class="glass-card p-6 border-b-4 border-emerald-600">
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Mitra Perusahaan</p>
                            <h4 class="text-3xl font-black text-slate-900 leading-none">{{ $stats['totalCompanies'] }}</h4>
                        </div>
                        <div class="glass-card p-6 border-b-4 border-indigo-600">
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Total Lowongan</p>
                            <h4 class="text-3xl font-black text-slate-900 leading-none">{{ $stats['totalJobs'] }}</h4>
                        </div>
                        <div class="glass-card p-6 border-b-4 border-amber-600">
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Menunggu Validasi</p>
                            <h4 class="text-3xl font-black text-amber-600 leading-none">{{ $stats['pendingJobs'] }}</h4>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Recent Users -->
                        <div class="glass-card">
                            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                                <h4 class="font-black text-slate-800 text-sm tracking-tight uppercase">User Baru Terdaftar</h4>
                                <a href="{{ route('admin.users.index') }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Semua</a>
                            </div>
                            <div class="divide-y divide-slate-100">
                                @foreach($recentUsers as $u)
                                    <div class="p-4 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-400">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-slate-900">{{ $u->name }}</p>
                                                <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $u->role }}</p>
                                            </div>
                                        </div>
                                        <span class="text-[10px] font-bold text-slate-300 uppercase tracking-tighter">{{ $u->created_at->diffForHumans() }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Global Recent Jobs -->
                        <div class="glass-card">
                            <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                                <h4 class="font-black text-slate-800 text-sm tracking-tight uppercase">Aktivitas Lowongan Terbaru</h4>
                            </div>
                            <div class="divide-y divide-slate-100">
                                @foreach($recentJobs as $j)
                                    <div class="p-4">
                                        <p class="text-sm font-black text-slate-900 leading-tight">{{ $j->title }}</p>
                                        <p class="text-[10px] font-bold text-blue-600 uppercase mt-1">{{ $j->company->name ?? '-' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                @else
                    <!-- COMPANY VIEW -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="glass-card p-6 border-b-4 border-blue-600">
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Lowongan Aktif</p>
                            <h4 class="text-3xl font-black text-slate-900 leading-none">{{ $stats['openJobs'] }}</h4>
                        </div>
                        <div class="glass-card p-6 border-b-4 border-indigo-600">
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Total Pelamar Masuk</p>
                            <h4 class="text-3xl font-black text-slate-900 leading-none">{{ $stats['totalApplications'] }}</h4>
                        </div>
                        <div class="glass-card p-6 border-b-4 border-emerald-600">
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Kandidat Diterima</p>
                            <h4 class="text-3xl font-black text-emerald-600 leading-none">{{ $stats['hiredCount'] }}</h4>
                        </div>
                    </div>

                    <div class="glass-card">
                        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                            <h4 class="font-black text-slate-800 text-sm tracking-tight uppercase">Daftar Lowongan Saya</h4>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400 tracking-widest border-b border-slate-100">
                                    <tr>
                                        <th class="p-4">Posisi Pekerjaan</th>
                                        <th class="p-4 text-center">Pelamar</th>
                                        <th class="p-4">Status</th>
                                        <th class="p-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-xs font-bold text-slate-700">
                                    @forelse($jobs as $job)
                                        <tr>
                                            <td class="p-4 font-black text-slate-900">{{ $job->title }}</td>
                                            <td class="p-4 text-center">
                                                <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded-lg">{{ $job->applicants_count }}</span>
                                            </td>
                                            <td class="p-4">
                                                <span class="px-2 py-0.5 rounded-lg border {{ $job->status === 'open' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-slate-100 text-slate-400' }}">
                                                    {{ strtoupper($job->status) }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-center">
                                                @if($job->status === 'open')
                                                    <form method="POST" action="{{ route('jobs.close', $job) }}">
                                                        @csrf @method('PATCH')
                                                        <button class="text-red-500 hover:underline uppercase text-[9px] font-black tracking-widest">Tutup</button>
                                                    </form>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-8 text-center text-slate-400">Belum ada lowongan.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>
</body>
</html>
