<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - {{ $jobListing->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-white flex flex-col shadow-xl" x-data="{ showForm: {{ $errors->any() ? 'true' : 'false' }}, busy: false }">

        <!-- Header -->
        <header class="p-6 pb-4 border-b border-slate-100">
            <a href="{{ route('jobs.index') }}" aria-label="Kembali ke daftar lowongan"
                class="inline-flex items-center justify-center p-2 bg-slate-100 rounded-xl text-slate-600 hover:bg-slate-200 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900 mt-4">{{ $jobListing->title }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $jobListing->company->name ?? 'Perusahaan' }} &middot; {{ $jobListing->location }}</p>
            @if ($jobListing->salary)
                <span class="inline-flex mt-3 py-1 px-3 bg-indigo-50 text-indigo-600 rounded-full text-sm font-semibold">{{ $jobListing->salary }}</span>
            @endif
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-6 pb-28">
            @if (session('status'))
                <div role="status" class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl">
                    {{ session('status') }}
                </div>
            @endif

            <section>
                <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Deskripsi Pekerjaan</h2>
                <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $jobListing->description }}</p>
            </section>

            <section>
                <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Persyaratan</h2>
                <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $jobListing->requirements }}</p>
            </section>

            <!-- Apply Form -->
            @if (! $hasApplied && $jobListing->status === 'open')
                <section x-show="showForm" x-cloak class="pt-2">
                    @if ($errors->any())
                        <div role="alert" class="mb-3 p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl">
                            Periksa kembali isian Anda di bawah ini.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('jobs.apply', $jobListing) }}" class="space-y-3.5" x-on:submit="busy = true">
                        @csrf
                        <div>
                            <label for="resume" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Link CV / Resume</label>
                            <input type="url" id="resume" name="resume" required inputmode="url" autocomplete="url" spellcheck="false"
                                value="{{ old('resume') }}" placeholder="https://drive.google.com/..."
                                @error('resume') aria-invalid="true" aria-describedby="resume-error" @else aria-describedby="resume-help" @enderror
                                class="block w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:bg-white transition @error('resume') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-indigo-500 @enderror">
                            @error('resume')
                                <p id="resume-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @else
                                <p id="resume-help" class="mt-1 text-xs text-slate-400">Tempelkan tautan CV Anda, contoh Google Drive. Pastikan diawali https://</p>
                            @enderror
                        </div>
                        <div>
                            <label for="cover_letter" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Surat Lamaran (Opsional)</label>
                            <textarea id="cover_letter" name="cover_letter" rows="4" placeholder="Ceritakan mengapa Anda cocok untuk posisi ini..."
                                @error('cover_letter') aria-invalid="true" aria-describedby="cover_letter-error" @enderror
                                class="block w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:bg-white transition @error('cover_letter') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-indigo-500 @enderror">{{ old('cover_letter') }}</textarea>
                            @error('cover_letter')
                                <p id="cover_letter-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" :disabled="busy" :class="busy && 'opacity-60 cursor-not-allowed'"
                            class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-100 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                            <span x-show="!busy">Kirim Lamaran</span>
                            <span x-show="busy" x-cloak>Mengirim...</span>
                        </button>
                    </form>
                </section>
            @endif
        </main>

        <!-- Sticky Action -->
        <div class="p-6 pt-3 border-t border-slate-100 bg-white pb-[max(1.5rem,env(safe-area-inset-bottom))]">
            @if ($hasApplied)
                <div class="w-full py-3.5 px-4 bg-emerald-50 text-emerald-700 font-semibold rounded-xl text-center">Anda sudah melamar</div>
            @elseif ($jobListing->status !== 'open')
                <div class="w-full py-3.5 px-4 bg-slate-100 text-slate-500 font-semibold rounded-xl text-center">Lowongan sudah ditutup</div>
            @else
                <button type="button" x-show="!showForm" x-on:click="showForm = true; $nextTick(() => document.getElementById('resume')?.focus())"
                    class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-100 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                    Lamar Sekarang
                </button>
                <p x-show="showForm" x-cloak class="text-center text-xs text-slate-400">Lengkapi formulir di atas untuk mengirim lamaran.</p>
            @endif
        </div>

    </div>
</body>
</html>
