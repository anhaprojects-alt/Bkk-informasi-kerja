<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Pengaturan Profil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800">
    <div class="min-h-screen flex flex-col">

        <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <a href="{{ Auth::user()->role === 'applicant' ? route('applicant.dashboard') : route('dashboard') }}" class="text-slate-500 hover:text-blue-600 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <h1 class="text-lg font-black text-slate-900 tracking-tight uppercase">Edit Profil Akun</h1>
            </div>
            <x-partials.logo size="sm" :withText="false" />
        </header>

        <main class="flex-1 max-w-3xl mx-auto w-full p-6">
            @if (session('status'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-2xl shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="glass-card p-8 bg-white">
                <form method="POST" action="{{ route('settings.profile.update') }}" enctype="multipart/form-data" class="space-y-6" x-data="{ busy: false }" @submit="busy = true">
                    @csrf @method('PUT')

                    <div class="flex items-center gap-5 pb-6 border-b border-slate-100">
                        <div class="relative">
                            <img src="{{ $user->avatar_url }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-md">
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Foto Profil</p>
                            <input type="file" name="avatar" accept="image/*" class="mt-2 block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 file:font-black">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Banner Latar</label>
                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                            <img src="{{ $user->banner_url }}" alt="Banner" class="h-32 w-full object-cover">
                        </div>
                        <input type="file" name="banner" accept="image/*" class="mt-2 block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-slate-100 file:text-slate-700 file:font-black">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                        @error('name') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Headline Profesional</label>
                        <input type="text" name="headline" value="{{ old('headline', $user->headline) }}" placeholder="Contoh: Laravel Developer | UI Enthusiast"
                            class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                        @error('headline') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Ringkasan / Bio</label>
                        <textarea name="bio" rows="4" placeholder="Ceritakan pengalaman dan target karier Anda..." class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Provinsi</label>
                            <input type="text" name="province" value="{{ old('province', $user->province) }}" placeholder="DKI Jakarta"
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                            @error('province') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kota</label>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="Jakarta Selatan"
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                            @error('city') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Lokasi Detail</label>
                            <input type="text" name="location" value="{{ old('location', $user->location) }}" placeholder="Jakarta Selatan / Remote"
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                            @error('location') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
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

                    <div class="space-y-2 border border-dashed border-slate-200 rounded-2xl p-4 bg-slate-50/40">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Unggah CV / Resume</label>
                        <input type="file" name="cv" accept=".pdf,.doc,.docx" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-indigo-50 file:text-indigo-700 file:font-black">
                        @if ($user->cv_path)
                            <a href="{{ Storage::url($user->cv_path) }}" target="_blank" class="inline-flex items-center text-xs font-black text-blue-600 hover:underline">
                                Lihat CV saat ini: {{ $user->cv_name ?? 'CV.pdf' }}
                            </a>
                        @endif
                        @error('cv') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-6 border-t border-slate-100 space-y-6">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Ubah Kata Sandi (Kosongkan jika tidak ingin mengubah)</p>

                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kata Sandi Baru</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter"
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition">
                            @error('password') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Konfirmasi Sandi Baru</label>
                            <input type="password" name="password_confirmation"
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition">
                        </div>
                    </div>

                    <button type="submit" :disabled="busy"
                        class="w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all text-sm uppercase tracking-widest">
                        <span x-show="!busy">Simpan Perubahan Profil</span>
                        <span x-show="busy">Memproses...</span>
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
