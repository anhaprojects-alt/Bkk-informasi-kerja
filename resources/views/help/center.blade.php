<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Pusat Bantuan & FAQ Terpadu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <a href="{{ url()->previous() }}" class="text-slate-500 hover:text-blue-600 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <h1 class="text-lg font-black text-slate-900 tracking-tight uppercase">Pusat Bantuan</h1>
            </div>
            <x-partials.logo size="sm" :withText="false" />
        </header>

        <main class="flex-1 max-w-5xl mx-auto w-full p-6 space-y-8 pb-24">

            <!-- Professional Hero -->
            <div class="glass-card p-12 bg-gradient-to-br from-slate-900 to-blue-900 text-white relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-blue-600/20 rounded-full blur-3xl -mr-32 -mt-32"></div>
                <div class="relative z-10 space-y-6">
                    <h2 class="text-4xl font-black tracking-tight leading-tight">Solusi Cepat untuk <br>Karir Profesional Anda.</h2>
                    <p class="text-blue-100 font-medium max-w-xl leading-relaxed">Selamat datang di pusat dukungan BKK. Temukan jawaban instan untuk kendala teknis, informasi akun, hingga panduan rekrutmen yang efektif.</p>

                    <div class="flex flex-wrap gap-4 pt-4">
                        <div class="flex items-center gap-2 bg-white/10 backdrop-blur px-4 py-2 rounded-full border border-white/10 text-xs font-bold">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                            System Status: Operational
                        </div>
                        <div class="flex items-center gap-2 bg-white/10 backdrop-blur px-4 py-2 rounded-full border border-white/10 text-xs font-bold">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Response Time: < 1 Hour
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- FAQ Section -->
                <div class="md:col-span-2 space-y-8">
                    <div class="space-y-2">
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs border-l-4 border-blue-600 pl-3">Top Questions</h3>
                        <p class="text-xs text-slate-400 font-bold px-4 uppercase">Pertanyaan yang paling sering ditanyakan</p>
                    </div>

                    <div class="space-y-4" x-data="{ active: null }">
                        <!-- Q1 -->
                        <div class="glass-card bg-white transition-all overflow-hidden border-slate-200/60 hover:border-blue-300">
                            <button @click="active = (active === 1 ? null : 1)" class="w-full p-6 flex items-center justify-between text-left focus:outline-none group">
                                <span class="font-black text-slate-700 text-sm group-hover:text-blue-600 transition-colors">Bagaimana cara mengunggah CV agar terlihat profesional?</span>
                                <div class="bg-slate-50 p-1 rounded-lg">
                                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-300" :class="active === 1 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </button>
                            <div x-show="active === 1" x-cloak x-collapse class="px-6 pb-6 text-sm text-slate-500 leading-relaxed border-t border-slate-50 pt-5">
                                Anda dapat masuk ke menu **Me (Profil)** > **Pengaturan Akun**. Kami sangat menyarankan mengunggah file dalam format **PDF** agar tata letak tidak berubah saat dilihat oleh HRD. Gunakan fitur **Smart Preview** di dashboard untuk memastikan dokumen terbaca dengan jelas.
                            </div>
                        </div>

                        <!-- Q2 -->
                        <div class="glass-card bg-white transition-all overflow-hidden border-slate-200/60 hover:border-blue-300">
                            <button @click="active = (active === 2 ? null : 2)" class="w-full p-6 flex items-center justify-between text-left focus:outline-none group">
                                <span class="font-black text-slate-700 text-sm group-hover:text-blue-600 transition-colors">Data saya akan dibagikan ke siapa saja?</span>
                                <div class="bg-slate-50 p-1 rounded-lg">
                                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-300" :class="active === 2 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </button>
                            <div x-show="active === 2" x-cloak x-collapse class="px-6 pb-6 text-sm text-slate-500 leading-relaxed border-t border-slate-50 pt-5">
                                Keamanan privasi Anda adalah prioritas kami. Data profil dan CV Anda **hanya akan dibagikan** kepada perusahaan mitra secara resmi jika Anda melamar lowongan tersebut. Admin BKK juga dapat memantau data untuk proses verifikasi kredibilitas akun.
                            </div>
                        </div>

                        <!-- Q3 -->
                        <div class="glass-card bg-white transition-all overflow-hidden border-slate-200/60 hover:border-blue-300">
                            <button @click="active = (active === 3 ? null : 3)" class="w-full p-6 flex items-center justify-between text-left focus:outline-none group">
                                <span class="font-black text-slate-700 text-sm group-hover:text-blue-600 transition-colors">Bagaimana sistem chat antara pelamar dan perusahaan?</span>
                                <div class="bg-slate-50 p-1 rounded-lg">
                                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-300" :class="active === 3 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </button>
                            <div x-show="active === 3" x-cloak x-collapse class="px-6 pb-6 text-sm text-slate-500 leading-relaxed border-t border-slate-50 pt-5">
                                Setelah melamar, perusahaan dapat memulai percakapan melalui fitur **Messaging**. Anda akan mendapatkan notifikasi saat ada pesan masuk. Gunakan fitur ini secara profesional untuk konsultasi jadwal wawancara atau menanyakan detail lebih lanjut mengenai posisi tersebut.
                            </div>
                        </div>
                    </div>

                    <!-- Additional Help Links -->
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('privacy') }}" class="glass-card p-6 bg-slate-50 hover:bg-white transition-colors border-dashed text-center space-y-2 group">
                            <h4 class="font-black text-slate-800 text-xs uppercase tracking-widest group-hover:text-blue-600 transition-colors">Privacy Policy</h4>
                            <p class="text-[10px] text-slate-400 font-bold uppercase leading-tight">Detail pengelolaan data Anda</p>
                        </a>
                        <a href="{{ route('about') }}" class="glass-card p-6 bg-slate-50 hover:bg-white transition-colors border-dashed text-center space-y-2 group">
                            <h4 class="font-black text-slate-800 text-xs uppercase tracking-widest group-hover:text-blue-600 transition-colors">About BKK</h4>
                            <p class="text-[10px] text-slate-400 font-bold uppercase leading-tight">Visi & Misi Jaringan Karir</p>
                        </a>
                    </div>
                </div>

                <!-- Support Sidebar -->
                <div class="space-y-8">
                    <div class="space-y-2">
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs border-l-4 border-blue-600 pl-3">Hubungi Kami</h3>
                        <p class="text-xs text-slate-400 font-bold px-4 uppercase">Bantuan Langsung Profesional</p>
                    </div>

                    <!-- Direct Chat Widget -->
                    <div class="glass-card p-8 bg-white space-y-6 shadow-xl shadow-blue-900/5 relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 opacity-5">
                            <svg class="h-24 w-24" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.752 2 11.44 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" /></svg>
                        </div>
                        <div class="w-14 h-14 bg-blue-50 rounded-3xl flex items-center justify-center text-blue-600 shadow-inner border border-blue-100">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        </div>
                        <div class="space-y-2">
                            <h4 class="font-black text-slate-900 text-lg">BKK Messaging</h4>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed">Ada kendala teknis atau butuh konsultasi karir? Tim support kami siap membantu Anda secara real-time.</p>
                        </div>
                        <a href="{{ route('messages.index') }}" class="block w-full py-4 bg-blue-600 text-white text-center rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all hover:scale-[1.02] active:scale-[0.98]">Buka Pesan Sekarang</a>
                    </div>

                    <!-- Email Support -->
                    <div class="glass-card p-6 bg-slate-900 text-white border-none space-y-4">
                        <p class="text-[9px] font-black uppercase text-blue-400 tracking-[0.3em]">Official Support</p>
                        <div class="space-y-1">
                            <p class="text-sm font-black">support@bkk-karir.test</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Estimasi Balasan: 24 Jam Kerja</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="bg-white border-t border-slate-100 py-8 px-6 text-center">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">&copy; 2026 BKK Informasi Kerja - Empowerment Hub</p>
        </footer>
    </div>
</body>
</html>
