<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="manifest" href="/manifest.json">
    <title>BKK - Atur Ulang Kata Sandi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800 pwa-optimized">
    <div class="auth-shell">
        <div class="auth-container min-h-screen md:min-h-[auto] flex flex-col p-8 relative">
            <div class="flex items-center justify-between mb-8">
                <x-partials.logo size="sm" :withText="false" />
            </div>

            <div class="space-y-1 mb-8">
                <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Keamanan Akun</h1>
                <p class="text-sm text-slate-500 font-medium">Silakan buat kata sandi baru yang kuat.</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6" x-data="{ busy: false }" @submit="busy = true">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-black uppercase tracking-widest text-slate-400">Email Konfirmasi</label>
                    <input type="email" name="email" id="email" required value="{{ old('email', request()->email) }}"
                        class="block w-full px-4 py-4 bg-white border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition">
                    @error('email') <p class="mt-1.5 text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-black uppercase tracking-widest text-slate-400">Kata Sandi Baru</label>
                    <input type="password" name="password" id="password" required
                        class="block w-full px-4 py-4 bg-white border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition">
                    @error('password') <p class="mt-1.5 text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="password_confirmation" class="block text-xs font-black uppercase tracking-widest text-slate-400">Ulangi Sandi Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="block w-full px-4 py-4 bg-white border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition">
                </div>

                <button type="submit" :disabled="busy" class="w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg hover:bg-blue-700 transition-all mt-4">
                    <span x-show="!busy">Perbarui Kata Sandi</span>
                    <span x-show="busy" x-cloak>Memproses...</span>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
