@props(['size' => 'md', 'withText' => true, 'inverse' => false])

@php
    $iconSizes = [
        'sm' => 'h-10 w-10',
        'md' => 'h-16 w-16',
        'lg' => 'h-24 w-24',
        'xl' => 'h-40 w-40'
    ];
    $iconSize = $iconSizes[$size] ?? $iconSizes['md'];

    $textSizes = [
        'sm' => 'text-lg',
        'md' => 'text-2xl',
        'lg' => 'text-4xl',
        'xl' => 'text-5xl'
    ];
    $textSize = $textSizes[$size] ?? $textSizes['md'];
@endphp

<div class="flex items-center gap-4 {{ $inverse ? 'text-white' : 'text-slate-900' }}">
    <!-- 3D Layered Logo Icon -->
    <div class="relative shrink-0 {{ $iconSize }} transform transition duration-300 hover:scale-105 select-none filter drop-shadow-[0_10px_15px_rgba(30,64,175,0.25)]">
        <!-- Circular 3D Background with Bevel Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full border border-blue-400/30 shadow-[inset_0_4px_6px_rgba(255,255,255,0.4),0_8px_16px_rgba(29,78,216,0.3)]"></div>

        <!-- SVG Inner Elements matching the user's specific BKK logo geometry -->
        <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 w-full h-full p-2.5 drop-shadow-[0_4px_6px_rgba(0,0,0,0.15)]">
            <!-- Orange/Gold Horizontal Base Bar -->
            <path d="M15 78H85" stroke="#f59e0b" stroke-width="4" stroke-linecap="round" class="drop-shadow-[0_2px_3px_rgba(0,0,0,0.2)]"/>

            <!-- White Human Figure Head -->
            <circle cx="50" cy="42" r="9" fill="white" />

            <!-- White Human Figure Body/Shoulders -->
            <path d="M32 70C32 58 40 54 50 54C60 54 68 58 68 70" fill="white" />

            <!-- Gold/Orange Upward Arrow above head -->
            <path d="M50 18L44 26H48V31H52V26H56L50 18Z" fill="#f59e0b" class="drop-shadow-[0_2px_4px_rgba(0,0,0,0.2)]" />

            <!-- Left bar graph indicator -->
            <rect x="23" y="60" width="5" height="12" rx="1.5" fill="#f59e0b" />
            <!-- Right bar graph indicator -->
            <rect x="72" y="52" width="5" height="20" rx="1.5" fill="#f59e0b" />
        </svg>

        <!-- Decorative Small Gold Dots on Orbit (Floating effect) -->
        <div class="absolute -right-1 top-1/3 w-2.5 h-2.5 bg-amber-400 rounded-full animate-pulse shadow-[0_0_8px_#fbbf24]"></div>
        <div class="absolute -right-3 top-1/2 w-1.5 h-1.5 bg-amber-500 rounded-full opacity-70"></div>
    </div>

    @if($withText)
        <!-- Typography Segment -->
        <div class="flex flex-col border-l-2 border-slate-300/60 pl-4 py-1 {{ $inverse ? 'border-white/30' : '' }}">
            <h1 class="{{ $textSize }} font-black tracking-tighter text-blue-900 leading-none {{ $inverse ? 'text-white' : '' }}">
                BKK
            </h1>
            <p class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-slate-500 mt-1 leading-none {{ $inverse ? 'text-blue-100' : '' }}">
                Bursa Kerja Khusus
            </p>
            <p class="text-[9px] sm:text-[10px] font-medium text-slate-400 mt-0.5 leading-none {{ $inverse ? 'text-blue-200/80' : '' }}">
                Informasi Lowongan Kerja
            </p>
        </div>
    @endif
</div>
