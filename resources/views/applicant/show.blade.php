<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKK - {{ $jobListing->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-white flex flex-col shadow-xl" x-data="{ showForm: false }">

        <!-- Header -->
        <header class="p-6 pb-4 border-b border-slate-100">
            <a href="{{ route('jobs.index') }}" class="inline-flex items-center justify-center p-2 bg-slate-100 rounded-xl text-slate-600 hover:bg-slate-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl">
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

            @if ($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Apply Form -->
            @unless ($hasApplied)
                <section x-show="showForm" x-cloak class="pt-2">
                    <form method="POST" action="{{ route('jobs.apply', $jobListing) }}" class="space-y-3.5">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Link CV / Resume</label>
                            <input type="text" name="resume" required value="{{ old('resume') }}" placeholder="https://drive.google.com/..."
                                class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Surat Lamaran (Opsional)</label>
                            <textarea name="cover_letter" rows="4" placeholder="Ceritakan mengapa Anda cocok untuk posisi ini..."
                                class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">{{ old('cover_letter') }}</textarea>
                        </div>
                        <button type="submit" class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-100 transition">
                            Kirim Lamaran
                        </button>
                    </form>
                </section>
            @endunless
        </main>

        <!-- Sticky Action -->
        <div class="p-6 pt-3 border-t border-slate-100 bg-white">
            @if ($hasApplied)
                <div class="w-full py-3.5 px-4 bg-emerald-50 text-emerald-700 font-semibold rounded-xl text-center">Anda sudah melamar</div>
            @else
                <button type="button" x-show="!showForm" @click="showForm = true"
                    class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-100 transition">
                    Lamar Sekarang
                </button>
                <p x-show="showForm" x-cloak class="text-center text-xs text-slate-400">Lengkapi formulir di atas untuk mengirim lamaran.</p>
            @endif
        </div>

    </div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important;}</style>
</body>
</html>
