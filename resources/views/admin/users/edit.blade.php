<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Edit Pengguna</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-blue-600 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <h1 class="text-lg font-black text-slate-900 tracking-tight uppercase">Edit Data Pengguna</h1>
            </div>
            <x-partials.logo size="sm" :withText="false" />
        </header>

        <main class="flex-1 max-w-2xl mx-auto w-full p-6">
            <div class="glass-card p-8 bg-white">
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6" x-data="{ busy: false }" @submit="busy = true">
                    @csrf @method('PUT')

                    <div class="space-y-1">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                        @error('name') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                            @error('email') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nomor HP</label>
                            <input type="tel" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                            @error('phone_number') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Role Pengguna</label>
                        <select name="role" required class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                            <option value="applicant" {{ $user->role === 'applicant' ? 'selected' : '' }}>Applicant (Alumni/Public)</option>
                            <option value="company" {{ $user->role === 'company' ? 'selected' : '' }}>Company (Employer)</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>System Administrator</option>
                        </select>
                        @error('role') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-6 border-t border-slate-100 space-y-6">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Ganti Password (Kosongkan jika tidak ingin mengubah)</p>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kata Sandi Baru</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter"
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition">
                            @error('password') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <button type="submit" :disabled="busy"
                        class="w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg hover:bg-blue-700 transition-all text-sm uppercase tracking-widest">
                        <span x-show="!busy">Update Data User</span>
                        <span x-show="busy">Memproses...</span>
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
