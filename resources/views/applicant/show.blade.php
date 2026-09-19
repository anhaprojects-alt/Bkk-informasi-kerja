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

    <header class="bg-white border-b border-slate-200 h-14 sticky top-0 z-50 flex items-center">
        <div class="linkedin-container flex items-center justify-between">
            <a href="{{ route('jobs.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-blue-600 transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                <span class="text-sm font-black uppercase tracking-widest">Kembali</span>
            </a>
            <x-partials.logo size="sm" :withText="false" />
        </div>
    </header>

    <div class="linkedin-container mt-6 pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <main class="lg:col-span-8 space-y-6">
                <!-- Job Header Card -->
                <div class="glass-card p-6">
                    <div class="flex gap-4 items-start mb-6">
                        <div class="w-16 h-16 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center text-slate-300">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h1 class="text-2xl font-black text-slate-900 leading-tight">{{ $jobListing->title }}</h1>
                            <p class="text-blue-600 font-bold mt-1 text-lg">{{ $jobListing->company->name ?? 'Mitra Terpercaya' }}</p>
                            <p class="text-slate-500 font-medium text-sm mt-1">{{ $jobListing->location }} • <span class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">{{ $jobListing->created_at->diffForHumans() }}</span></p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-6 border-t border-slate-100">
                        @if ($jobListing->salary)
                            <span class="bg-amber-50 text-amber-700 px-3 py-1.5 rounded-lg text-xs font-black border border-amber-100 uppercase tracking-tighter">Gaji: {{ $jobListing->salary }}</span>
                        @endif
                        <span class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-black border border-blue-100 uppercase tracking-widest">Full Time</span>
                    </div>
                </div>

                <!-- Job Details -->
                <div class="glass-card p-6 space-y-8">
                    <section>
                        <h2 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-4 border-l-4 border-blue-600 pl-3">Deskripsi Pekerjaan</h2>
                        <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line">{{ $jobListing->description }}</p>
                    </section>

                    <section>
                        <h2 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-4 border-l-4 border-blue-600 pl-3">Persyaratan Utama</h2>
                        <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line">{{ $jobListing->requirements }}</p>
                    </section>
                </div>
            </main>

            <!-- SIDEBAR ACTION -->
            <aside class="lg:col-span-4">
                <div class="sticky top-20 space-y-4">
                    <div class="glass-card p-6 bg-white" x-data="{ showForm: {{ $errors->any() ? 'true' : 'false' }}, busy: false }">
                        @guest
                            <div class="space-y-4 text-center">
                                <p class="text-xs font-bold text-slate-500 leading-relaxed px-4">Lamar posisi ini sekarang dan bergabung dengan tim hebat kami.</p>
                                <a href="{{ route('login', ['intended' => url()->current()]) }}" class="block w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg hover:bg-blue-700 transition-all text-lg text-center">Sign In to Apply</a>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Gabung Sekarang</a></p>
                            </div>
                        @else
                            @if ($hasApplied)
                                <div class="text-center py-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 font-black uppercase tracking-widest text-sm">Sudah Melamar</div>
                            @elseif ($jobListing->status !== 'open')
                                <div class="text-center py-4 bg-slate-50 text-slate-400 rounded-xl border border-slate-100 font-black uppercase tracking-widest text-sm">Lowongan Ditutup</div>
                            @else
                                <div x-show="!showForm" class="space-y-4">
                                    <p class="text-xs font-bold text-slate-500 leading-relaxed text-center px-4">Lamar posisi ini sekarang dan bergabung dengan tim hebat kami.</p>
                                    <button @click="showForm = true" class="w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg hover:bg-blue-700 transition-all text-lg">Lamar Sekarang</button>
                                </div>

                                <form x-show="showForm" method="POST" action="{{ route('jobs.apply', $jobListing) }}" class="space-y-6" @submit="busy = true" x-cloak>
                                    @csrf
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Link CV / Resume</label>
                                        <input type="url" name="resume" required placeholder="https://drive.google.com/..."
                                            class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Surat Lamaran (Opsional)</label>
                                        <textarea name="cover_letter" rows="4" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition"></textarea>
                                    </div>
                                    <button type="submit" :disabled="busy" class="w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg hover:bg-blue-700 transition-all">
                                        <span x-show="!busy">Kirim Aplikasi</span>
                                        <span x-show="busy">Mengirim...</span>
                                    </button>
                                    <button type="button" @click="showForm = false" class="w-full text-xs font-black text-slate-400 uppercase tracking-widest hover:text-red-500">Batal</button>
                                </form>
                            @endif
                        @endguest
                    </div>
                </div>
            </aside>

        </div>
    </div>

    @include('applicant.partials.bottom-nav', ['active' => 'jobs'])
</body>
</html>
