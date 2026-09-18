<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BKK - Bursa Kerja Khusus. Akses informasi lowongan kerja terpercaya untuk alumni dan pencari kerja.">
    <meta name="theme-color" content="#4f46e5">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <title>BKK - Selamat Datang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-white flex flex-col justify-between p-6 shadow-xl relative overflow-hidden">
        <!-- Top Decorative Circle -->
        <div aria-hidden="true" class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-500 rounded-full opacity-10"></div>
        <div aria-hidden="true" class="absolute -top-12 -left-12 w-32 h-32 bg-sky-500 rounded-full opacity-10"></div>

        <!-- Header / Logo -->
        <div class="flex items-center space-x-2 mt-8 z-10">
            <div class="p-2 bg-indigo-600 rounded-xl shadow-md text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="text-xl font-bold tracking-wider text-indigo-900">BKK Mobile</span>
        </div>

        <!-- Main Content -->
        <div class="my-auto text-center px-4 z-10">
            <div aria-hidden="true" class="w-64 h-64 mx-auto mb-8 bg-indigo-50 rounded-full flex items-center justify-center relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-40 w-40 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" focusable="false">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
                <div class="absolute bottom-4 right-4 p-3 bg-white shadow-lg rounded-full text-emerald-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" focusable="false">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mb-3">
                Raih Karir Impianmu <br><span class="text-indigo-600">Lebih Cepat & Mudah</span>
            </h1>
            <p class="text-slate-500 text-sm leading-relaxed">
                Bursa Kerja Khusus memberikan akses eksklusif informasi lowongan kerja terpercaya bagi alumni dan publik secara profesional.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3 mb-6 z-10">
            <a href="{{ route('login') }}" class="block w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-center rounded-xl shadow-lg shadow-indigo-100 transition duration-200">
                Masuk ke Akun
            </a>
            <a href="{{ route('register') }}" class="block w-full py-3.5 px-4 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-center rounded-xl transition duration-200">
                Daftar Publik Baru
            </a>
        </div>
    </div>
</body>
</html>
