<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="Daftar akun BKK untuk melamar lowongan kerja atau memasang informasi lowongan sebagai perusahaan.">
    <meta name="theme-color" content="#1e40af">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="manifest" href="/manifest.json">
    <title>BKK - Bergabung dengan Jaringan Karir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800 pwa-optimized">
    <div class="auth-shell">
        <div class="auth-container min-h-screen md:min-h-[auto] flex flex-col p-8 relative">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('introduction') }}" aria-label="Kembali ke halaman awal"
                    class="inline-flex items-center justify-center p-3 bg-white border border-slate-200/70 rounded-xl text-slate-600 hover:text-blue-600 shadow-sm border-b-2 active:border-b-0 active:translate-y-[2px] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <x-partials.logo size="sm" :withText="false" />
            </div>

            <div class="space-y-1 mb-8">
                <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Buat Akun Anda</h1>
                <p class="text-sm text-slate-500 font-medium">Lengkapi langkah awal menuju karir impian.</p>
            </div>

            <!-- Form Card -->
            <form method="POST" action="{{ route('register.post') }}" class="space-y-5"
                x-data="{ busy: false, showPassword: false }" @submit="busy = true">
                @csrf

                <!-- Name -->
                <div class="space-y-1">
                    <label for="name" class="block text-xs font-black uppercase tracking-widest text-slate-400">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required
                        value="{{ old('name') }}"
                        placeholder="Budi Santoso"
                        class="block w-full px-4 py-3.5 bg-white border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition duration-150">
                    @error('name')
                        <p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label for="email" class="block text-xs font-black uppercase tracking-widest text-slate-400">Alamat Email</label>
                    <input type="email" name="email" id="email" required
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        class="block w-full px-4 py-3.5 bg-white border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition duration-150">
                    @error('email')
                        <p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="space-y-1">
                    <label for="phone_number" class="block text-xs font-black uppercase tracking-widest text-slate-400">Nomor HP</label>
                    <input type="tel" name="phone_number" id="phone_number" required
                        value="{{ old('phone_number') }}"
                        placeholder="081234567890"
                        class="block w-full px-4 py-3.5 bg-white border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition duration-150">
                    @error('phone_number')
                        <p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="space-y-1">
                    <label for="role" class="block text-xs font-black uppercase tracking-widest text-slate-400">Daftar Sebagai</label>
                    <select name="role" id="role" required
                        class="block w-full px-4 py-3.5 bg-white border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition duration-150 appearance-none">
                        <option value="applicant">Alumni / Pencari Kerja</option>
                        <option value="company">Perusahaan Mitra</option>
                    </select>
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <label for="password" class="block text-xs font-black uppercase tracking-widest text-slate-400">Kata Sandi</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" type="password" name="password" id="password" required
                            placeholder="Minimal 8 karakter"
                            class="block w-full px-4 py-3.5 bg-white border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition duration-150">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-slate-600">
                            <span class="text-xs font-bold uppercase tracking-tighter" x-text="showPassword ? 'Sembunyi' : 'Lihat'"></span>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" :disabled="busy"
                    class="w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all disabled:opacity-50 mt-4">
                    <span x-show="!busy">Bergabung Sekarang</span>
                    <span x-show="busy" x-cloak>Memproses...</span>
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-8 text-center pt-8 border-t border-slate-100">
                <p class="text-sm text-slate-500 font-medium">Sudah punya akun? <a href="{{ route('login') }}" class="font-black text-blue-600 hover:text-blue-700 transition">Masuk di Sini</a></p>
            </div>

        </div>
    </div>
</body>
</html>
