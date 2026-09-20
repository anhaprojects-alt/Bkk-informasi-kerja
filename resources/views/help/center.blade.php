<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Pusat Bantuan & FAQ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800">
    <div class="min-h-screen flex flex-col">

        <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <a href="{{ url()->previous() }}" class="text-slate-500 hover:text-blue-600 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <h1 class="text-lg font-black text-slate-900 tracking-tight uppercase">Pusat Bantuan</h1>
            </div>
            <x-partials.logo size="sm" :withText="false" />
        </header>

        <main class="flex-1 max-w-4xl mx-auto w-full p-6 space-y-8 pb-24">

            <!-- Hero Help -->
            <div class="glass-card p-10 bg-gradient-to-br from-blue-600 to-indigo-900 text-white text-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 pointer-events-none">
                    <svg class="w-full h-full" viewBox="0 0 100 100" fill="currentColor"><circle cx="50" cy="50" r="40" /></svg>
                </div>
                <div class="relative z-10 space-y-4">
                    <h2 class="text-3xl font-black tracking-tight">Halo, apa yang bisa kami bantu?</h2>
                    <p class="text-blue-100 font-medium max-w-lg mx-auto">Temukan jawaban untuk pertanyaan umum atau hubungi admin/perusahaan langsung melalui fitur pesan kami.</p>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- FAQ Categories -->
                <div class="md:col-span-2 space-y-6">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs border-l-4 border-blue-600 pl-3">Pertanyaan Populer (FAQ)</h3>

                    <div class="space-y-4" x-data="{ active: null }">
                        <!-- Q1 -->
                        <div class="glass-card bg-white transition-all overflow-hidden">
                            <button @click="active = (active === 1 ? null : 1)" class="w-full p-5 flex items-center justify-between text-left focus:outline-none">
                                <span class="font-bold text-slate-700 text-sm">Bagaimana cara mengunggah CV?</span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform" :class="active === 1 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="active === 1" x-cloak class="px-5 pb-5 text-sm text-slate-500 leading-relaxed border-t border-slate-50 pt-4">
                                Anda dapat masuk ke menu **Me (Profil)** > **Pengaturan Akun**. Di bagian bawah form profil terdapat seksi **Unggah CV**. Pastikan file berformat PDF.
                            </div>
                        </div>

                        <!-- Q2 -->
                        <div class="glass-card bg-white transition-all overflow-hidden">
                            <button @click="active = (active === 2 ? null : 2)" class="w-full p-5 flex items-center justify-between text-left focus:outline-none">
                                <span class="font-bold text-slate-700 text-sm">Apakah data saya aman?</span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform" :class="active === 2 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="active === 2" x-cloak class="px-5 pb-5 text-sm text-slate-500 leading-relaxed border-t border-slate-50 pt-4">
                                Tentu. BKK Informasi Kerja menggunakan enkripsi standar industri dan data Anda hanya dibagikan kepada perusahaan mitra saat Anda melamar lowongan.
                            </div>
                        </div>

                        <!-- Q3 -->
                        <div class="glass-card bg-white transition-all overflow-hidden">
                            <button @click="active = (active === 3 ? null : 3)" class="w-full p-5 flex items-center justify-between text-left focus:outline-none">
                                <span class="font-bold text-slate-700 text-sm">Bagaimana cara menghubungi HRD?</span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform" :class="active === 3 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="active === 3" x-cloak class="px-5 pb-5 text-sm text-slate-500 leading-relaxed border-t border-slate-50 pt-4">
                                Anda dapat menggunakan fitur **Messaging (Pesan)** untuk berkonsultasi langsung jika profil Anda telah ditinjau atau melalui detail kontak perusahaan di halaman lowongan.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="space-y-6">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs border-l-4 border-blue-600 pl-3">Butuh Lebih?</h3>

                    <div class="glass-card p-6 bg-white space-y-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm border border-blue-100">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-900">Chat Langsung</h4>
                            <p class="text-[11px] text-slate-400 font-medium mt-1">Konsultasikan kendala Anda dengan tim IT BKK atau HRD mitra.</p>
                        </div>
                        <a href="{{ route('messages.index') }}" class="block w-full py-3 bg-blue-600 text-white text-center rounded-xl font-black uppercase tracking-widest text-[10px] shadow-lg shadow-blue-200 hover:bg-blue-700 transition">Buka Messenger</a>
                    </div>

                    <div class="glass-card p-6 bg-slate-50 border-dashed">
                        <p class="text-[10px] font-black uppercase text-slate-400 mb-4">Email Support</p>
                        <p class="text-sm font-bold text-slate-700">support@bkk-karir.test</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
