<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - {{ $jobListing->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-slate-50 flex flex-col shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-x border-slate-200/50 relative" x-data="{ showForm: {{ $errors->any() ? 'true' : 'false' }}, busy: false }">

        <!-- Header -->
        <header class="p-5 bg-white border-b border-slate-200/60 shadow-sm sticky top-0 z-40 backdrop-blur-md bg-white/95">
            <div class="flex items-center justify-between">
                <a href="{{ route('jobs.index') }}" aria-label="Kembali ke daftar lowongan"
                    class="inline-flex items-center justify-center p-3 bg-white border border-slate-200/70 rounded-xl text-slate-600 hover:text-blue-600 shadow-sm border-b-2 active:border-b-0 active:translate-y-[2px] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <x-partials.logo size="sm" :withText="false" />
            </div>

            <div class="mt-5 space-y-1">
                <h1 class="text-xl font-black text-slate-900 tracking-tight leading-tight">{{ $jobListing->title }}</h1>
                <p class="text-xs font-bold text-blue-600/80">{{ $jobListing->company->name ?? 'Perusahaan Mitra' }} &middot; <span class="text-slate-500 font-medium">{{ $jobListing->location }}</span></p>
            </div>

            @if ($jobListing->salary)
                <div class="mt-3 inline-flex py-1.5 px-3 bg-amber-50 border border-amber-200/40 text-amber-700 rounded-xl font-bold text-xs shadow-[inset_0_1px_2px_rgba(255,255,255,1)]">
                    {{ $jobListing->salary }}
                </div>
            @endif
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-5 space-y-6 pb-32">
            @if (session('status'))
                <div role="status" class="p-3.5 bg-gradient-to-r from-emerald-50 to-emerald-100/50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Description Box 3D -->
            <section class="bg-white p-5 rounded-3xl border border-slate-200/60 shadow-[0_4px_15px_rgba(0,0,0,0.02)]">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 border-l-4 border-blue-500 pl-2">Deskripsi Pekerjaan</h2>
                <p class="text-xs font-medium text-slate-600 leading-relaxed whitespace-pre-line">{{ $jobListing->description }}</p>
            </section>

            <!-- Requirements Box 3D -->
            <section class="bg-white p-5 rounded-3xl border border-slate-200/60 shadow-[0_4px_15px_rgba(0,0,0,0.02)]">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 border-l-4 border-blue-500 pl-2">Persyaratan</h2>
                <p class="text-xs font-medium text-slate-600 leading-relaxed whitespace-pre-line">{{ $jobListing->requirements }}</p>
            </section>

            <!-- Apply Form Box 3D -->
            @if (! $hasApplied && $jobListing->status === 'open')
                <section x-show="showForm" x-cloak class="pt-2" x-transition>
                    @if ($errors->any())
                        <div role="alert" class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold rounded-xl shadow-sm">
                            Periksa kembali isian Anda di bawah ini.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('jobs.apply', $jobListing) }}" class="space-y-4 bg-white p-5 rounded-3xl border border-slate-200/60 shadow-md" x-on:submit="busy = true">
                        @csrf
                        <div class="space-y-1.5">
                            <label for="resume" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Link CV / Resume</label>
                            <input type="url" id="resume" name="resume" required inputmode="url" autocomplete="url" spellcheck="false"
                                value="{{ old('resume') }}" placeholder="https://drive.google.com/..."
                                @error('resume') aria-invalid="true" aria-describedby="resume-error" @else aria-describedby="resume-help" @enderror
                                class="block w-full px-4 py-3 bg-slate-50/80 border rounded-2xl text-xs font-medium focus:outline-none focus:bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] focus:shadow-none transition duration-150 @error('resume') border-red-300 focus:ring-2 focus:ring-red-100 @else border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror">
                            @error('resume')
                                <p id="resume-error" class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @else
                                <p id="resume-help" class="text-[11px] text-slate-400 font-medium">Tempelkan tautan CV Anda (misal Google Drive). Pastikan diawali https://</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="cover_letter" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Surat Lamaran (Opsional)</label>
                            <textarea id="cover_letter" name="cover_letter" rows="4" placeholder="Ceritakan mengapa Anda cocok untuk posisi ini..."
                                @error('cover_letter') aria-invalid="true" aria-describedby="cover_letter-error" @enderror
                                class="block w-full px-4 py-3 bg-slate-50/80 border rounded-2xl text-xs font-medium focus:outline-none focus:bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] focus:shadow-none transition duration-150 @error('cover_letter') border-red-300 focus:ring-2 focus:ring-red-100 @else border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror">{{ old('cover_letter') }}</textarea>
                            @error('cover_letter')
                                <p id="cover_letter-error" class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" :disabled="busy" :class="busy && 'opacity-60 cursor-not-allowed'"
                            class="w-full py-4 px-6 bg-gradient-to-b from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-bold rounded-2xl shadow-[0_8px_20px_rgba(29,78,216,0.25)] border-b-4 border-blue-900 active:border-b-0 active:translate-y-[4px] transition-all duration-150">
                            <span x-show="!busy">Kirim Lamaran</span>
                            <span x-show="busy" x-cloak>Mengirim...</span>
                        </button>
                    </form>
                </section>
            @endif
        </main>

        <!-- Sticky Bottom Action Bar 3D -->
        <div class="fixed bottom-0 inset-x-4 max-w-md mx-auto p-4 mb-20 bg-slate-50/90 backdrop-blur-md border border-slate-200/40 rounded-3xl shadow-lg pointer-events-none">
            <div class="pointer-events-auto">
                @if ($hasApplied)
                    <div class="w-full py-3.5 px-4 bg-gradient-to-r from-emerald-50 to-emerald-100/50 border border-emerald-200 text-emerald-800 font-bold rounded-2xl text-center shadow-sm text-xs uppercase tracking-wider">Anda sudah melamar</div>
                @elseif ($jobListing->status !== 'open')
                    <div class="w-full py-3.5 px-4 bg-slate-100 text-slate-500 font-bold rounded-2xl text-center text-xs uppercase tracking-wider">Lowongan sudah ditutup</div>
                @else
                    <button type="button" x-show="!showForm" x-on:click="showForm = true; $nextTick(() => document.getElementById('resume')?.focus())"
                        class="w-full py-4 px-6 bg-gradient-to-b from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-bold rounded-2xl shadow-[0_8px_25px_rgba(29,78,216,0.3)] border-b-4 border-blue-900 active:border-b-0 active:translate-y-[4px] transition-all duration-150 text-center text-sm">
                        Lamar Sekarang
                    </button>
                    <p x-show="showForm" x-cloak class="text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider py-1">Lengkapi formulir di atas untuk mengirim lamaran.</p>
                @endif
            </div>
        </div>

        <!-- Floating Bottom Dock Nav component -->
        @include('applicant.partials.bottom-nav', ['active' => 'jobs'])

    </div>
</body>
</html>
