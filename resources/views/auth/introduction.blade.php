<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="BKK - Bursa Kerja Khusus. Akses informasi lowongan kerja terpercaya untuk alumni dan pencari kerja.">
    <meta name="theme-color" content="#1e40af">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="manifest" href="/manifest.json">
    <title>BKK - Selamat Datang di Jaringan Karir Profesional</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased text-slate-800 pwa-optimized">
    <div class="app-shell">
        <!-- Navigation Header -->
        <nav class="bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between sticky top-0 z-50">
            <x-partials.logo size="sm" :withText="true" />
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('jobs.index') }}" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition">Explore Jobs</a>
                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 border-2 border-blue-600 text-blue-600 font-bold rounded-full hover:bg-blue-50 transition text-sm">Bergabung Sekarang</a>
            </div>
        </nav>

        <!-- Main Professional Section -->
        <main class="flex-1 flex flex-col md:flex-row items-center max-w-7xl mx-auto px-6 py-12 md:py-24 gap-12">
            <!-- Left Content: Hero Text -->
            <div class="flex-1 space-y-8 text-center md:text-left">
                <h1 class="text-4xl md:text-6xl font-black text-blue-900 tracking-tight leading-[1.1]">
                    Selamat datang di <br class="hidden md:block">
                    <span class="text-blue-600">komunitas profesional</span> <br class="hidden md:block">
                    alumni & pencari kerja.
                </h1>
                <p class="text-lg md:text-xl text-slate-500 max-w-xl font-medium leading-relaxed">
                    BKK membantu Anda terhubung dengan peluang karir terbaik dari perusahaan mitra terpercaya secara cepat dan profesional.
                </p>

                <!-- Mobile Actions (Hidden on Desktop) -->
                <div class="md:hidden space-y-4 pt-4 px-4">
                    <a href="{{ route('jobs.index') }}" class="block w-full py-4 px-6 bg-blue-600 text-white font-black rounded-full shadow-lg text-lg">Eksplorasi Lowongan</a>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('login') }}" class="block py-3 px-6 border-2 border-slate-200 text-slate-700 font-bold rounded-full text-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="block py-3 px-6 border-2 border-slate-200 text-slate-700 font-bold rounded-full text-sm">Daftar</a>
                    </div>
                </div>
            </div>

            <!-- Right Content: Interactive 3D Visual -->
            <div class="flex-1 relative hidden md:flex justify-center">
                <div class="relative w-full max-w-md aspect-square bg-slate-50 rounded-[4rem] border border-slate-100 shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)] flex items-center justify-center overflow-hidden">
                    <!-- Abstract Background Blur -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-blue-100 rounded-full blur-3xl opacity-50"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-amber-100 rounded-full blur-3xl opacity-50"></div>

                    <!-- Professional Card Float -->
                    <div class="relative z-10 p-12 transform hover:scale-105 transition duration-500 cursor-default select-none">
                        <x-partials.logo size="xl" :withText="false" />
                    </div>

                    <!-- Floating Stats Badge -->
                    <div class="absolute top-12 right-12 bg-white p-4 rounded-2xl shadow-xl border border-slate-50 animate-bounce transition-all duration-1000">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase text-slate-400">Verifikasi</p>
                                <p class="text-sm font-bold text-slate-800">Alumni Terdaftar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer / Sub-text -->
        <footer class="bg-slate-50 border-t border-slate-100 py-12 px-6">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-4">
                    <x-partials.logo size="sm" :withText="false" />
                    <p class="text-sm text-slate-400 font-bold uppercase tracking-widest">&copy; 2026 BKK Informasi Kerja</p>
                </div>
                <div class="flex gap-8 text-sm font-bold text-slate-400">
                    <a href="{{ route('about') }}" class="hover:text-blue-600 transition-colors">Tentang Kami</a>
                    <a href="{{ route('privacy') }}" class="hover:text-blue-600 transition-colors">Kebijakan Privasi</a>
                    <a href="{{ route('help.center') }}" class="hover:text-blue-600 transition-colors">Pusat Bantuan</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
