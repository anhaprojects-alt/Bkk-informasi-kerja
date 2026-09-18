<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKK - Masuk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-white flex flex-col justify-between p-6 shadow-xl">

        <!-- Header -->
        <div class="mt-4">
            <a href="{{ route('introduction') }}" class="inline-flex items-center justify-center p-2 bg-slate-100 rounded-xl text-slate-600 hover:bg-slate-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="mt-6">
                <h2 class="text-2xl font-bold text-slate-900">Selamat Datang Kembali!</h2>
                <p class="text-sm text-slate-500 mt-1">Silakan masuk untuk mengakses info lowongan kerja terbaru.</p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login.post') }}" class="my-auto space-y-4">
            @csrf

            @if ($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <input type="email" name="email" required placeholder="nama@email.com" class="block w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition duration-150">
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Kata Sandi</label>
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Lupa Sandi?</a>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <input type="password" name="password" required placeholder="••••••••" class="block w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition duration-150">
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-center rounded-xl shadow-lg shadow-indigo-100 transition duration-200 mt-2">
                Masuk Sekarang
            </button>
        </form>

        <!-- Footer -->
        <div class="mb-4 text-center">
            <p class="text-sm text-slate-500">Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Daftar di Sini</a></p>
        </div>

    </div>
</body>
</html>
