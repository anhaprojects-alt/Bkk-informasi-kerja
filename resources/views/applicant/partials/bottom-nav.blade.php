@php $active = $active ?? 'jobs'; @endphp
<nav class="sticky bottom-0 bg-white border-t border-slate-200">
    <div class="flex items-center justify-around px-4 py-2">
        <a href="{{ route('jobs.index') }}" class="flex flex-col items-center gap-0.5 py-1.5 px-4 rounded-xl {{ $active === 'jobs' ? 'text-indigo-600' : 'text-slate-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span class="text-[11px] font-semibold">Lowongan</span>
        </a>
        <a href="{{ route('applications.mine') }}" class="flex flex-col items-center gap-0.5 py-1.5 px-4 rounded-xl {{ $active === 'applications' ? 'text-indigo-600' : 'text-slate-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h.01M9 16h6" />
            </svg>
            <span class="text-[11px] font-semibold">Lamaran</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="flex">
            @csrf
            <button type="submit" class="flex flex-col items-center gap-0.5 py-1.5 px-4 rounded-xl text-slate-400 hover:text-red-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="text-[11px] font-semibold">Keluar</span>
            </button>
        </form>
    </div>
</nav>
