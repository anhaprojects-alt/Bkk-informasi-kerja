<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="Masuk ke akun BKK untuk mengakses informasi lowongan kerja terbaru bagi alumni dan pencari kerja.">
    <meta name="theme-color" content="#1e40af">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <title>BKK - Masuk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-slate-50 flex flex-col justify-between p-6 shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-x border-slate-200/50">

        <!-- Header Controls & Logo -->
        <div class="mt-2">
            <div class="flex items-center justify-between">
                <a href="{{ route('introduction') }}" aria-label="Kembali ke halaman awal"
                    class="inline-flex items-center justify-center p-3 bg-white border border-slate-200/70 rounded-xl text-slate-600 hover:text-blue-600 shadow-sm border-b-2 active:border-b-0 active:translate-y-[2px] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <x-partials.logo size="sm" :withText="false" />
            </div>

            <div class="mt-6 space-y-1">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Selamat Datang Kembali!</h1>
                <p class="text-sm text-slate-500 font-medium">Silakan masuk untuk mengakses info lowongan kerja terbaru.</p>
            </div>
        </div>

        <!-- Form Card (3D Floating Box) -->
        <form method="POST" action="{{ route('login.post') }}" class="my-auto space-y-5 bg-white p-5 rounded-3xl border border-slate-200/60 shadow-[0_10px_30px_rgba(0,0,0,0.04)]"
            x-data="{ busy: false, showPassword: false }" @submit="busy = true">
            @csrf

            @if (session('status'))
                <div role="status" class="p-3.5 bg-gradient-to-r from-emerald-50 to-emerald-100/50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Email Field -->
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Alamat Email</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-blue-600 transition" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <input type="email" name="email" id="email" required autofocus
                        value="{{ old('email') }}"
                        autocomplete="email" inputmode="email" autocapitalize="none" spellcheck="false"
                        placeholder="nama@email.com"
                        @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                        class="block w-full pl-12 pr-4 py-3.5 bg-slate-50/80 border rounded-2xl text-sm focus:outline-none focus:bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] focus:shadow-none transition duration-150 @error('email') border-red-300 focus:ring-2 focus:ring-red-100 @else border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror">
                </div>
                @error('email')
                    <p id="email-error" class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="space-y-1.5">
                <div class="flex justify-between items-center">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Kata Sandi</label>
                    <a href="{{ route('password.request') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition">Lupa Sandi?</a>
                </div>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-blue-600 transition" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <input :type="showPassword ? 'text' : 'password'" type="password" name="password" id="password" required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                        class="block w-full pl-12 pr-12 py-3.5 bg-slate-50/80 border rounded-2xl text-sm focus:outline-none focus:bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] focus:shadow-none transition duration-150 @error('password') border-red-300 focus:ring-2 focus:ring-red-100 @else border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror">
                    <button type="button" @click="showPassword = !showPassword"
                        :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                        :aria-pressed="showPassword ? 'true' : 'false'"
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-slate-600 transition">
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p id="password-error" class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button (Tactile 3D Action Style) -->
            <button type="submit" :disabled="busy" :aria-busy="busy ? 'true' : 'false'"
                class="w-full py-4 px-6 bg-gradient-to-b from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-bold text-center rounded-2xl shadow-[0_8px_20px_rgba(29,78,216,0.25)] border-b-4 border-blue-900 active:border-b-0 active:translate-y-[4px] transition-all duration-150 disabled:opacity-60 disabled:cursor-not-allowed">
                <span x-show="!busy">Masuk Sekarang</span>
                <span x-show="busy" x-cloak>Memproses…</span>
            </button>
        </form>

        <!-- Footer Links -->
        <div class="mb-4 text-center">
            <p class="text-sm text-slate-500 font-medium">Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700 transition">Daftar di Sini</a></p>
        </div>

    </div>
</body>
</html>
