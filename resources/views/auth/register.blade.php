<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKK - Daftar Akun</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-white flex flex-col justify-between p-6 shadow-xl">

        <!-- Header -->
        <div class="mt-2">
            <a href="{{ route('introduction') }}" class="inline-flex items-center justify-center p-2 bg-slate-100 rounded-xl text-slate-600 hover:bg-slate-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="mt-4">
                <h2 class="text-2xl font-bold text-slate-900">Buat Akun Baru</h2>
                <p class="text-sm text-slate-500 mt-1">Gabung sekarang untuk mulai melamar pekerjaan.</p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('register.post') }}" class="my-auto space-y-3.5">
            @csrf

            @if ($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Nama Lengkap</label>
                <input type="text" name="name" required placeholder="John Doe" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Alamat Email</label>
                <input type="email" name="email" required placeholder="nama@email.com" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Nomor HP / WhatsApp</label>
                <input type="text" name="phone_number" required placeholder="081234567890" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Daftar Sebagai</label>
                <select name="role" required class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                    <option value="applicant">Alumni / Pencari Kerja Publik</option>
                    <option value="company">Perusahaan / Penyedia Kerja</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Kata Sandi</label>
                <input type="password" name="password" required placeholder="••••••••" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-center rounded-xl shadow-lg shadow-indigo-100 transition duration-200 mt-2">
                Daftar Akun
            </button>
        </form>

        <!-- Footer -->
        <div class="mb-2 text-center">
            <p class="text-sm text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Masuk di Sini</a></p>
        </div>

    </div>
</body>
</html>
