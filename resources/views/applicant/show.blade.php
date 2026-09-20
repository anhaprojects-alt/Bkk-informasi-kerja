<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="manifest" href="/manifest.json">
    <title>BKK - {{ $jobListing->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800 pwa-optimized">
    <div class="applicant-shell">
        <header class="bg-white border-b border-slate-200 h-14 sticky top-0 z-50 flex items-center shadow-sm">
            <div class="linkedin-container flex items-center justify-between">
                <a href="{{ route('jobs.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-blue-600 transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    <span class="text-sm font-black uppercase tracking-widest">Kembali</span>
                </a>
                <x-partials.logo size="sm" :withText="false" />
            </div>
        </header>

        <div class="linkedin-container mt-4 md:mt-8 pb-32">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <main class="lg:col-span-8 space-y-6">
                    <div class="glass-card relative overflow-hidden bg-white border-b-4 border-blue-600">
                        <div class="h-32 bg-slate-100/50">
                             <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-transparent"></div>
                        </div>
                        <div class="px-6 pb-8 -mt-12 relative z-10">
                            <div class="w-24 h-24 bg-white border border-slate-200 rounded-2xl shadow-lg flex items-center justify-center p-2 mb-6">
                                @if($jobListing->company && $jobListing->company->logo)
                                    <img src="{{ Storage::url($jobListing->company->logo) }}" class="w-full h-full object-cover rounded-xl">
                                @else
                                    <svg class="w-12 h-12 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">{{ $jobListing->title }}</h1>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 text-lg font-bold text-slate-700">
                                    <span class="text-blue-600">{{ $jobListing->company->name ?? 'Mitra Terpercaya' }}</span>
                                    <span class="hidden sm:inline text-slate-300">•</span>
                                    <span class="text-slate-500">{{ $jobListing->location }}</span>
                                </div>
                                <div class="flex flex-wrap items-center gap-3 text-[11px] font-black uppercase text-slate-400 tracking-widest pt-2">
                                    <span class="bg-slate-50 px-2 py-1 rounded border border-slate-100">Diposting {{ $jobListing->created_at->diffForHumans() }}</span>
                                    <span class="text-emerald-600 bg-emerald-50 px-2 py-1 rounded border border-emerald-100">28 Applicants</span>
                                    @if($jobListing->salary)
                                        <span class="bg-amber-50 text-amber-600 px-2 py-1 rounded border border-amber-100">{{ $jobListing->salary }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card p-8 bg-white space-y-12 shadow-sm">
                        <section class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h2 class="text-sm font-black text-slate-900 mb-4 tracking-widest uppercase flex items-center gap-2">
                                <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                Lokasi Perusahaan
                            </h2>
                            <p class="text-sm text-slate-600 font-bold mb-4">{{ $jobListing->company->address ?? $jobListing->location }}</p>

                            <div class="rounded-xl overflow-hidden border-2 border-white shadow-md bg-slate-200 relative h-64">
                                <iframe
                                    class="w-full h-full grayscale-[30%] contrast-[1.1]"
                                    frameborder="0" scrolling="no"
                                    src="https://maps.google.com/maps?q={{ urlencode($jobListing->company->address ?? $jobListing->location) }}&t=&z=14&ie=UTF8&iwloc=&output=embed">
                                </iframe>
                                <div class="absolute bottom-3 right-3 bg-white/90 px-3 py-1.5 rounded-lg border border-slate-200 text-[9px] font-black uppercase tracking-widest text-slate-500 shadow-sm pointer-events-none">BKK Smart Maps</div>
                            </div>
                        </section>

                        <section>
                            <h2 class="text-xl font-black text-slate-900 mb-6 tracking-tight flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full shadow-sm"></span>
                                Deskripsi Pekerjaan
                            </h2>
                            <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line text-base">{{ $jobListing->description }}</p>
                        </section>

                        <section>
                            <h2 class="text-xl font-black text-slate-900 mb-6 tracking-tight flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full shadow-sm"></span>
                                Kualifikasi Utama
                            </h2>
                            <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line text-base">{{ $jobListing->requirements }}</p>
                        </section>
                    </div>

                    @if (!$hasApplied && $jobListing->status === 'open')
                        @auth
                            <div id="apply-section" class="glass-card p-8 bg-white border-t-4 border-emerald-500 shadow-lg" x-data="{ busy: false }">
                                <h2 class="text-xl font-black text-slate-900 mb-8 tracking-tight">Kirim Aplikasi Lamaran</h2>
                                <form method="POST" action="{{ route('jobs.apply', $jobListing) }}" class="space-y-6" @submit="busy = true">
                                    @csrf
                                    <div class="space-y-2">
                                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400">Tautan Portofolio / CV (Cloud Link)</label>
                                        <input type="url" name="resume" required placeholder="https://drive.google.com/..."
                                            class="w-full px-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition shadow-inner">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400">Surat Lamaran Singkat</label>
                                        <textarea name="cover_letter" rows="6" placeholder="Tuliskan mengapa Anda adalah kandidat terbaik..."
                                            class="w-full px-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition shadow-inner"></textarea>
                                    </div>
                                    <button type="submit" :disabled="busy" class="w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg hover:bg-blue-700 transition-all text-base uppercase tracking-widest">
                                        <span x-show="!busy">Kirim Aplikasi Profesional</span>
                                        <span x-show="busy">Sedang Mengirim...</span>
                                    </button>
                                </form>
                            </div>
                        @endauth
                    @endif
                </main>

                <aside class="lg:col-span-4 hidden lg:block">
                    <div class="sticky top-20 space-y-6">
                        <div class="glass-card p-8 bg-white shadow-xl shadow-blue-900/5">
                            <h3 class="font-black text-slate-900 text-lg mb-6 tracking-tight uppercase">Detail Karir</h3>
                            <div class="space-y-5 mb-8">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Tingkat:</span>
                                    <span class="text-slate-800 font-black px-2 py-1 bg-slate-50 rounded-lg">Entry Level</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Tipe:</span>
                                    <span class="text-slate-800 font-black px-2 py-1 bg-slate-50 rounded-lg">Full-time</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Gaji:</span>
                                    <span class="text-emerald-600 font-black px-2 py-1 bg-emerald-50 rounded-lg">{{ $jobListing->salary ?? 'Rahasia' }}</span>
                                </div>
                            </div>

                            @guest
                                <a href="{{ route('login', ['intended' => url()->current()]) }}" class="block w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg text-center hover:bg-blue-700 transition-all text-sm uppercase tracking-widest">Sign In to Apply</a>
                            @else
                                @if ($hasApplied)
                                    <div class="w-full py-4 bg-emerald-50 text-emerald-700 font-black rounded-full border border-emerald-100 text-center text-sm uppercase tracking-widest">Sudah Dilamar</div>
                                @elseif ($jobListing->status === 'open')
                                     <button onclick="document.getElementById('apply-section').scrollIntoView({behavior: 'smooth'})" class="w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg hover:bg-blue-700 transition-all text-sm uppercase tracking-widest">Apply Now</button>
                                @endif

                                @if($jobListing->company && $jobListing->company->user_id)
                                    <a href="{{ route('messages.show', $jobListing->company->user_id) }}" class="mt-4 block w-full py-3 border-2 border-slate-200 text-slate-500 font-black rounded-full text-center hover:bg-slate-50 transition-all text-[11px] uppercase tracking-widest">Chat ke HRD</a>
                                @endif
                            @endguest
                        </div>

                        <div class="glass-card p-6 bg-gradient-to-br from-blue-700 to-indigo-900 text-white border-none shadow-indigo-900/20">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="bg-amber-400 text-[8px] font-black text-white px-1.5 py-0.5 rounded uppercase animate-pulse">AI Advisor</span>
                                <h4 class="text-sm font-black tracking-tight">Kecocokan Profil</h4>
                            </div>
                            <p class="text-xs text-blue-100 font-medium leading-relaxed">Profil Anda memiliki **85% kecocokan** dengan kriteria perusahaan ini.</p>
                        </div>
                    </div>
                </aside>

            </div>
        </div>

        @auth
            @include('applicant.partials.bottom-nav', ['active' => 'jobs'])
        @endauth
    </div>
</body>
</html>
