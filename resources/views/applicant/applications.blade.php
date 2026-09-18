<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKK - Lamaran Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-white flex flex-col shadow-xl">

        <header class="p-6 pb-4 border-b border-slate-100">
            <h1 class="text-xl font-extrabold text-slate-900">Lamaran Saya</h1>
            <p class="text-sm text-slate-500 mt-0.5">Pantau status lamaran pekerjaan Anda.</p>
        </header>

        <main class="flex-1 overflow-y-auto p-6 pt-4 space-y-3.5 pb-24">
            @if (session('status'))
                <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl">
                    {{ session('status') }}
                </div>
            @endif

            @php
                $statusStyles = [
                    'pending' => 'bg-amber-50 text-amber-600',
                    'accepted' => 'bg-emerald-50 text-emerald-600',
                    'rejected' => 'bg-red-50 text-red-600',
                ];
                $statusLabels = [
                    'pending' => 'Menunggu',
                    'accepted' => 'Diterima',
                    'rejected' => 'Ditolak',
                ];
            @endphp

            @forelse ($applications as $application)
                <div class="p-4 bg-white border border-slate-200 rounded-2xl shadow-sm">
                    <div class="flex items-start justify-between">
                        <div class="min-w-0">
                            <h3 class="font-bold text-slate-800 truncate">{{ $application->jobListing->title ?? 'Lowongan dihapus' }}</h3>
                            <p class="text-sm text-slate-500 mt-0.5">{{ $application->jobListing->company->name ?? '-' }}</p>
                        </div>
                        <span class="shrink-0 ml-2 inline-flex py-1 px-2.5 text-[11px] font-semibold rounded-full {{ $statusStyles[$application->status] ?? 'bg-slate-100 text-slate-500' }}">
                            {{ $statusLabels[$application->status] ?? ucfirst($application->status) }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-3">Dilamar {{ $application->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <div class="text-center py-16">
                    <div class="w-16 h-16 mx-auto bg-slate-100 rounded-full flex items-center justify-center text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-sm text-slate-500 mt-4">Anda belum melamar pekerjaan apa pun.</p>
                    <a href="{{ route('jobs.index') }}" class="inline-block mt-4 py-2.5 px-5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition">Cari Lowongan</a>
                </div>
            @endforelse
        </main>

        @include('applicant.partials.bottom-nav', ['active' => 'applications'])

    </div>
</body>
</html>
