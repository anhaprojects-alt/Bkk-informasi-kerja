@php $active = $active ?? 'jobs'; @endphp
<nav aria-label="Navigasi utama" class="sticky bottom-0 bg-white border-t border-slate-200 pb-[env(safe-area-inset-bottom)]">
    <div class="flex items-center justify-around px-4 py-2">
        <a href="{{ route('jobs.index') }}" @if ($active === 'jobs') aria-current="page" @endif
            class="flex flex-col items-center gap-0.5 py-1.5 px-4 rounded-xl min-w-[64px] transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 {{ $active === 'jobs' ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600' }}">
            {{-- Magnifier over a document: "cari lowongan" --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-3.5-3.5m1.5-4.5a6 6 0 11-12 0 6 6 0 0112 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 8V5a2 2 0 012-2h8a2 2 0 012 2v4" />
            </svg>
            <span class="text-[11px] font-semibold">Lowongan</span>
        </a>
        <a href="{{ route('applications.mine') }}" @if ($active === 'applications') aria-current="page" @endif
            class="flex flex-col items-center gap-0.5 py-1.5 px-4 rounded-xl min-w-[64px] transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 {{ $active === 'applications' ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600' }}">
            {{-- Checklist on paper: "lamaran terkirim" --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2h6" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 17l2 2 4-4" />
            </svg>
            <span class="text-[11px] font-semibold">Lamaran</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="flex" x-data="{ busy: false }" @submit="busy = true">
            @csrf
            <button type="submit" :disabled="busy" :class="busy && 'opacity-60 cursor-not-allowed'"
                class="flex flex-col items-center gap-0.5 py-1.5 px-4 rounded-xl min-w-[64px] text-slate-400 hover:text-red-600 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="text-[11px] font-semibold">Keluar</span>
            </button>
        </form>
    </div>
</nav>
