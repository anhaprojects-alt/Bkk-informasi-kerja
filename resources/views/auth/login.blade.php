<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="Masuk ke akun BKK untuk mengakses informasi lowongan kerja terbaru bagi alumni dan pencari kerja.">
    <meta name="theme-color" content="#1e40af">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="manifest" href="/manifest.json">
    <title>BKK - Masuk ke Akun Profesional</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800 pwa-optimized">
    <div class="auth-shell p-6 md:p-0">
        <div class="auth-container">

            <!-- Header Controls & Logo -->
            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('introduction') }}" aria-label="Kembali ke halaman awal"
                    class="inline-flex items-center justify-center p-2 bg-white border border-slate-200/70 rounded-lg text-slate-600 hover:text-blue-600 shadow-sm border-b-2 active:border-b-0 active:translate-y-[2px] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <x-partials.logo size="sm" :withText="false" />
            </div>

            <div class="space-y-1 mb-6 text-center md:text-left">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">Selamat Datang Kembali</h1>
                <p class="text-xs font-medium text-slate-500">Tetap terhubung dengan komunitas profesional Anda.</p>
            </div>

            <!-- Form Card -->
            <form method="POST" action="{{ route('login.post') }}" class="space-y-4"
                x-data="{ busy: false, showPassword: false }" @submit="busy = true">
                @csrf

                @if (session('status'))
                    <div role="status" class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-[11px] font-bold rounded-lg shadow-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Email Field -->
                <div class="space-y-1">
                    <label for="email" class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Email</label>
                    <input type="email" name="email" id="email" required autofocus
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        class="block w-full px-3 py-2.5 bg-white border-2 border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-600 shadow-sm transition duration-150">
                    @error('email')
                        <p class="mt-1 text-[10px] font-bold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-1">
                    <div class="flex justify-between items-center">
                        <label for="password" class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kata Sandi</label>
                    </div>
                    <div class="relative group">
                        <input :type="showPassword ? 'text' : 'password'" type="password" name="password" id="password" required
                            placeholder="••••••••"
                            class="block w-full px-3 py-2.5 bg-white border-2 border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-600 shadow-sm transition duration-150">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 hover:text-slate-600">
                            <span class="text-[10px] font-bold uppercase tracking-tighter" x-text="showPassword ? 'Sembunyi' : 'Lihat'"></span>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-[10px] font-bold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('password.request') }}" class="text-[10px] font-black text-blue-600 hover:text-blue-700 uppercase tracking-widest transition">Lupa Sandi?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" :disabled="busy"
                    class="w-full py-3 bg-blue-600 text-white font-black rounded-full shadow-md shadow-blue-100 hover:bg-blue-700 transition-all disabled:opacity-50 text-sm">
                    <span x-show="!busy">Masuk Sekarang</span>
                    <span x-show="busy" x-cloak>Memproses...</span>
                </button>
            </form>

            <!-- Footer Links -->
            <div class="mt-8 text-center pt-6 border-t border-slate-100">
                <p class="text-xs text-slate-500 font-medium">Baru di BKK? <a href="{{ route('register') }}" class="font-black text-blue-600 hover:text-blue-700 transition">Gabung Sekarang</a></p>
            </div>

        </div>
    </div>
</body>
</html>
