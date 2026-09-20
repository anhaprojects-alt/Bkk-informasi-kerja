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
        jobsList: {{ json_encode($jobs->items()) }},
        appliedJobIds: {{ json_encode($appliedJobIds) }},
        get selectedJob() {
            if (!this.selectedJobId) return null;
            return this.jobsList.find(j => j.id == this.selectedJobId);
        },
        isApplied(id) {
            return this.appliedJobIds.includes(id);
        }
    }">

    <div class="applicant-shell">
        <!-- LinkedIn Style Header -->
        <header class="bg-white border-b border-slate-200 h-14 sticky top-0 z-50 flex items-center shadow-sm">
            <div class="linkedin-container flex items-center justify-between gap-4">
                <div class="flex items-center gap-4 flex-1">
                    <a href="{{ route('home') }}"><x-partials.logo size="sm" :withText="false" /></a>

                    <form action="{{ route('jobs.index') }}" method="GET" class="hidden lg:flex items-center flex-1 max-w-2xl">
                        <div class="flex items-center flex-1 bg-[#eef3f8] rounded-md overflow-hidden border border-transparent focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 transition-all">
                            <!-- Job Keyword Input -->
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </span>
                                <input type="search" name="q" value="{{ $search }}" placeholder="Cari posisi atau perusahaan"
                                    class="bg-transparent border-none py-2 pl-9 pr-4 text-sm w-full focus:ring-0">
                            </div>

                            <!-- Divider Line -->
                            <div class="h-6 w-px bg-slate-300"></div>

                            <!-- Location Input -->
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </span>
                                <input type="text" name="l" value="{{ $location }}" placeholder="Kota atau wilayah"
                                    class="bg-transparent border-none py-2 pl-9 pr-4 text-sm w-full focus:ring-0">
                            </div>

                            <button type="submit" class="hidden">Cari</button>
                        </div>
                    </form>
                </div>

                <div class="flex items-center gap-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-black text-slate-500 hover:text-blue-600 transition">Sign in</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 border-2 border-blue-600 text-blue-600 font-black rounded-full hover:bg-blue-50 transition text-sm">Join now</a>
                    @else
                        <!-- Profile Dropdown (Me) -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex flex-col items-center leading-none focus:outline-none group">
                                <img src="{{ Auth::user()->avatar_url }}" alt="Me" class="w-6 h-6 rounded-full border border-slate-200 group-hover:border-blue-600">
                                <span class="text-[10px] font-bold text-slate-400 mt-0.5 group-hover:text-blue-600 flex items-center gap-0.5">Me <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" /></svg></span>
                            </button>

                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-3 w-64 bg-white border border-slate-200 rounded-xl shadow-xl z-[100] py-2 overflow-hidden animate-fadeIn">
                                <div class="px-4 py-3 flex gap-3 border-b border-slate-100 text-left">
                                    <img src="{{ Auth::user()->avatar_url }}" class="w-12 h-12 rounded-full border border-slate-100">
                                    <div class="min-w-0">
                                        <p class="text-sm font-black text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-[10px] text-slate-500 font-medium truncate leading-tight">{{ Auth::user()->headline ?? 'Alumni Professional' }}</p>
                                    </div>
                                </div>
                                <div class="py-1">
                                    <a href="{{ route('settings.profile') }}" class="block px-4 py-2 text-xs font-black text-blue-600 hover:bg-slate-50 text-left">Lihat Profil & Pengaturan</a>
                                    <a href="{{ route('applicant.dashboard') }}" class="block px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50 text-left">Dashboard Analitik</a>
                                </div>
                                <div class="border-t border-slate-100 py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-xs font-bold text-slate-500 hover:bg-red-50 hover:text-red-600 transition-colors">Keluar Akun</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </header>

        <!-- Smart Filter Bar (Sub-header) -->
        <div class="bg-white border-b border-slate-200 sticky top-14 z-40 hidden lg:block shadow-sm">
            <div class="linkedin-container py-3">
                <form action="{{ route('jobs.index') }}" method="GET" class="flex items-center gap-3">
                    <input type="hidden" name="q" value="{{ $search }}">
                    <input type="hidden" name="l" value="{{ $location }}">

                    <button type="submit" name="remote" value="{{ $remoteOnly ? '0' : '1' }}"
                        class="px-4 py-1.5 rounded-full border transition-all text-sm font-black flex items-center gap-2 {{ $remoteOnly ? 'bg-emerald-600 border-emerald-700 text-white shadow-md' : 'border-slate-300 text-slate-600 hover:bg-slate-50' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 012.5 2.5V14a2 2 0 002 2h.5m-6-12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Remote Only
                    </button>

                    <div class="h-6 w-px bg-slate-200 mx-2"></div>

                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Live Tracking:</span>
                    <span class="text-sm font-black text-blue-600 bg-blue-50 px-2 py-1 rounded-lg border border-blue-100">{{ $jobs->total() }} Peluang Aktif</span>

                    <div class="flex-1"></div>

                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-black rounded-full shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all text-xs uppercase tracking-widest">Update Search</button>
                </form>
            </div>
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
                            :class="selectedJobId == {{ $job->id }} ? 'bg-blue-50/50 border-l-4 border-blue-600' : 'hover:bg-slate-50'"
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
                        <div class="p-12 text-center text-slate-400 font-bold text-sm uppercase tracking-widest">Belum ada lowongan tersedia.</div>
                    @endforelse
                </div>

                @if ($jobs->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $jobs->onEachSide(0)->links() }}
                    </div>
                @endif
            </aside>

            <!-- RIGHT COLUMN: Job Detail (Desktop Only) -->
            <main class="hidden lg:flex lg:col-span-7 flex-col overflow-y-auto max-h-[85vh] relative bg-white border-l border-slate-200">
                <template x-if="selectedJob">
                    <div class="animate-fadeIn">
                        <!-- Top Banner / Background (LinkedIn Style) -->
                        <div class="h-32 bg-slate-100/50 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-transparent"></div>
                        </div>

                        <div class="px-8 pb-12 -mt-12 relative z-10 space-y-8">
                            <!-- Job Header Info -->
                            <div class="space-y-6">
                                <div class="w-24 h-24 bg-white border border-slate-200 rounded-lg shadow-md flex items-center justify-center p-2">
                                    <svg class="w-full h-full text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>

                                <div class="space-y-2">
                                    <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-none" x-text="selectedJob.title"></h1>
                                    <div class="flex items-center gap-2 text-lg font-bold text-slate-700">
                                        <span x-text="selectedJob.company ? selectedJob.company.name : 'Mitra Terpercaya'"></span>
                                        <span class="text-slate-300">•</span>
                                        <span x-text="selectedJob.location"></span>
                                    </div>
                                    <div class="flex items-center gap-3 text-sm text-slate-500 font-medium">
                                        <span>Diposting <span x-text="new Date(selectedJob.created_at).toLocaleDateString('id-ID', {day:'numeric', month:'long'})"></span></span>
                                        <span class="text-slate-300">•</span>
                                        <span class="text-emerald-600 font-black uppercase tracking-widest text-[10px]">28 Applicants</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Bar -->
                            <div class="flex items-center gap-3 py-4 sticky top-0 bg-white/95 backdrop-blur-sm z-20 border-b border-slate-50">
                                @guest
                                    <a :href="'/login?intended=' + encodeURIComponent('/jobs/' + selectedJobId)"
                                        class="px-10 py-3.5 bg-blue-600 text-white font-black rounded-full shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all flex items-center gap-2 text-base">
                                        Apply <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                    </a>
                                @else
                                    <template x-if="isApplied(selectedJobId)">
                                        <div class="px-10 py-3.5 bg-emerald-50 text-emerald-700 font-black rounded-full border border-emerald-100 flex items-center gap-2 text-base">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7" /></svg> Sudah Dilamar
                                        </div>
                                    </template>
                                    <template x-if="!isApplied(selectedJobId)">
                                        <a :href="'/applicant/jobs/' + selectedJobId"
                                            class="px-10 py-3.5 bg-blue-600 text-white font-black rounded-full shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all flex items-center gap-2 text-base">
                                            Apply <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                        </a>
                                    </template>
                                @endguest
                                <button class="px-10 py-3.5 border-2 border-blue-600 text-blue-600 font-black rounded-full hover:bg-blue-50 transition-all text-base">Save</button>

                                @auth
                                    <template x-if="selectedJob && selectedJob.company && selectedJob.company.user_id">
                                        <a :href="'/messages/' + selectedJob.company.user_id"
                                            class="p-3.5 border-2 border-slate-200 text-slate-500 rounded-full hover:bg-slate-50 hover:text-blue-600 transition-all shadow-sm"
                                            title="Kirim Pesan ke Perusahaan">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                        </a>
                                    </template>
                                @endauth
                            </div>

                            <!-- Detailed Sections -->
                            <div class="space-y-10 pt-4 pb-12">
                                <section>
                                    <h2 class="text-xl font-black text-slate-900 mb-4 tracking-tight flex items-center gap-3">
                                        <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                                        Deskripsi Pekerjaan
                                    </h2>
                                    <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line text-[15px]" x-text="selectedJob.description"></p>
                                </section>

                                <section>
                                    <h2 class="text-xl font-black text-slate-900 mb-4 tracking-tight flex items-center gap-3">
                                        <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                                        Kualifikasi Utama
                                    </h2>
                                    <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line text-[15px]" x-text="selectedJob.requirements"></p>
                                </section>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- COOL EMPTY STATE WITH INTERACTIVE LOGO -->
                <template x-if="!selectedJobId">
                    <div class="h-full flex flex-col items-center justify-center p-12 text-center space-y-8 animate-fadeIn bg-gradient-to-b from-white to-slate-50/50">
                        <div class="relative group cursor-pointer" @click="selectedJobId = {{ $jobs->first() ? $jobs->first()->id : 'null' }}">
                            <!-- Floating Glow Effect -->
                            <div class="absolute inset-0 bg-blue-400/20 rounded-full blur-3xl group-hover:bg-blue-600/40 transition-all duration-700 scale-150 group-hover:scale-[2]"></div>

                            <!-- Large Interactive 3D Logo -->
                            <div class="relative transform group-hover:scale-110 group-hover:-rotate-3 group-hover:-translate-y-4 transition-all duration-500 ease-out">
                                <x-partials.logo size="xl" :withText="false" />

                                <!-- Decorative Floating Badges -->
                                <div class="absolute -top-4 -right-4 w-10 h-10 bg-amber-400 rounded-2xl shadow-xl flex items-center justify-center text-white animate-bounce group-hover:animate-none group-hover:scale-125 transition-transform">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                                </div>
                                <div class="absolute -bottom-2 -left-6 w-8 h-8 bg-blue-600 rounded-xl shadow-lg flex items-center justify-center text-white animate-pulse group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                </div>
                            </div>
                        </div>

                        <div class="max-w-xs space-y-4">
                            <h2 class="text-3xl font-black text-slate-900 tracking-tight leading-tight group-hover:text-blue-600 transition-colors uppercase">Temukan Karir</h2>
                            <p class="text-sm text-slate-500 font-medium leading-relaxed">Pilih salah satu lowongan di sebelah kiri untuk menganalisis detail persyaratan dan masa depan profesional Anda.</p>
                        </div>

                        <div class="flex gap-4 items-center text-[11px] font-black uppercase tracking-[0.3em] text-slate-300">
                            <span class="w-12 h-px bg-slate-200"></span>
                            <span class="animate-pulse">BKK Intel Dashboard</span>
                            <span class="w-12 h-px bg-slate-200"></span>
                        </div>
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
        .animate-fadeIn { animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</body>
</html>
