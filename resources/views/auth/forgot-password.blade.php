<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="Pulihkan akses akun BKK Anda melalui email terdaftar.">
    <meta name="theme-color" content="#4f46e5">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <title>BKK - Lupa Sandi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-white flex flex-col justify-between p-6 shadow-xl">

        <!-- Header -->
        <div class="mt-4">
            <a href="{{ route('login') }}" aria-label="Kembali ke halaman masuk"
                class="inline-flex items-center justify-center p-2 bg-slate-100 rounded-xl text-slate-600 hover:bg-slate-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="mt-6">
                <h1 class="text-2xl font-bold text-slate-900">Pemulihan Keamanan</h1>
                <p class="text-sm text-slate-500 mt-1">Pilih metode pemulihan akun Anda di bawah ini.</p>
            </div>
        </div>

        @if (session('status'))
            <div role="status" class="mt-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl">
                {{ session('status') }}
            </div>
        @endif

        <!-- Selection & Tabs -->
        <div class="my-auto space-y-6" x-data="{ tab: 'email', busy: false }">
            <div class="flex p-1 bg-slate-100 rounded-xl" role="tablist" aria-label="Metode pemulihan akun">
                <button type="button" role="tab" id="tab-email"
                    @click="tab = 'email'"
                    :aria-selected="tab === 'email' ? 'true' : 'false'"
                    aria-controls="panel-email"
                    :class="tab === 'email' ? 'bg-white text-indigo-600 shadow' : 'text-slate-500'"
                    class="flex-1 py-2 text-sm font-semibold rounded-lg transition duration-150">
                    Via Email
                </button>
                <button type="button" role="tab" id="tab-phone"
                    @click="tab = 'phone'"
                    :aria-selected="tab === 'phone' ? 'true' : 'false'"
                    aria-controls="panel-phone"
                    :class="tab === 'phone' ? 'bg-white text-indigo-600 shadow' : 'text-slate-500'"
                    class="flex-1 py-2 text-sm font-semibold rounded-lg transition duration-150">
                    Via No. HP
                </button>
            </div>

            <!-- Email Reset Form -->
            <div x-show="tab === 'email'" x-cloak id="panel-email" role="tabpanel" aria-labelledby="tab-email" class="space-y-4">
                <form method="POST" action="{{ route('password.email') }}" class="space-y-4" @submit="busy = true">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Alamat Email Terdaftar</label>
                        <input type="email" name="email" id="email" required
                            value="{{ old('email') }}"
                            autocomplete="email" inputmode="email" autocapitalize="none" spellcheck="false"
                            placeholder="nama@email.com"
                            @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                            class="block w-full px-4 py-3 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:bg-white transition @error('email') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-indigo-500 @enderror">
                        @error('email')
                            <p id="email-error" class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" :disabled="busy" :aria-busy="busy ? 'true' : 'false'"
                        class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-center rounded-xl shadow-lg transition disabled:opacity-60 disabled:cursor-not-allowed">
                        <span x-show="!busy">Kirim Permintaan Reset</span>
                        <span x-show="busy" x-cloak>Memproses…</span>
                    </button>
                </form>
            </div>

            <!-- Phone Reset (belum aktif) -->
            <div x-show="tab === 'phone'" x-cloak id="panel-phone" role="tabpanel" aria-labelledby="tab-phone" class="space-y-4">
                <div class="flex gap-3 p-3.5 bg-amber-50 border border-amber-200 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.74-3L13.74 4a2 2 0 00-3.48 0L3.33 16a2 2 0 001.74 3z" />
                    </svg>
                    <div class="text-xs text-amber-800 leading-relaxed">
                        <p class="font-semibold">Pemulihan via SMS belum tersedia.</p>
                        <p class="mt-1">Fitur verifikasi nomor HP sedang disiapkan. Untuk saat ini gunakan pemulihan via email, atau hubungi admin BKK sekolah Anda.</p>
                    </div>
                </div>

                <div aria-hidden="true" class="opacity-50 pointer-events-none select-none space-y-4">
                    <div>
                        <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Nomor HP Terdaftar</span>
                        <div class="flex space-x-2">
                            <span class="inline-flex items-center px-3.5 bg-slate-100 border border-slate-200 text-sm text-slate-500 rounded-xl">+62</span>
                            <input type="tel" disabled placeholder="81234567890" tabindex="-1"
                                class="flex-1 block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                        </div>
                    </div>
                    <button type="button" disabled tabindex="-1"
                        class="w-full py-3.5 px-4 bg-slate-300 text-white font-semibold text-center rounded-xl cursor-not-allowed">
                        Kirim Kode OTP via SMS
                    </button>
                </div>

                <button type="button" @click="tab = 'email'"
                    class="w-full py-3 px-4 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-center rounded-xl transition">
                    Gunakan Pemulihan via Email
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="mb-4 text-center">
            <p class="text-sm text-slate-500">Kembali ke <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Halaman Masuk</a></p>
        </div>

    </div>
</body>
</html>
