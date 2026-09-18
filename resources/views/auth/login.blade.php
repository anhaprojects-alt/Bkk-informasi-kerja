<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk ke akun BKK untuk mengakses informasi lowongan kerja terbaru bagi alumni dan pencari kerja.">
    <meta name="theme-color" content="#4f46e5">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <title>BKK - Masuk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-white flex flex-col justify-between p-6 shadow-xl">

        <!-- Header -->
        <div class="mt-4">
            <a href="{{ route('introduction') }}" aria-label="Kembali ke halaman awal"
                class="inline-flex items-center justify-center p-2 bg-slate-100 rounded-xl text-slate-600 hover:bg-slate-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="mt-6">
                <h1 class="text-2xl font-bold text-slate-900">Selamat Datang Kembali!</h1>
                <p class="text-sm text-slate-500 mt-1">Silakan masuk untuk mengakses info lowongan kerja terbaru.</p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login.post') }}" class="my-auto space-y-4"
            x-data="{ busy: false, showPassword: false }" @submit="busy = true">
            @csrf

            @if (session('status'))
                <div role="status" class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl">
                    {{ session('status') }}
                </div>
            @endif

            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <input type="email" name="email" id="email" required autofocus
                        value="{{ old('email') }}"
                        autocomplete="email" inputmode="email" autocapitalize="none" spellcheck="false"
                        placeholder="nama@email.com"
                        @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                        class="block w-full pl-11 pr-4 py-3 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:bg-white transition duration-150 @error('email') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-indigo-500 @enderror">
                </div>
                @error('email')
                    <p id="email-error" class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Kata Sandi</label>
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Lupa Sandi?</a>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <input :type="showPassword ? 'text' : 'password'" type="password" name="password" id="password" required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                        class="block w-full pl-11 pr-12 py-3 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:bg-white transition duration-150 @error('password') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-indigo-500 @enderror">
                    <button type="button" @click="showPassword = !showPassword"
                        :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                        :aria-pressed="showPassword ? 'true' : 'false'"
                        class="absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400 hover:text-slate-600 transition">
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p id="password-error" class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" :disabled="busy" :aria-busy="busy ? 'true' : 'false'"
                class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-center rounded-xl shadow-lg shadow-indigo-100 transition duration-200 mt-2 disabled:opacity-60 disabled:cursor-not-allowed">
                <span x-show="!busy">Masuk Sekarang</span>
                <span x-show="busy" x-cloak>Memproses…</span>
            </button>
        </form>

        <!-- Footer -->
        <div class="mb-4 text-center">
            <p class="text-sm text-slate-500">Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Daftar di Sini</a></p>
        </div>

    </div>
</body>
</html>
