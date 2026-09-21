<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Tentang Kami</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-slate-500 hover:text-blue-600 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <h1 class="text-lg font-black text-slate-900 tracking-tight uppercase">Tentang BKK</h1>
            </div>
            <x-partials.logo size="sm" :withText="false" />
        </header>

        <main class="flex-1 max-w-4xl mx-auto w-full p-6 space-y-12 pb-24">
            <!-- Hero Section -->
            <section class="text-center space-y-6 pt-8">
                <div class="inline-flex p-4 bg-blue-50 rounded-3xl border border-blue-100 shadow-sm mb-4">
                    <x-partials.logo size="lg" :withText="false" />
                </div>
                <h2 class="text-4xl font-black text-blue-900 tracking-tight leading-tight">Menghubungkan Potensi <br>dengan Peluang Tanpa Batas.</h2>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed font-medium">BKK Informasi Kerja adalah platform digital revolusioner yang dirancang khusus untuk menjembatani kesenjangan antara dunia pendidikan dan dunia industri.</p>
            </section>

            <!-- Mission & Vision -->
            <div class="grid md:grid-cols-2 gap-8">
                <div class="glass-card p-8 bg-white space-y-4 border-b-4 border-blue-600">
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                        Misi Kami
                    </h3>
                    <p class="text-slate-600 leading-relaxed font-medium">Memberdayakan setiap alumni dan pencari kerja dengan alat profesional untuk membangun profil yang kuat dan menemukan karir yang sesuai dengan aspirasi mereka.</p>
                </div>
                <div class="glass-card p-8 bg-white space-y-4 border-b-4 border-emerald-500">
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-emerald-500 rounded-full"></span>
                        Visi Kami
                    </h3>
                    <p class="text-slate-600 leading-relaxed font-medium">Menjadi ekosistem karir terintegrasi yang paling terpercaya di Indonesia dalam mendukung transisi mulus dari pendidikan tinggi ke dunia profesional.</p>
                </div>
            </div>

            <!-- Features Section -->
            <section class="space-y-8">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs border-l-4 border-blue-600 pl-3">Mengapa Memilih BKK?</h3>
                <div class="grid sm:grid-cols-3 gap-6">
                    <div class="space-y-3">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </div>
                        <h4 class="font-black text-slate-900 text-sm">Terpercaya</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Seluruh perusahaan mitra telah melalui proses verifikasi ketat oleh tim administrator BKK.</p>
                    </div>
                    <div class="space-y-3">
                        <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <h4 class="font-black text-slate-900 text-sm">Cepat & Efisien</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Alur pendaftaran lowongan yang instan, memangkas birokrasi tradisional dalam melamar pekerjaan.</p>
                    </div>
                    <div class="space-y-3">
                        <div class="w-10 h-10 bg-amber-500 text-white rounded-xl flex items-center justify-center shadow-lg shadow-amber-200">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" /></svg>
                        </div>
                        <h4 class="font-black text-slate-900 text-sm">Komunikasi Langsung</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Fitur pesan yang memungkinkan interaksi langsung antara pelamar dan pihak rekrutmen perusahaan.</p>
                    </div>
                </div>
            </section>

            <!-- Bottom CTA -->
            <section class="bg-slate-900 rounded-[3rem] p-12 text-center space-y-8 relative overflow-hidden shadow-2xl">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" fill="white"><circle cx="20" cy="20" r="10" /><circle cx="80" cy="80" r="15" /></svg>
                </div>
                <div class="relative z-10 space-y-4">
                    <h3 class="text-2xl font-black text-white">Siap Memulai Perjalanan Karir Anda?</h3>
                    <p class="text-slate-400 text-sm max-w-sm mx-auto">Bergabunglah dengan ribuan alumni lain yang telah menemukan jalan sukses mereka melalui BKK.</p>
                    <div class="pt-4">
                        <a href="{{ route('register') }}" class="inline-block px-10 py-4 bg-blue-600 text-white font-black rounded-full shadow-lg hover:bg-blue-700 transition-all uppercase tracking-widest text-xs">Bergabung Sekarang</a>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer Footer -->
        <footer class="bg-white border-t border-slate-100 py-8 px-6 text-center">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">&copy; 2026 BKK Informasi Kerja - Jaringan Karir Masa Depan</p>
        </footer>
    </div>
</body>
</html>
