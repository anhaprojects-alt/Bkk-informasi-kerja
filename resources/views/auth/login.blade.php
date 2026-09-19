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
    <div class="auth-shell">
        <div class="auth-container min-h-screen md:min-h-[auto] flex flex-col p-8 relative">

            <!-- Header Controls & Logo -->
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
                <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Selamat Datang Kembali</h1>
                <p class="text-sm text-slate-500 font-medium">Tetap terhubung dengan komunitas profesional Anda.</p>
            </div>

            <!-- Form Card -->
            <form method="POST" action="{{ route('login.post') }}" class="space-y-6"
                x-data="{ busy: false, showPassword: false }" @submit="busy = true">
                @csrf

                @if (session('status'))
                    <div role="status" class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl shadow-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Email Field -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-black uppercase tracking-widest text-slate-400">Email</label>
                    <input type="email" name="email" id="email" required autofocus
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        class="block w-full px-4 py-4 bg-white border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 shadow-sm transition duration-150">
                    @error('email')
                        <p class="mt-1.5 text-xs font-bold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label for="password" class="block text-xs font-black uppercase tracking-widest text-slate-400">Kata Sandi</label>
                    </div>
                    <div class="relative group">
                        <input :type="showPassword ? 'text' : 'password'" type="password" name="password" id="password" required
                            placeholder="••••••••"
                            class="block w-full px-4 py-4 bg-white border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 shadow-sm transition duration-150">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-slate-600">
                            <span class="text-xs font-bold uppercase tracking-tighter" x-text="showPassword ? 'Sembunyi' : 'Lihat'"></span>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs font-bold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('password.request') }}" class="text-xs font-black text-blue-600 hover:text-blue-700 uppercase tracking-widest transition">Lupa Sandi?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" :disabled="busy"
                    class="w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all disabled:opacity-50">
                    <span x-show="!busy">Masuk Sekarang</span>
                    <span x-show="busy" x-cloak>Memproses...</span>
                </button>
            </form>

            <!-- Footer Links -->
            <div class="mt-12 text-center pt-8 border-t border-slate-100">
                <p class="text-sm text-slate-500 font-medium">Baru di BKK? <a href="{{ route('register') }}" class="font-black text-blue-600 hover:text-blue-700 transition">Gabung Sekarang</a></p>
            </div>

        </div>
    </div>
</body>
</html>
