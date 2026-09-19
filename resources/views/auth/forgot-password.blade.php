<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="Pulihkan akses akun BKK Anda melalui email terdaftar.">
    <meta name="theme-color" content="#1e40af">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="manifest" href="/manifest.json">
    <title>BKK - Pemulihan Akun</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800 pwa-optimized">
    <div class="auth-shell p-6 md:p-0">
        <div class="auth-container">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('login') }}" aria-label="Kembali ke halaman masuk"
                    class="inline-flex items-center justify-center p-2 bg-white border border-slate-200/70 rounded-lg text-slate-600 hover:text-blue-600 shadow-sm border-b-2 active:border-b-0 active:translate-y-[2px] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <x-partials.logo size="sm" :withText="false" />
            </div>

            <div class="space-y-1 mb-6 text-center md:text-left">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">Lupa Kata Sandi?</h1>
                <p class="text-xs font-medium text-slate-500">Pilih metode pemulihan yang nyaman bagi Anda.</p>
            </div>

            @if (session('status'))
                <div role="status" class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-[11px] font-bold rounded-lg shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Tabs -->
            <div class="space-y-4" x-data="{ tab: 'email', busy: false }">
                <div class="flex p-1 bg-slate-100 rounded-lg border border-slate-200/50" role="tablist">
                    <button type="button" @click="tab = 'email'" :class="tab === 'email' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-500'" class="flex-1 py-2 text-[10px] font-black uppercase tracking-widest rounded-md transition-all focus:outline-none">Email</button>
                    <button type="button" @click="tab = 'phone'" :class="tab === 'phone' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-500'" class="flex-1 py-2 text-[10px] font-black uppercase tracking-widest rounded-md transition-all focus:outline-none">Nomor HP</button>
                </div>

                <!-- Email Form -->
                <div x-show="tab === 'email'" id="panel-email">
                    <form method="POST" action="{{ route('password.email') }}" class="space-y-4" @submit="busy = true">
                        @csrf
                        <div class="space-y-1">
                            <label for="email" class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Email Terdaftar</label>
                            <input type="email" name="email" id="email" required placeholder="nama@email.com"
                                class="block w-full px-3 py-2.5 bg-white border-2 border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-600 transition duration-150">
                            @error('email')
                                <p class="mt-1 text-[10px] font-bold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" :disabled="busy" class="w-full py-3 bg-blue-600 text-white font-black rounded-full shadow-md hover:bg-blue-700 transition-all text-sm">
                            Kirim Tautan Pemulihan
                        </button>
                    </form>
                </div>

                <!-- Phone Form (Firebase) -->
                <div x-show="tab === 'phone'" x-cloak id="panel-phone" x-data="{ step: 'request', phone: '', otp: '' }">
                    <div x-show="step === 'request'" class="space-y-4">
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nomor HP</label>
                            <div class="flex gap-2">
                                <span class="bg-slate-50 border-2 border-slate-200 rounded-lg px-3 flex items-center text-xs font-black text-slate-500">+62</span>
                                <input type="tel" x-model="phone" placeholder="81234567890"
                                    class="flex-1 block w-full px-3 py-2.5 bg-white border-2 border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-600 transition">
                            </div>
                        </div>
                        <div id="recaptcha-container"></div>
                        <button type="button" @click="window.sendOtp(phone, $data)" :disabled="!phone" class="w-full py-3 bg-blue-600 text-white font-black rounded-full shadow-md hover:bg-blue-700 transition-all text-sm">
                            Dapatkan Kode OTP
                        </button>
                    </div>

                    <div x-show="step === 'verify'" class="space-y-4" x-cloak>
                        <div class="text-center space-y-1">
                            <p class="text-xs font-bold text-slate-800 uppercase tracking-widest">Masukkan OTP</p>
                            <p class="text-[10px] text-slate-400 font-medium">Dikirim ke +62<span x-text="phone"></span></p>
                        </div>
                        <input type="text" x-model="otp" maxlength="6" class="w-full text-center tracking-[1em] text-xl font-black py-3 bg-slate-50 border-2 border-slate-200 rounded-lg focus:outline-none">
                        <button type="button" @click="window.verifyOtp(otp, $data)" class="w-full py-3 bg-emerald-600 text-white font-black rounded-full shadow-md hover:bg-emerald-700 transition-all text-sm">
                            Verifikasi Kode
                        </button>
                    </div>

                    <form x-show="step === 'reset'" method="POST" action="{{ route('password.phone.reset') }}" class="space-y-4" x-cloak>
                        @csrf
                        <input type="hidden" name="phone_number" :value="phone">
                        <input type="hidden" name="firebase_token" id="firebase_token" value="">
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kata Sandi Baru</label>
                            <input type="password" name="password" required class="block w-full px-3 py-2.5 bg-white border-2 border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-600 transition">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Konfirmasi Sandi</label>
                            <input type="password" name="password_confirmation" required class="block w-full px-3 py-2.5 bg-white border-2 border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-600 transition">
                        </div>
                        <button type="submit" class="w-full py-3 bg-blue-600 text-white font-black rounded-full shadow-md hover:bg-blue-700 transition-all text-sm">
                            Simpan Sandi Baru
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-8 text-center pt-6 border-t border-slate-100">
                <p class="text-xs text-slate-500 font-medium">Batal? <a href="{{ route('login') }}" class="font-black text-blue-600 hover:text-blue-700 transition">Kembali ke Login</a></p>
            </div>
        </div>
    </div>

    <!-- Firebase Scripts -->
    <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-auth-compat.js"></script>
    <script>
        const firebaseConfig = {
            apiKey: "{{ config('firebase.api_key') }}",
            authDomain: "{{ config('firebase.auth_domain') }}",
            projectId: "{{ config('firebase.project_id') }}",
            storageBucket: "{{ config('firebase.storage_bucket') }}",
            messagingSenderId: "{{ config('firebase.messaging_sender_id') }}",
            appId: "{{ config('firebase.app_id') }}"
        };
        if (firebaseConfig.apiKey) firebase.initializeApp(firebaseConfig);

        window.sendOtp = function(phoneNumber, alpineInstance) {
            const appVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', { 'size': 'invisible' });
            firebase.auth().signInWithPhoneNumber('+62' + phoneNumber, appVerifier)
                .then((confirmationResult) => {
                    window.confirmationResult = confirmationResult;
                    alpineInstance.step = 'verify';
                }).catch((error) => {
                    alert("Gagal mengirim SMS. Cek nomor & konfigurasi Firebase.");
                });
        }

        window.verifyOtp = function(otp, alpineInstance) {
            if (!window.confirmationResult) return;
            window.confirmationResult.confirm(otp).then((result) => {
                alpineInstance.step = 'reset';
                result.user.getIdToken().then(token => {
                    document.getElementById('firebase_token').value = token;
                });
            }).catch(() => alert("Kode OTP salah."));
        }
    </script>
</body>
</html>
