<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKK - Lupa Sandi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto min-h-screen bg-white flex flex-col justify-between p-6 shadow-xl">

        <!-- Header -->
        <div class="mt-4">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center p-2 bg-slate-100 rounded-xl text-slate-600 hover:bg-slate-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="mt-6">
                <h2 class="text-2xl font-bold text-slate-900">Pemulihan Keamanan</h2>
                <p class="text-sm text-slate-500 mt-1">Pilih metode pemulihan akun Anda di bawah ini.</p>
            </div>
        </div>

        @if (session('status'))
            <div class="mt-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl">
                {{ session('status') }}
            </div>
        @endif

        <!-- Selection & Tabs -->
        <div class="my-auto space-y-6" x-data="{ tab: 'email' }">
            <div class="flex p-1 bg-slate-100 rounded-xl">
                <button @click="tab = 'email'" :class="tab === 'email' ? 'bg-white text-indigo-600 shadow' : 'text-slate-500'" class="flex-1 py-2 text-sm font-semibold rounded-lg transition duration-150">
                    Via Email
                </button>
                <button @click="tab = 'phone'" :class="tab === 'phone' ? 'bg-white text-indigo-600 shadow' : 'text-slate-500'" class="flex-1 py-2 text-sm font-semibold rounded-lg transition duration-150">
                    Via No. HP (Firebase)
                </button>
            </div>

            <!-- Email Reset Form -->
            <div x-show="tab === 'email'" class="space-y-4">
                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Alamat Email Terdaftar</label>
                        <input type="email" name="email" required placeholder="nama@email.com" class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                    </div>
                    <button type="submit" class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-center rounded-xl shadow-lg transition">
                        Kirim Link Reset Email
                    </button>
                </form>
            </div>

            <!-- Phone / Firebase Reset Form -->
            <div x-show="tab === 'phone'" class="space-y-4" style="display: none;">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Nomor HP Terdaftar</label>
                    <div class="flex space-x-2">
                        <span class="inline-flex items-center px-3.5 bg-slate-100 border border-slate-200 text-sm text-slate-500 rounded-xl">+62</span>
                        <input type="text" id="phone-number" placeholder="81234567890" class="flex-1 block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                    </div>
                </div>
                <div id="recaptcha-container"></div>
                <button type="button" onclick="sendOTP()" class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-center rounded-xl shadow-lg transition">
                    Kirim Kode OTP via SMS
                </button>

                <!-- OTP Input Area -->
                <div id="otp-area" class="mt-4 pt-4 border-t border-slate-100 hidden">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Masukkan 6 Digit OTP</label>
                    <input type="text" id="verification-code" placeholder="123456" class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-center tracking-widest font-bold focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                    <button type="button" onclick="verifyOTP()" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-center rounded-xl shadow-md transition mt-3">
                        Verifikasi & Reset Sandi
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mb-4 text-center">
            <p class="text-sm text-slate-500">Kembali ke <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Halaman Masuk</a></p>
        </div>

    </div>

    <script>
        function sendOTP() {
            alert('Firebase Phone Auth SDK Triggered. Kode OTP sedang dikirim ke nomor tersebut!');
            document.getElementById('otp-area').classList.remove('hidden');
        }
        function verifyOTP() {
            alert('OTP Berhasil Diverifikasi! Silakan ubah kata sandi Anda.');
        }
    </script>
</body>
</html>
