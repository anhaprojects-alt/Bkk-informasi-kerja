@php $active = $active ?? 'dashboard'; @endphp
<div class="fixed bottom-4 inset-x-4 max-w-md mx-auto z-50 px-2 pointer-events-none">
    <nav aria-label="Navigasi utama" class="pointer-events-auto bg-white/95 backdrop-blur-md border border-slate-200/80 rounded-2xl p-2 shadow-[0_15px_35px_rgba(0,0,0,0.12),0_4px_12px_rgba(30,64,175,0.04)] flex items-center justify-around gap-1">

        <!-- Dashboard Analitik Cerdas Tab -->
        <a href="{{ route('applicant.dashboard') }}" @if ($active === 'dashboard') aria-current="page" @endif
            class="flex-1 flex flex-col items-center gap-0.5 py-2 px-2 rounded-xl transition-all duration-200 focus:outline-none
            {{ $active === 'dashboard'
                ? 'bg-gradient-to-b from-blue-50 to-blue-100/60 text-blue-700 font-bold shadow-[inset_0_1px_2px_rgba(255,255,255,1)] border border-blue-200/50 scale-105'
                : 'text-slate-400 hover:text-slate-600 font-medium' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $active === 'dashboard' ? 'drop-shadow-[0_2px_4px_rgba(29,78,216,0.25)]' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
            </svg>
            <span class="text-[9px] tracking-wide mt-0.5">Dashboard</span>
        </a>

        <!-- Lowongan Tab -->
        <a href="{{ route('jobs.index') }}" @if ($active === 'jobs') aria-current="page" @endif
            class="flex-1 flex flex-col items-center gap-0.5 py-2 px-2 rounded-xl transition-all duration-200 focus:outline-none
            {{ $active === 'jobs'
                ? 'bg-gradient-to-b from-blue-50 to-blue-100/60 text-blue-700 font-bold shadow-[inset_0_1px_2px_rgba(255,255,255,1)] border border-blue-200/50 scale-105'
                : 'text-slate-400 hover:text-slate-600 font-medium' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $active === 'jobs' ? 'drop-shadow-[0_2px_4px_rgba(29,78,216,0.25)]' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-3.5-3.5m1.5-4.5a6 6 0 11-12 0 6 6 0 0112 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 8V5a2 2 0 012-2h8a2 2 0 012 2v4" />
            </svg>
            <span class="text-[9px] tracking-wide mt-0.5">Lowongan</span>
        </a>

        <!-- Lamaran Tab -->
        <a href="{{ route('applications.mine') }}" @if ($active === 'applications') aria-current="page" @endif
            class="flex-1 flex flex-col items-center gap-0.5 py-2 px-2 rounded-xl transition-all duration-200 focus:outline-none
            {{ $active === 'applications'
                ? 'bg-gradient-to-b from-blue-50 to-blue-100/60 text-blue-700 font-bold shadow-[inset_0_1px_2px_rgba(255,255,255,1)] border border-blue-200/50 scale-105'
                : 'text-slate-400 hover:text-slate-600 font-medium' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $active === 'applications' ? 'drop-shadow-[0_2px_4px_rgba(29,78,216,0.25)]' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2h6" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 17l2 2 4-4" />
            </svg>
            <span class="text-[9px] tracking-wide mt-0.5">Lamaran</span>
        </a>

        <!-- Keluar Button -->
        <form method="POST" action="{{ route('logout') }}" class="flex-1 flex" x-data="{ busy: false }" x-on:submit="busy = true">
            @csrf
            <button type="submit" :disabled="busy" :class="busy && 'opacity-60 cursor-not-allowed'"
                class="w-full flex flex-col items-center gap-0.5 py-2 px-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50/50 transition-all duration-150 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="text-[9px] tracking-wide mt-0.5 font-medium">Keluar</span>
            </button>
        </form>

    </nav>
</div>
