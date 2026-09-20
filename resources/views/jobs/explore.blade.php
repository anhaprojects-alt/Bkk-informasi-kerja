<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="manifest" href="/manifest.json">
    <title>BKK - Eksplorasi Peluang Karir Cerdas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800 pwa-optimized overflow-x-hidden"
    x-data="{
        selectedJobId: {{ $jobs->first() ? $jobs->first()->id : 'null' }},
        jobsList: {{ json_encode($jobs->items()) }},
        appliedJobIds: {{ json_encode($appliedJobIds) }},
        loading: false,
        get selectedJob() {
            if (!this.selectedJobId) return null;
            return this.jobsList.find(j => j.id == this.selectedJobId);
        },
        isApplied(id) {
            return this.appliedJobIds.includes(id);
        },
        selectJob(id) {
            this.loading = true;
            this.selectedJobId = id;
            setTimeout(() => { this.loading = false; }, 400);
            if(window.innerWidth < 1024) window.location.href = '/jobs/' + id;
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
                                <input type="text" name="l" value="{{ $location }}" placeholder="Provinsi atau Kota"
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

        <div class="linkedin-container mt-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                <!-- LEFT SIDEBAR: Smart Filters (checklists) -->
                <aside class="hidden lg:block lg:col-span-3 space-y-6">
                    <div class="glass-card p-6 bg-white shadow-sm border-b-4 border-blue-600">
                        <h3 class="font-black text-slate-900 text-xs uppercase tracking-widest mb-6 flex items-center gap-2">
                            <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                            Filter Wilayah
                        </h3>

                        <form action="{{ route('jobs.index') }}" method="GET" id="filterForm" class="space-y-6">
                            <input type="hidden" name="q" value="{{ $search }}">

                                <div class="space-y-4">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Wilayah di Indonesia</p>
                                <div class="space-y-2 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                                    @php
                                        $commonLocations = ['Jakarta', 'Bandung', 'Surabaya', 'Semarang', 'Medan', 'Makassar', 'Yogyakarta'];
                                        $allLocations = collect($availableLocations)->merge($commonLocations)->unique()->sort();
                                    @endphp
                                    @foreach($allLocations as $loc)
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <div class="relative flex items-center">
                                                <input type="checkbox" name="cities[]" value="{{ $loc }}"
                                                    {{ in_array($loc, $cities ?? []) ? 'checked' : '' }}
                                                    onchange="this.form.submit()"
                                                    class="peer h-5 w-5 appearance-none rounded border-2 border-slate-200 checked:bg-blue-600 checked:border-blue-600 transition-all cursor-pointer">
                                                <svg class="absolute h-3.5 w-3.5 text-white opacity-0 peer-checked:opacity-100 left-0.5 pointer-events-none transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7" /></svg>
                                            </div>
                                            <span class="text-sm font-bold text-slate-600 group-hover:text-blue-600 transition-colors">{{ $loc }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" name="remote" value="{{ $remoteOnly ? '0' : '1' }}"
                                class="w-full py-2.5 rounded-xl border transition-all text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 {{ $remoteOnly ? 'bg-emerald-600 border-emerald-700 text-white shadow-md' : 'border-slate-200 text-slate-500 hover:bg-slate-50' }}">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 012.5 2.5V14a2 2 0 002 2h.5m-6-12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Remote Only
                            </button>

                            <a href="{{ route('jobs.index') }}" class="block text-center text-[10px] font-black text-slate-400 hover:text-red-500 transition uppercase tracking-widest pt-2 border-t border-slate-100">Reset Filter</a>
                        </form>
                    </div>

                    <!-- Career Insight Card -->
                    <div class="glass-card p-6 bg-gradient-to-br from-indigo-900 to-blue-900 text-white border-none shadow-lg">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="bg-amber-400 text-[8px] font-black text-white px-1.5 py-0.5 rounded uppercase">Intel</span>
                            <h4 class="text-xs font-black uppercase tracking-tight">Market Insight</h4>
                        </div>
                        <p class="text-xs text-indigo-100 font-medium leading-relaxed mb-4">Lowongan kerja di wilayah **{{ $location ?: 'Indonesia' }}** meningkat 24% minggu ini.</p>
                        <div class="h-1.5 w-full bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-400 w-2/3 rounded-full"></div>
                        </div>
                    </div>
                </aside>

                <!-- CENTER COLUMN: Job List -->
                <main class="lg:col-span-4 border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm flex flex-col min-h-[calc(100vh-10rem)]">
                    <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $jobs->total() }} Peluang Tersedia</p>
                        <template x-if="loading">
                            <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l-3-2.647z"></path></svg>
                        </template>
                    </div>

                    <div class="divide-y divide-slate-100 flex-1 overflow-y-auto max-h-[75vh] custom-scrollbar">
                        @forelse ($jobs as $job)
                            <div
                                @click="selectJob({{ $job->id }})"
                                :class="selectedJobId == {{ $job->id }} ? 'bg-blue-50/50 border-l-4 border-blue-600' : 'hover:bg-slate-50'"
                                class="p-5 cursor-pointer transition-all border-l-4 border-transparent">
                                <div class="flex gap-4">
                                    <div class="w-14 h-14 bg-white border border-slate-200 rounded-xl flex items-center justify-center shrink-0 shadow-sm overflow-hidden">
                                        @if($job->company && $job->company->logo)
                                            <img src="{{ Storage::url($job->company->logo) }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="h-7 w-7 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex justify-between items-start gap-2">
                                            <h3 class="font-black text-blue-600 text-[15px] leading-tight hover:underline truncate">{{ $job->title }}</h3>
                                        </div>
                                        <p class="text-xs font-bold text-slate-700 mt-1 truncate">{{ $job->company->name ?? 'Mitra Terpercaya' }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                            {{ $job->location }}
                                        </p>

                                        @if($job->salary)
                                            <p class="mt-2 text-xs font-black text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100 inline-block">{{ $job->salary }}</p>
                                        @endif

                                        <div class="mt-3 flex items-center justify-between">
                                            <div class="flex items-center gap-1.5 text-[10px] font-black uppercase text-slate-400">
                                                <svg class="h-3 w-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                                {{ $job->created_at->diffForHumans() }}
                                            </div>
                                            <template x-if="isApplied({{ $job->id }})">
                                                <span class="text-[9px] font-black uppercase text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 shadow-sm">Dilamar</span>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-slate-400 font-bold text-xs uppercase tracking-[0.2em] leading-relaxed">
                                <svg class="h-12 w-12 mx-auto mb-4 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                Belum ada lowongan<br>sesuai kriteria.
                            </div>
                        @endforelse
                    </div>

                    @if ($jobs->hasPages())
                        <div class="p-4 border-t border-slate-100 bg-slate-50/30">
                            {{ $jobs->onEachSide(0)->links() }}
                        </div>
                    @endif
                </main>

                <!-- RIGHT COLUMN: Job Detail (Desktop Only) -->
                <main class="hidden lg:flex lg:col-span-5 flex-col overflow-y-auto max-h-[85vh] relative bg-white border border-slate-200 rounded-xl shadow-sm custom-scrollbar">

                    <!-- Loading Overlay -->
                    <div x-show="loading" x-transition.opacity class="absolute inset-0 z-50 bg-white/80 backdrop-blur-sm flex flex-col items-center justify-center space-y-4">
                        <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-blue-600 animate-pulse">BKK Intel Dashboard</p>
                    </div>

                    <template x-if="selectedJob">
                        <div class="animate-fadeIn">
                            <!-- Top Banner (LinkedIn Style) -->
                            <div class="h-32 bg-slate-100/50 relative overflow-hidden group">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-transparent group-hover:scale-110 transition-transform duration-[2s]"></div>
                            </div>

                            <div class="px-8 pb-12 -mt-12 relative z-10 space-y-8">
                                <!-- Job Header Info -->
                                <div class="space-y-6">
                                    <div class="w-24 h-24 bg-white border-4 border-white rounded-2xl shadow-xl flex items-center justify-center p-2 relative">
                                        <template x-if="selectedJob && selectedJob.company && selectedJob.company.logo">
                                            <img :src="'/storage/' + selectedJob.company.logo" class="w-full h-full object-cover rounded-xl">
                                        </template>
                                        <template x-if="!selectedJob || !selectedJob.company || !selectedJob.company.logo">
                                            <svg class="h-10 w-10 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        </template>
                                        <div class="absolute -bottom-2 -right-2 bg-blue-600 text-white p-1 rounded-lg shadow-lg">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-none" x-text="selectedJob ? selectedJob.title : ''"></h1>
                                        <div class="flex items-center gap-2 text-lg font-bold text-slate-700">
                                            <span x-text="(selectedJob && selectedJob.company) ? selectedJob.company.name : 'Mitra Terpercaya'"></span>
                                            <span class="text-slate-300">•</span>
                                            <span x-text="selectedJob ? selectedJob.location : ''"></span>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-3 text-[11px] font-black uppercase text-slate-400 tracking-widest pt-2">
                                            <span class="bg-slate-100 px-2 py-1 rounded">Diposting <span x-text="selectedJob ? new Date(selectedJob.created_at).toLocaleDateString('id-ID', {day:'numeric', month:'long'}) : ''"></span></span>
                                            <span class="text-emerald-600 bg-emerald-50 px-2 py-1 rounded">28 Applicants</span>
                                            <template x-if="selectedJob && selectedJob.salary">
                                                <span class="bg-amber-50 text-amber-600 px-2 py-1 rounded border border-amber-100" x-text="selectedJob.salary"></span>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Bar -->
                                <div class="flex items-center gap-3 py-6 sticky top-0 bg-white/95 backdrop-blur-sm z-20 border-b border-slate-50">
                                    @guest
                                        <a :href="'/login?intended=' + encodeURIComponent('/jobs/' + selectedJobId)"
                                            class="flex-1 py-4 bg-blue-600 text-white font-black rounded-full shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all flex items-center justify-center gap-2 text-base">
                                            Lamar Cepat <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                        </a>
                                    @else
                                        <template x-if="isApplied(selectedJobId)">
                                            <div class="flex-1 py-4 bg-emerald-50 text-emerald-700 font-black rounded-full border border-emerald-100 flex items-center justify-center gap-2 text-base">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7" /></svg> Sudah Dilamar
                                            </div>
                                        </template>
                                        <template x-if="!isApplied(selectedJobId)">
                                            <a :href="'/applicant/jobs/' + selectedJobId"
                                                class="flex-1 py-4 bg-blue-600 text-white font-black rounded-full shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all flex items-center justify-center gap-2 text-base">
                                                Lamar Sekarang <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                            </a>
                                        </template>
                                    @endguest
                                    <button class="px-8 py-4 border-2 border-blue-600 text-blue-600 font-black rounded-full hover:bg-blue-50 transition-all text-base shadow-sm">Save</button>

                                    @auth
                                        <template x-if="selectedJob && selectedJob.company && selectedJob.company.user_id">
                                            <a :href="'/messages/' + selectedJob.company.user_id"
                                                class="p-4 border-2 border-slate-200 text-slate-500 rounded-full hover:bg-slate-50 hover:text-blue-600 transition-all shadow-sm"
                                                title="Kirim Pesan ke Perusahaan">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                            </a>
                                        </template>
                                    @endauth
                                </div>

                                <!-- SMART CONTENT: Salary & Location Map -->
                                <div class="space-y-8 pt-4 pb-12">
                                    <section class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                                        <h2 class="text-sm font-black text-slate-900 mb-4 tracking-widest uppercase flex items-center gap-2">
                                            <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                            Lokasi & Akses
                                        </h2>
                                        <p class="text-sm text-slate-600 font-bold mb-4" x-text="(selectedJob.company && selectedJob.company.address) ? selectedJob.company.address : selectedJob.location"></p>

                                        <!-- Smart Map Embed (OpenStreetMap / Leaflet approach using Iframe for simplicity) -->
                                        <div class="rounded-xl overflow-hidden border-2 border-white shadow-md bg-slate-200 relative h-48 group">
                                            <iframe
                                                class="w-full h-full grayscale-[50%] contrast-[1.2] group-hover:grayscale-0 transition-all duration-700"
                                                frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                                                :src="'https://maps.google.com/maps?q=' + encodeURIComponent((selectedJob.company && selectedJob.company.address) ? selectedJob.company.address : selectedJob.location) + '&t=&z=13&ie=UTF8&iwloc=&output=embed'">
                                            </iframe>
                                            <div class="absolute bottom-3 right-3 bg-white/90 backdrop-blur px-3 py-1.5 rounded-lg border border-slate-200 text-[9px] font-black uppercase tracking-widest text-slate-500 shadow-sm pointer-events-none">BKK Maps Insight</div>
                                        </div>
                                    </section>

                                    <section>
                                        <h2 class="text-xl font-black text-slate-900 mb-4 tracking-tight flex items-center gap-3">
                                            <span class="w-1.5 h-6 bg-blue-600 rounded-full shadow-sm"></span>
                                            Tentang Pekerjaan
                                        </h2>
                                        <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line text-[15px]" x-text="selectedJob.description"></p>
                                    </section>

                                    <section>
                                        <h2 class="text-xl font-black text-slate-900 mb-4 tracking-tight flex items-center gap-3">
                                            <span class="w-1.5 h-6 bg-blue-600 rounded-full shadow-sm"></span>
                                            Kualifikasi Utama
                                        </h2>
                                        <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line text-[15px]" x-text="selectedJob.requirements"></p>
                                    </section>

                                    <section class="bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-6 shadow-sm">
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="bg-amber-400 text-[9px] font-black text-white px-1.5 py-0.5 rounded uppercase tracking-widest animate-pulse">Cerdas</span>
                                            <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight">AI Fit Analysis</h4>
                                        </div>
                                        <p class="text-xs text-slate-600 font-medium leading-relaxed mb-6">Profil Anda memiliki kecocokan **85%** dengan posisi ini berdasarkan riwayat alumni sebelumnya.</p>
                                        <div class="flex gap-2">
                                            <button class="px-4 py-2 bg-white border border-slate-200 rounded-full text-[10px] font-black text-slate-700 hover:border-amber-400 transition-colors uppercase tracking-widest">Optimalkan CV</button>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- COOL EMPTY STATE WITH INTERACTIVE LOGO -->
                    <template x-if="!selectedJobId">
                        <div class="h-full flex flex-col items-center justify-center p-12 text-center space-y-8 animate-fadeIn bg-gradient-to-b from-white to-slate-50/50">
                            <div class="relative group cursor-pointer" @click="selectJob({{ $jobs->first() ? $jobs->first()->id : 'null' }})">
                                <div class="absolute inset-0 bg-blue-400/20 rounded-full blur-3xl group-hover:bg-blue-600/40 transition-all duration-700 scale-150 group-hover:scale-[2]"></div>
                                <div class="relative transform group-hover:scale-110 group-hover:-rotate-3 group-hover:-translate-y-4 transition-all duration-500 ease-out">
                                    <x-partials.logo size="xl" :withText="false" />
                                    <div class="absolute -top-4 -right-4 w-10 h-10 bg-amber-400 rounded-2xl shadow-xl flex items-center justify-center text-white animate-bounce group-hover:animate-none">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="max-w-xs space-y-4">
                                <h2 class="text-3xl font-black text-slate-900 tracking-tight leading-tight group-hover:text-blue-600 transition-colors uppercase">Temukan Karir</h2>
                                <p class="text-sm text-slate-500 font-medium leading-relaxed">Pilih salah satu lowongan di sebelah kiri untuk menganalisis detail kualifikasi, estimasi gaji, dan peta lokasi perusahaan.</p>
                            </div>
                        </div>
                    </template>
                </main>
            </div>
        </div>
    </div>

    @auth
        @include('applicant.partials.bottom-nav', ['active' => 'jobs'])
    @endauth

    <style>
        .animate-fadeIn { animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 20px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>
</body>
</html>
