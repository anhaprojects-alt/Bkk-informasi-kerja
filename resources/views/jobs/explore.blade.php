<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="manifest" href="/manifest.json">
    <title>BKK - Eksplorasi Peluang Karir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800 pwa-optimized"
    x-data="{
        selectedJobId: {{ $jobs->first() ? $jobs->first()->id : 'null' }},
        jobs: {{ $jobs->toJson() }},
        appliedJobIds: {{ json_encode($appliedJobIds) }},
        get selectedJob() {
            return this.jobs.find(j => j.id === this.selectedJobId);
        },
        isApplied(id) {
            return this.appliedJobIds.includes(id);
        }
    }">

    <div class="applicant-shell">
        <!-- LinkedIn Style Header -->
        <header class="bg-white border-b border-slate-200 h-14 sticky top-0 z-50 flex items-center shadow-sm">
        <div class="linkedin-container flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}"><x-partials.logo size="sm" :withText="false" /></a>

                <form action="{{ route('jobs.index') }}" method="GET" class="hidden lg:flex items-center gap-1">
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </span>
                        <input type="search" name="q" value="{{ $search }}" placeholder="Jobs" class="bg-[#eef3f8] border-none rounded-l-md py-1.5 pl-10 pr-4 text-sm w-48 focus:ring-2 focus:ring-blue-600 transition-all">
                    </div>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                        </span>
                        <input type="text" placeholder="Location" class="bg-[#eef3f8] border-none rounded-r-md py-1.5 pl-10 pr-4 text-sm w-48 focus:ring-2 focus:ring-blue-600 transition-all border-l border-white">
                    </div>
                </form>
            </div>

            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-black text-slate-500 hover:text-blue-600 transition">Sign in</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 border-2 border-blue-600 text-blue-600 font-black rounded-full hover:bg-blue-50 transition text-sm">Join now</a>
                @else
                    <a href="{{ route('applicant.dashboard') }}" class="flex flex-col items-center text-slate-500 hover:text-slate-900 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        <span class="text-[10px] font-bold mt-0.5">Home</span>
                    </a>
                    <div class="h-8 w-px bg-slate-200 mx-2"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-[10px] font-black uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="hidden sm:block text-xs font-black text-slate-700">{{ Auth::user()->name }}</span>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <div class="linkedin-container mt-6">
        <!-- Mobile Search (Hidden on Desktop) -->
        <div class="lg:hidden mb-4">
            <form action="{{ route('jobs.index') }}" method="GET" class="relative">
                <input type="search" name="q" value="{{ $search }}" placeholder="Cari lowongan..." class="w-full bg-white border border-slate-200 rounded-xl py-3 px-4 shadow-sm focus:ring-2 focus:ring-blue-600">
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 lg:border lg:border-slate-200 lg:rounded-xl lg:bg-white lg:overflow-hidden min-h-[calc(100vh-10rem)]">

            <!-- LEFT COLUMN: Job List -->
            <aside class="lg:col-span-5 border-r border-slate-200 overflow-y-auto max-h-[85vh] bg-white">
                <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $jobs->total() }} Peluang Ditemukan</p>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse ($jobs as $job)
                        <div
                            @click="selectedJobId = {{ $job->id }}; if(window.innerWidth < 1024) window.location.href = '/jobs/' + {{ $job->id }}"
                            :class="selectedJobId === {{ $job->id }} ? 'bg-blue-50/50 border-l-4 border-blue-600' : 'hover:bg-slate-50'"
                            class="p-4 cursor-pointer transition-all">
                            <div class="flex gap-3">
                                <div class="w-12 h-12 bg-white border border-slate-200 rounded flex items-center justify-center shrink-0 shadow-sm">
                                    <svg class="h-6 w-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex justify-between items-start gap-2">
                                        <h3 class="font-black text-blue-600 text-sm leading-tight hover:underline truncate">{{ $job->title }}</h3>
                                        <template x-if="isApplied({{ $job->id }})">
                                            <span class="shrink-0 text-[8px] font-black uppercase text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-100">Dilamar</span>
                                        </template>
                                    </div>
                                    <p class="text-xs font-bold text-slate-700 mt-1 truncate">{{ $job->company->name ?? 'Mitra BKK' }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $job->location }}</p>

                                    <div class="mt-2 flex items-center gap-2 text-[10px] font-black uppercase text-emerald-600">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                        Actively Hiring
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-1 font-medium">{{ $job->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center text-slate-400 font-bold">Belum ada lowongan tersedia.</div>
                    @endforelse
                </div>

                @if ($jobs->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $jobs->onEachSide(0)->links() }}
                    </div>
                @endif
            </aside>

            <!-- RIGHT COLUMN: Job Detail (Desktop Only) -->
            <main class="hidden lg:flex lg:col-span-7 flex-col overflow-y-auto max-h-[85vh] relative p-8 bg-white">
                <template x-if="selectedJob">
                    <div class="space-y-6 animate-fadeIn">
                        <div class="flex justify-between items-start">
                            <div class="flex gap-4">
                                <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-lg flex items-center justify-center">
                                    <svg class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <div class="min-w-0">
                                    <h1 class="text-2xl font-black text-slate-900 leading-tight" x-text="selectedJob.title"></h1>
                                    <p class="text-lg font-bold text-slate-700 mt-1">
                                        <span x-text="selectedJob.company ? selectedJob.company.name : 'Mitra Terpercaya'"></span>
                                        • <span x-text="selectedJob.location"></span>
                                    </p>
                                    <p class="text-sm text-slate-400 mt-1 font-medium">Diposting <span x-text="new Date(selectedJob.created_at).toLocaleDateString('id-ID', {day:'numeric', month:'long'})"></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            @guest
                                <a :href="'/login?intended=' + encodeURIComponent('/jobs/' + selectedJobId)"
                                    class="px-8 py-3 bg-blue-600 text-white font-black rounded-full shadow-lg hover:bg-blue-700 transition-all flex items-center gap-2">
                                    Sign in to apply <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                </a>
                            @else
                                <template x-if="isApplied(selectedJobId)">
                                    <div class="px-8 py-3 bg-emerald-50 text-emerald-700 font-black rounded-full border border-emerald-100 flex items-center gap-2">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7" /></svg> Sudah Dilamar
                                    </div>
                                </template>
                                <template x-if="!isApplied(selectedJobId)">
                                    <a :href="'/applicant/jobs/' + selectedJobId"
                                        class="px-8 py-3 bg-blue-600 text-white font-black rounded-full shadow-lg hover:bg-blue-700 transition-all flex items-center gap-2">
                                        Lamar Sekarang <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                    </a>
                                </template>
                            @endguest
                            <button class="px-8 py-3 border-2 border-blue-600 text-blue-600 font-black rounded-full hover:bg-blue-50 transition-all">Simpan</button>
                        </div>

                        <div class="border-t border-slate-100 pt-8 space-y-8">
                            <section>
                                <h2 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-4 border-l-4 border-blue-600 pl-3">Deskripsi Pekerjaan</h2>
                                <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line text-sm" x-text="selectedJob.description"></p>
                            </section>

                            <section>
                                <h2 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-4 border-l-4 border-blue-600 pl-3">Persyaratan</h2>
                                <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line text-sm" x-text="selectedJob.requirements"></p>
                            </section>
                        </div>
                    </div>
                </template>
                <template x-if="!selectedJob">
                    <div class="h-full flex flex-col items-center justify-center text-slate-300">
                        <svg class="h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        <p class="font-bold uppercase tracking-widest">Pilih lowongan untuk melihat detail</p>
                    </div>
                </template>
            </main>
        </div>
    </div>

    @auth
        <!-- Navigation Dock (Mobile Only) -->
        @include('applicant.partials.bottom-nav', ['active' => 'jobs'])
    @endauth

    <style>
        .animate-fadeIn { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    </div>
</body>
</html>
