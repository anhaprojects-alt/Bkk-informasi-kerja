<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Lamaran Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-slate-50 flex flex-col shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-x border-slate-200/50 relative">

        <!-- Header (3D Glassmorphism Header) -->
        <header class="p-5 sticky top-0 bg-white/90 backdrop-blur-md z-40 border-b border-slate-200/60 shadow-[0_4px_12px_rgba(0,0,0,0.03)]">
            <div class="flex items-center gap-3">
                <x-partials.logo size="sm" :withText="false" />
                <div>
                    <h1 class="text-lg font-black text-slate-900 leading-none">Lamaran Saya</h1>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1">Pantau status lamaran pekerjaan Anda.</p>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-5 space-y-4 pb-28">
            @if (session('status'))
                <div role="status" class="p-3.5 bg-gradient-to-r from-emerald-50 to-emerald-100/50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            @php
                $statusStyles = [
                    'pending' => 'bg-amber-50 text-amber-600 border-amber-200/40',
                    'accepted' => 'bg-emerald-50 text-emerald-600 border-emerald-200/40',
                    'rejected' => 'bg-red-50 text-red-600 border-red-200/40',
                ];
                $statusLabels = [
                    'pending' => 'Menunggu',
                    'accepted' => 'Diterima',
                    'rejected' => 'Ditolak',
                ];
            @endphp

            @forelse ($applications as $application)
                <!-- 3D Layered Application Card -->
                <div class="p-5 bg-white border border-slate-200/70 rounded-3xl shadow-[0_8px_20px_rgba(0,0,0,0.02)] border-b-4 border-slate-200/90 transform transition-all duration-200">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0 space-y-1">
                            @if ($application->jobListing)
                                <h3 class="font-black text-slate-800 text-base tracking-tight truncate">
                                    <a href="{{ route('jobs.show', $application->jobListing) }}"
                                        class="hover:text-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-100 rounded px-0.5">
                                        {{ $application->jobListing->title }}
                                    </a>
                                </h3>
                                <p class="text-xs font-bold text-blue-600/70 truncate">{{ $application->jobListing->company->name ?? 'Perusahaan Mitra' }}</p>
                            @else
                                <h3 class="font-bold text-slate-400 text-sm italic truncate leading-tight">Lowongan sudah dihapus</h3>
                                <p class="text-[10px] text-slate-400 font-medium tracking-tight mt-0.5">&mdash;</p>
                            @endif
                        </div>
                        <span class="shrink-0 inline-flex py-1 px-3 text-[10px] font-black uppercase tracking-widest rounded-xl border shadow-[inset_0_1px_2px_rgba(255,255,255,1)] {{ $statusStyles[$application->status] ?? 'bg-slate-100 text-slate-500 border-slate-200' }}">
                            {{ $statusLabels[$application->status] ?? ucfirst($application->status) }}
                        </span>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-1.5 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <time datetime="{{ $application->created_at->toIso8601String() }}" title="{{ $application->created_at->translatedFormat('d F Y, H:i') }}" class="text-[10px] font-bold uppercase tracking-tight">
                                {{ $application->created_at->diffForHumans() }}
                            </time>
                        </div>
                        @if ($application->jobListing)
                            <a href="{{ route('jobs.show', $application->jobListing) }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline transition-all">Lihat Detail</a>
                        @endif
                    </div>
                </div>
            @empty
                <!-- 3D Empty State -->
                <div class="text-center py-16 bg-white border border-slate-200/60 rounded-3xl p-6 shadow-sm">
                    <div class="w-16 h-16 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 border-b-2 border-slate-200 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-500 mt-4">Anda belum melamar pekerjaan apa pun.</p>
                    <a href="{{ route('jobs.index') }}" class="inline-block mt-4 py-3 px-5 bg-gradient-to-b from-blue-600 to-blue-700 text-white text-xs font-bold rounded-2xl shadow-md border-b-4 border-blue-900 active:border-b-0 active:translate-y-[4px] transition-all">Cari Lowongan</a>
                </div>
            @endforelse
        </main>

        <!-- Floating Bottom Dock Nav component -->
        @include('applicant.partials.bottom-nav', ['active' => 'applications'])

    </div>
</body>
</html>
