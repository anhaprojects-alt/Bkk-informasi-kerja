<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Atur Ulang Kata Sandi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-slate-50 flex flex-col justify-between p-6 shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-x border-slate-200/50">

        <!-- Header -->
        <div class="mt-2">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-white border border-slate-200 rounded-xl shadow-sm">
                    <x-partials.logo size="sm" :withText="false" />
                </div>
            </div>
            <div class="mt-6 space-y-1">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Atur Ulang Sandi</h1>
                <p class="text-sm text-slate-500 font-medium">Silakan masukkan kata sandi baru Anda.</p>
            </div>
        </div>

        <!-- Form Card -->
        <form method="POST" action="{{ route('password.update') }}" class="my-auto space-y-5 bg-white p-5 rounded-3xl border border-slate-200/60 shadow-[0_10px_30px_rgba(0,0,0,0.04)]"
            x-data="{ busy: false }" @submit="busy = true">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Konfirmasi Email</label>
                <input type="email" name="email" id="email" required autofocus
                    value="{{ old('email', request()->email) }}"
                    class="block w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none shadow-inner">
                @error('email')
                    <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Kata Sandi Baru</label>
                <input type="password" name="password" id="password" required
                    class="block w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none shadow-inner">
                @error('password')
                    <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Konfirmasi Sandi Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="block w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none shadow-inner">
            </div>

            <button type="submit" :disabled="busy"
                class="w-full py-4 px-6 bg-gradient-to-b from-blue-600 to-blue-700 text-white font-bold text-center rounded-2xl shadow-lg border-b-4 border-blue-900 active:border-b-0 active:translate-y-[4px] transition-all">
                <span x-show="!busy">Perbarui Kata Sandi</span>
                <span x-show="busy" x-cloak>Memproses...</span>
            </button>
        </form>

        <div class="mb-4 text-center">
            <p class="text-sm text-slate-500 font-medium">Batal? <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700">Kembali ke Login</a></p>
        </div>

    </div>
</body>
</html>
