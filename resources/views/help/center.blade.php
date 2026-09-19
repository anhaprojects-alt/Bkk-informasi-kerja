<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKK - Pusat Bantuan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800">
    <div class="min-h-screen">
        <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
            <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route('applicant.dashboard') }}" class="text-slate-500 hover:text-blue-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    </a>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">BKK Help Center</p>
                        <h1 class="text-lg font-black text-slate-900">Pusat Bantuan & FAQ</h1>
                    </div>
                </div>
                <a href="{{ route('messages.index') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest shadow-lg shadow-blue-200 hover:bg-blue-700 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5m-7 4h10a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v9a2 2 0 002 2z" /></svg>
                    Chat Tim
                </a>
            </div>
        </header>

        <main class="max-w-5xl mx-auto px-4 py-10 space-y-8">
            <section class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-blue-600">Butuh bantuan?</p>
                        <h2 class="mt-2 text-2xl font-black text-slate-900">Kami siap membantu proses karier Anda.</h2>
                    </div>
                    <a href="{{ route('messages.index') }}" class="inline-flex items-center justify-center rounded-full border-2 border-blue-600 text-blue-600 px-5 py-3 text-xs font-black uppercase tracking-widest hover:bg-blue-50 transition">
                        Mulai Chat
                    </a>
                </div>
            </section>

            <section class="grid gap-6 md:grid-cols-2">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-400">Bagaimana cara melamar?</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-600">Cari lowongan, buka detail pekerjaan, lalu klik tombol Apply. Pastikan profil Anda lengkap dan CV diunggah agar perusahaan dapat menilai kesiapan Anda.</p>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-400">Bagaimana mengunggah CV?</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-600">Masuk ke halaman Pengaturan Profil, unggah file PDF/DOCX, lalu simpan perubahan. CV tersebut akan tampil di profil professional Anda.</p>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-400">Apa yang dimaksud lokal Indonesia?</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-600">Sistem pencarian kami sudah dilokalkan untuk wilayah Indonesia seperti Jakarta, Bandung, Surabaya, Yogyakarta, dan area sekitarnya agar hasil relevan pada kebutuhan lokal.</p>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-400">Apakah profil tersimpan otomatis?</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-600">Ya. Profil dan pencarian terakhir disimpan di perangkat Anda untuk pengalaman yang lebih cepat, terutama saat offline atau koneksi terbatas.</p>
                </div>
            </section>

            <section class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                <h3 class="text-sm font-black uppercase tracking-widest text-slate-400">FAQ Umum</h3>
                <div class="mt-6 space-y-4">
                    <div class="border border-slate-200 rounded-2xl p-4">
                        <p class="font-black text-slate-800">Apakah saya bisa mengubah biodata setelah daftar?</p>
                        <p class="mt-2 text-sm text-slate-600">Tentu. Buka Pengaturan Profil kapan saja untuk memperbarui nama, lokasi, headline, CV, dan foto profil.</p>
                    </div>
                    <div class="border border-slate-200 rounded-2xl p-4">
                        <p class="font-black text-slate-800">Apakah situs bisa dipakai tanpa internet?</p>
                        <p class="mt-2 text-sm text-slate-600">Beberapa halaman dan data terakhir tetap tersedia lewat cache lokal dan service worker untuk pengalaman yang lebih tahan offline.</p>
                    </div>
                    <div class="border border-slate-200 rounded-2xl p-4">
                        <p class="font-black text-slate-800">Bagaimana jika saya ingin bertanya di luar FAQ?</p>
                        <p class="mt-2 text-sm text-slate-600">Gunakan fitur chat di halaman ini untuk mengirim pertanyaan langsung ke tim BKK atau perusahaan mitra.</p>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
