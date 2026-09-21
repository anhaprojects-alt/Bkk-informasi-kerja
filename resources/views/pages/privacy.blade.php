<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Kebijakan Privasi</title>
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
                <h1 class="text-lg font-black text-slate-900 tracking-tight uppercase">Kebijakan Privasi</h1>
            </div>
            <x-partials.logo size="sm" :withText="false" />
        </header>

        <main class="flex-1 max-w-3xl mx-auto w-full p-6 space-y-8 pb-24 pt-8">
            <div class="space-y-4 text-center">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Data Anda adalah Tanggung Jawab Kami.</h2>
                <p class="text-slate-500 font-medium">Terakhir diperbarui: 21 September 2026</p>
            </div>

            <div class="glass-card p-10 bg-white space-y-10 leading-relaxed shadow-sm">

                <section class="space-y-4">
                    <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                        <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                        1. Informasi yang Kami Kumpulkan
                    </h3>
                    <p class="text-sm text-slate-600 font-medium">Kami mengumpulkan informasi yang Anda berikan langsung kepada kami saat mendaftar, membuat profil, atau melamar pekerjaan. Ini termasuk namun tidak terbatas pada:</p>
                    <ul class="list-disc list-inside text-sm text-slate-600 font-medium pl-4 space-y-2">
                        <li>Identitas Diri: Nama lengkap, email, nomor telepon, dan lokasi.</li>
                        <li>Profil Profesional: Ringkasan bio, headline karir, foto profil, dan foto banner.</li>
                        <li>Dokumen Karir: File Curriculum Vitae (CV) dan surat lamaran yang Anda unggah.</li>
                    </ul>
                </section>

                <section class="space-y-4">
                    <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                        <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                        2. Penggunaan Data
                    </h3>
                    <p class="text-sm text-slate-600 font-medium">Data Anda digunakan secara eksklusif untuk:</p>
                    <ul class="list-disc list-inside text-sm text-slate-600 font-medium pl-4 space-y-2">
                        <li>Memproses lamaran kerja Anda ke perusahaan mitra yang Anda pilih.</li>
                        <li>Menampilkan profil Anda kepada perusahaan yang berpotensi merekrut.</li>
                        <li>Memungkinkan komunikasi antara Anda dan tim rekrutmen melalui fitur pesan.</li>
                        <li>Meningkatkan pengalaman pengguna dan fitur analitik cerdas kami.</li>
                    </ul>
                </section>

                <section class="space-y-4">
                    <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                        <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                        3. Berbagi Informasi
                    </h3>
                    <p class="text-sm text-slate-600 font-medium">BKK **tidak akan pernah** menjual data pribadi Anda kepada pihak ketiga manapun. Data profil dan CV Anda hanya akan dibagikan kepada perusahaan mitra secara transparan saat Anda melakukan klik pada tombol "Lamar Sekarang".</p>
                </section>

                <section class="space-y-4">
                    <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                        <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                        4. Keamanan Data
                    </h3>
                    <p class="text-sm text-slate-600 font-medium">Kami menggunakan standar enkripsi modern dan prosedur keamanan tingkat tinggi untuk melindungi informasi Anda dari akses tidak sah, pengungkapan, atau penyalahgunaan. Kami berkomitmen untuk menjaga integritas ekosistem digital kami.</p>
                </section>

                <section class="pt-8 border-t border-slate-50">
                    <p class="text-xs text-slate-400 font-bold italic text-center">Dengan menggunakan platform BKK Informasi Kerja, Anda menyetujui praktik data yang dijelaskan dalam kebijakan ini.</p>
                </section>
            </div>

            <div class="text-center pt-6">
                <p class="text-sm text-slate-500 font-bold">Ada pertanyaan tentang kebijakan kami? <a href="{{ route('help.center') }}" class="text-blue-600 hover:underline">Hubungi Tim Bantuan</a></p>
            </div>
        </main>
    </div>
</body>
</html>
