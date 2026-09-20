<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Manajemen Pengguna</title>
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
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl font-bold transition duration-150">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" /></svg>
                        <span>Dashboard</span>
                    </a>

                    <p class="text-[10px] font-black uppercase text-slate-500 tracking-[0.2em] px-4 pt-4 mb-2">Management</p>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-4 py-3 bg-blue-600 text-white shadow-lg shadow-blue-900/20 rounded-xl font-bold transition duration-150">
                        <svg class="h-5 w-5 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <span>Manajemen User</span>
                    </a>

                    <p class="text-[10px] font-black uppercase text-slate-500 tracking-[0.2em] px-4 pt-4 mb-2">Lowongan</p>
                    <a href="{{ route('jobs.create') }}" class="flex items-center space-x-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl font-bold transition duration-150">
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

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b border-slate-200 min-h-16 flex items-center justify-between px-6 z-30 shadow-sm sticky top-0">
                <h2 class="text-lg font-black text-slate-900 tracking-tight uppercase">User Management</h2>
            </header>

            <main class="flex-1 overflow-y-auto p-6 space-y-6">
                @if (session('status'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-2xl shadow-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="glass-card">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h4 class="font-black text-slate-800 text-sm tracking-tight uppercase">Daftar Pengguna Sistem</h4>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400 tracking-widest border-b border-slate-100">
                                <tr>
                                    <th class="p-4">Nama Pengguna</th>
                                    <th class="p-4">Email / HP</th>
                                    <th class="p-4">Role</th>
                                    <th class="p-4 text-center">Aktivitas</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-bold text-slate-700">
                                @foreach($users as $user)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="p-4 font-black text-slate-900">{{ $user->name }}</td>
                                        <td class="p-4 font-medium text-slate-500">
                                            {{ $user->email }} <br>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $user->phone_number }}</span>
                                        </td>
                                        <td class="p-4">
                                            <span class="px-2 py-0.5 rounded-lg border {{ $user->role === 'admin' ? 'bg-red-50 text-red-600 border-red-100' : ($user->role === 'company' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-slate-100 text-slate-400') }}">
                                                {{ strtoupper($user->role) }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-center">
                                            <span class="text-[10px] text-slate-400 font-black uppercase">App: {{ $user->applications_count }}</span>
                                        </td>
                                        <td class="p-4 text-center space-x-2">
                                            @if($user->id !== Auth::id())
                                                <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800 uppercase text-[9px] font-black tracking-widest">Edit</a>
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline-block" onsubmit="return confirm('Hapus user ini selamanya?')">
                                                    @csrf @method('DELETE')
                                                    <button class="text-red-500 hover:text-red-700 uppercase text-[9px] font-black tracking-widest">Delete</button>
                                                </form>
                                            @else
                                                <span class="text-slate-300 italic">- You -</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 border-t border-slate-100">
                        {{ $users->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
