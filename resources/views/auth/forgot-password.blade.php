<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="Pulihkan akses akun BKK Anda melalui email terdaftar.">
    <meta name="theme-color" content="#1e40af">
    <link class="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <title>BKK - Lupa Sandi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-slate-50 flex flex-col justify-between p-6 shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-x border-slate-200/50">

        <!-- Header Controls & Logo -->
        <div class="mt-2">
            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" aria-label="Kembali ke halaman masuk"
                    class="inline-flex items-center justify-center p-3 bg-white border border-slate-200/70 rounded-xl text-slate-600 hover:text-blue-600 shadow-sm border-b-2 active:border-b-0 active:translate-y-[2px] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <x-partials.logo size="sm" :withText="false" />
            </div>
            <div class="mt-6 space-y-1">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pemulihan Keamanan</h1>
                <p class="text-sm text-slate-500 font-medium">Pilih metode pemulihan akun Anda di bawah ini.</p>
            </div>
        </div>

        @if (session('status'))
            <div role="status" class="mt-4 p-3.5 bg-gradient-to-r from-emerald-50 to-emerald-100/50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl shadow-sm">
                {{ session('status') }}
            </div>
        @endif

        <!-- Selection & Tabs (3D Layered Dock) -->
        <div class="my-auto space-y-5 bg-white p-5 rounded-3xl border border-slate-200/60 shadow-[0_10px_30px_rgba(0,0,0,0.04)]" x-data="{ tab: 'email', busy: false }">
            <div class="flex p-1.5 bg-slate-100/80 rounded-2xl shadow-[inset_0_2px_4px_rgba(0,0,0,0.04)] border border-slate-200/30" role="tablist" aria-label="Metode pemulihan akun">
                <button type="button" role="tab" id="tab-email"
                    @click="tab = 'email'"
                    :aria-selected="tab === 'email' ? 'true' : 'false'"
                    aria-controls="panel-email"
                    :class="tab === 'email' ? 'bg-white text-blue-700 shadow-sm font-bold border border-slate-200/50' : 'text-slate-500 font-medium'"
                    class="flex-1 py-2.5 text-xs tracking-wide rounded-xl transition duration-150 focus:outline-none">
                    Via Email
                </button>
                <button type="button" role="tab" id="tab-phone"
                    @click="tab = 'phone'"
                    :aria-selected="tab === 'phone' ? 'true' : 'false'"
                    aria-controls="panel-phone"
                    :class="tab === 'phone' ? 'bg-white text-blue-700 shadow-sm font-bold border border-slate-200/50' : 'text-slate-500 font-medium'"
                    class="flex-1 py-2.5 text-xs tracking-wide rounded-xl transition duration-150 focus:outline-none">
                    Via No. HP
                </button>
            </div>

            <!-- Email Reset Form -->
            <div x-show="tab === 'email'" id="panel-email" role="tabpanel" aria-labelledby="tab-email" class="space-y-4">
                <form method="POST" action="{{ route('password.email') }}" class="space-y-4" @submit="busy = true">
                    @csrf
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Alamat Email Terdaftar</label>
                        <input type="email" name="email" id="email" required
                            value="{{ old('email') }}"
                            autocomplete="email" inputmode="email" autocapitalize="none" spellcheck="false"
                            placeholder="nama@email.com"
                            @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                            class="block w-full px-4 py-3.5 bg-slate-50/80 border rounded-2xl text-sm focus:outline-none focus:bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] focus:shadow-none transition duration-150 @error('email') border-red-300 focus:ring-2 focus:ring-red-100 @else border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror">
                        @error('email')
                            <p id="email-error" class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" :disabled="busy" :aria-busy="busy ? 'true' : 'false'"
                        class="w-full py-4 px-6 bg-gradient-to-b from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-bold text-center rounded-2xl shadow-[0_8px_20px_rgba(29,78,216,0.25)] border-b-4 border-blue-900 active:border-b-0 active:translate-y-[4px] transition-all duration-150 disabled:opacity-60 disabled:cursor-not-allowed">
                        <span x-show="!busy">Kirim Permintaan Reset</span>
                        <span x-show="busy" x-cloak>Memproses…</span>
                    </button>
                </form>
            </div>

            <!-- Phone Reset (3D Card Warning Alert) -->
            <div x-show="tab === 'phone'" x-cloak id="panel-phone" role="tabpanel" aria-labelledby="tab-phone" class="space-y-4">
                <div class="flex gap-3 p-4 bg-gradient-to-br from-amber-50 to-amber-100/30 border border-amber-200/70 rounded-2xl shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.74-3L13.74 4a2 2 0 00-3.48 0L3.33 16a2 2 0 001.74 3z" />
                    </svg>
                    <div class="text-xs text-amber-800 leading-relaxed space-y-1">
                        <p class="font-bold">Pemulihan via SMS belum tersedia.</p>
                        <p class="text-slate-600">Fitur verifikasi nomor HP sedang disiapkan. Untuk saat ini gunakan pemulihan via email, atau hubungi admin BKK sekolah Anda.</p>
                    </div>
                </div>

                <div aria-hidden="true" class="opacity-40 pointer-events-none select-none space-y-4">
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Nomor HP Terdaftar</span>
                        <div class="flex space-x-2">
                            <span class="inline-flex items-center px-4 bg-slate-100 border border-slate-200 text-sm text-slate-500 font-semibold rounded-2xl shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">+62</span>
                            <input type="tel" disabled placeholder="81234567890" tabindex="-1"
                                class="flex-1 block w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">
                        </div>
                    </div>
                    <button type="button" disabled tabindex="-1"
                        class="w-full py-4 px-6 bg-slate-300 text-white font-bold text-center rounded-2xl border-b-4 border-slate-400">
                        Kirim Kode OTP via SMS
                    </button>
                </div>

                <button type="button" @click="tab = 'email'"
                    class="w-full py-3.5 px-6 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold text-center rounded-2xl border border-slate-200/80 shadow-sm border-b-2 active:border-b-0 active:translate-y-[2px] transition-all">
                    Gunakan Pemulihan via Email
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="mb-4 text-center">
            <p class="text-sm text-slate-500 font-medium">Kembali ke <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700 transition">Halaman Masuk</a></p>
        </div>

    </div>
</body>
</html>
