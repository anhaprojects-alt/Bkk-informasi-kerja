<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="BKK - Bursa Kerja Khusus. Akses informasi lowongan kerja terpercaya untuk alumni dan pencari kerja.">
    <meta name="theme-color" content="#1e40af">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <title>BKK - Selamat Datang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-slate-50 flex flex-col justify-between p-6 shadow-[0_20px_50px_rgba(0,0,0,0.15)] relative overflow-hidden border-x border-slate-200/50">
        <!-- 3D Abstract Spheres / Background Decor -->
        <div aria-hidden="true" class="absolute -top-16 -right-16 w-48 h-48 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full opacity-20 shadow-[inset_-10px_-10px_20px_rgba(0,0,0,0.2),0_15px_30px_rgba(30,64,175,0.2)]"></div>
        <div aria-hidden="true" class="absolute top-1/2 -left-20 w-36 h-36 bg-gradient-to-br from-amber-300 to-amber-500 rounded-full opacity-20 shadow-[inset_-10px_-10px_20px_rgba(0,0,0,0.2),0_15px_30px_rgba(245,158,11,0.2)]"></div>

        <!-- Header / Logo -->
        <div class="mt-6 z-10">
            <x-partials.logo size="sm" :withText="true" />
        </div>

        <!-- Main Content (Premium 3D Presentation) -->
        <div class="my-auto text-center px-2 z-10 space-y-8">
            <!-- 3D Hero Display Box -->
            <div aria-hidden="true" class="relative w-60 h-60 mx-auto bg-gradient-to-b from-white to-slate-100 rounded-3xl shadow-[0_15px_35px_rgba(0,0,0,0.08),inset_0_2px_4px_rgba(255,255,255,1)] border border-slate-200/60 flex items-center justify-center group transform transition duration-500 hover:rotate-1">
                <!-- Inner Float Card -->
                <div class="absolute -top-4 -right-4 p-4 bg-white shadow-[0_10px_25px_rgba(0,0,0,0.08)] border border-slate-100 rounded-2xl text-amber-500 transform transition duration-300 group-hover:translate-y-[-4px]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 drop-shadow-[0_2px_4px_rgba(245,158,11,0.3)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>

                <!-- Center High-Quality 3D Icon Presentation -->
                <div class="p-1 bg-slate-200/50 rounded-full shadow-[inset_0_2px_5px_rgba(0,0,0,0.05)]">
                    <x-partials.logo size="xl" :withText="false" />
                </div>

                <!-- Verified Badge Floating -->
                <div class="absolute -bottom-4 -left-4 p-3.5 bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-[0_10px_20px_rgba(16,185,129,0.3)] rounded-2xl text-white transform transition duration-300 group-hover:translate-y-[4px]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Typography & Headlines -->
            <div class="space-y-3">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">
                    Raih Karir Impianmu <br>
                    <span class="bg-gradient-to-r from-blue-700 to-indigo-600 bg-clip-text text-transparent drop-shadow-[0_2px_10px_rgba(30,64,175,0.1)]">
                        Lebih Cepat & Professional
                    </span>
                </h1>
                <p class="text-slate-500 text-sm leading-relaxed px-4">
                    Bursa Kerja Khusus memberikan akses eksklusif informasi lowongan kerja terpercaya bagi alumni dan publik secara profesional.
                </p>
            </div>
        </div>

        <!-- Action Buttons (Tactile 3D Action Style) -->
        <div class="space-y-4 mb-4 z-10">
            <a href="{{ route('login') }}"
               class="block w-full py-4 px-6 bg-gradient-to-b from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-bold text-center rounded-2xl shadow-[0_8px_20px_rgba(29,78,216,0.3)] border-b-4 border-blue-900 active:border-b-0 active:translate-y-[4px] transition-all duration-150">
                Masuk ke Akun
            </a>
            <a href="{{ route('register') }}"
               class="block w-full py-4 px-6 bg-white hover:bg-slate-50 text-slate-700 font-bold text-center rounded-2xl shadow-[0_8px_16px_rgba(0,0,0,0.04)] border border-slate-200/80 border-b-4 border-slate-300/80 active:border-b-0 active:translate-y-[4px] transition-all duration-150">
                Daftar Publik Baru
            </a>
        </div>
    </div>
</body>
</html>
