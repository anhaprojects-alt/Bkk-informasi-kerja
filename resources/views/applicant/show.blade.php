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
        <!-- Top Navigation -->
        <header class="bg-white border-b border-slate-200 h-14 sticky top-0 z-50 flex items-center shadow-sm">
            <div class="linkedin-container flex items-center justify-between">
                <a href="{{ route('jobs.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-blue-600 transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    <span class="text-sm font-black uppercase tracking-widest">Kembali</span>
                </a>
                <x-partials.logo size="sm" :withText="false" />
            </div>
        </header>

        <!-- Main Content (Responsive Detail) -->
        <div class="linkedin-container mt-4 md:mt-8 pb-32">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- MAIN CONTENT AREA -->
                <main class="lg:col-span-8 space-y-6">
                    <!-- Premium Header Card -->
                    <div class="glass-card relative overflow-hidden bg-white">
                        <div class="h-32 bg-slate-100/50">
                             <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-transparent"></div>
                        </div>
                        <div class="px-6 pb-8 -mt-12 relative z-10">
                            <div class="w-24 h-24 bg-white border border-slate-200 rounded-xl shadow-md flex items-center justify-center p-2 mb-6">
                                <svg class="w-full h-full text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>

                            <div class="space-y-4">
                                <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">{{ $jobListing->title }}</h1>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 text-lg font-bold text-slate-700">
                                    <span class="text-blue-600">{{ $jobListing->company->name ?? 'Mitra Terpercaya' }}</span>
                                    <span class="hidden sm:inline text-slate-300">•</span>
                                    <span class="text-slate-500">{{ $jobListing->location }}</span>
                                </div>
                                <div class="flex flex-wrap items-center gap-3 text-sm text-slate-400 font-medium pt-2">
                                    <span>Diposting {{ $jobListing->created_at->diffForHumans() }}</span>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-emerald-600 font-black uppercase tracking-widest text-[10px]">28 Applicants</span>
                                </div>
                            </div>

                            <!-- Mobile Action Bar (Inside Card) -->
                            <div class="lg:hidden flex gap-3 mt-8">
                                @guest
                                    <a href="{{ route('login', ['intended' => url()->current()]) }}" class="flex-1 py-4 bg-blue-600 text-white font-black rounded-full shadow-lg text-center">Sign In to Apply</a>
                                @else
                                    @if ($hasApplied)
                                        <div class="flex-1 py-4 bg-emerald-50 text-emerald-700 font-black rounded-full border border-emerald-100 text-center">Sudah Dilamar</div>
                                    @elseif ($jobListing->status === 'open')
                                        <button onclick="document.getElementById('apply-section').scrollIntoView({behavior: 'smooth'})" class="flex-1 py-4 bg-blue-600 text-white font-black rounded-full shadow-lg">Lamar Sekarang</button>
                                    @endif
                                @endguest
                                <button class="px-8 py-4 border-2 border-blue-600 text-blue-600 font-black rounded-full">Save</button>
                            </div>
                        </div>
                    </div>

                    <!-- Details Content -->
                    <div class="glass-card p-8 bg-white space-y-12">
                        <section>
                            <h2 class="text-xl font-black text-slate-900 mb-6 tracking-tight flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                                Deskripsi Pekerjaan
                            </h2>
                            <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line text-base">{{ $jobListing->description }}</p>
                        </section>

                        <section>
                            <h2 class="text-xl font-black text-slate-900 mb-6 tracking-tight flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                                Kualifikasi Utama
                            </h2>
                            <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line text-base">{{ $jobListing->requirements }}</p>
                        </section>
                    </div>

                    <!-- Application Form Section (Anchored) -->
                    @if (!$hasApplied && $jobListing->status === 'open')
                        @auth
                            <div id="apply-section" class="glass-card p-8 bg-white" x-data="{ busy: false }">
                                <h2 class="text-xl font-black text-slate-900 mb-8 tracking-tight">Kirim Aplikasi Lamaran</h2>
                                <form method="POST" action="{{ route('jobs.apply', $jobListing) }}" class="space-y-6" @submit="busy = true">
                                    @csrf
                                    <div class="space-y-2">
                                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400">Tautan Portofolio / CV (Cloud Link)</label>
                                        <input type="url" name="resume" required placeholder="https://drive.google.com/..."
                                            class="w-full px-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition shadow-inner">
                                        <p class="text-[10px] text-slate-400 font-medium italic">Pastikan tautan bersifat publik agar dapat dilihat oleh perusahaan.</p>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400">Surat Lamaran Singkat</label>
                                        <textarea name="cover_letter" rows="6" placeholder="Tuliskan mengapa Anda adalah kandidat terbaik..."
                                            class="w-full px-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition shadow-inner"></textarea>
                                    </div>
                                    <button type="submit" :disabled="busy" class="w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg hover:bg-blue-700 transition-all text-lg">
                                        <span x-show="!busy">Kirim Aplikasi Profesional</span>
                                        <span x-show="busy">Sedang Mengirim...</span>
                                    </button>
                                </form>
                            </div>
                        @endauth
                    @endif
                </main>

                <!-- SIDEBAR ACTION (Desktop Only) -->
                <aside class="lg:col-span-4 hidden lg:block">
                    <div class="sticky top-20 space-y-6">
                        <div class="glass-card p-8 bg-white shadow-xl shadow-blue-900/5">
                            <h3 class="font-black text-slate-900 text-lg mb-4">Ringkasan Karir</h3>
                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400 font-bold">Tingkat:</span>
                                    <span class="text-slate-800 font-black">Entry Level</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400 font-bold">Tipe:</span>
                                    <span class="text-slate-800 font-black">Full-time</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400 font-bold">Gaji:</span>
                                    <span class="text-amber-600 font-black">{{ $jobListing->salary ?? 'N/A' }}</span>
                                </div>
                            </div>

                            @guest
                                <a href="{{ route('login', ['intended' => url()->current()]) }}" class="block w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg text-center hover:bg-blue-700 transition-all">Sign In to Apply</a>
                            @else
                                @if ($hasApplied)
                                    <div class="w-full py-4 bg-emerald-50 text-emerald-700 font-black rounded-full border border-emerald-100 text-center">Sudah Dilamar</div>
                                @elseif ($jobListing->status === 'open')
                                     <button onclick="document.getElementById('apply-section').scrollIntoView({behavior: 'smooth'})" class="w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg hover:bg-blue-700 transition-all">Apply Now</button>
                                @endif
                            @endguest
                        </div>

                        <!-- AI Premium Mockup Widget -->
                        <div class="glass-card p-6 bg-gradient-to-br from-blue-700 to-indigo-900 text-white border-none">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="bg-amber-400 text-[8px] font-black text-white px-1.5 py-0.5 rounded uppercase">AI Insight</span>
                                <h4 class="text-sm font-black">BKK Career Advisor</h4>
                            </div>
                            <p class="text-xs text-blue-100 font-medium leading-relaxed">Profil Anda memiliki 85% kecocokan dengan posisi ini. Lengkapi portofolio untuk mencapai 100%.</p>
                        </div>
                    </div>
                </aside>

            </div>
        </div>

        @auth
            <!-- Navigation Dock (Mobile Only) -->
            @include('applicant.partials.bottom-nav', ['active' => 'jobs'])
        @endauth
    </div>
</body>
</html>
