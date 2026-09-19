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
    <div class="auth-shell">
        <div class="auth-container min-h-screen md:min-h-[auto] flex flex-col justify-between p-6 relative overflow-hidden">

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

            <!-- Phone Reset (3D Card with Firebase Integration) -->
            <div x-show="tab === 'phone'" x-cloak id="panel-phone" role="tabpanel" aria-labelledby="tab-phone" class="space-y-4"
                 x-data="{ step: 'request', phone: '', otp: '', loading: false, confirmationResult: null }">

                <div x-show="step === 'request'" class="space-y-4">
                    <div class="flex gap-3 p-4 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200/70 rounded-2xl shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-xs text-blue-800 leading-relaxed">
                            <p class="font-bold">Verifikasi Cepat via WhatsApp/SMS</p>
                            <p class="text-slate-600">Masukkan nomor HP Anda yang terdaftar untuk menerima kode OTP keamanan.</p>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <span class="block text-xs font-bold uppercase tracking-wider text-slate-400">Nomor HP Terdaftar</span>
                        <div class="flex space-x-2">
                            <span class="inline-flex items-center px-4 bg-slate-100 border border-slate-200 text-sm text-slate-500 font-semibold rounded-2xl shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">+62</span>
                            <input type="tel" x-model="phone" placeholder="81234567890"
                                class="flex-1 block w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)] focus:outline-none focus:bg-white focus:border-blue-500 transition">
                        </div>
                    </div>

                    <div id="recaptcha-container"></div>

                    <button type="button" @click="window.sendOtp(phone, $data)" :disabled="!phone"
                        class="w-full py-4 px-6 bg-gradient-to-b from-blue-600 to-blue-700 text-white font-bold text-center rounded-2xl shadow-[0_8px_20px_rgba(29,78,216,0.25)] border-b-4 border-blue-900 active:border-b-0 active:translate-y-[4px] transition-all duration-150 disabled:opacity-50">
                        Kirim Kode OTP
                    </button>
                </div>

                <div x-show="step === 'verify'" class="space-y-4" x-cloak>
                    <div class="space-y-1.5 text-center">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Masukkan Kode OTP</h3>
                        <p class="text-xs text-slate-500">Kode telah dikirim ke +62<span x-text="phone"></span></p>
                    </div>

                    <input type="text" x-model="otp" maxlength="6" placeholder="000000"
                        class="block w-full text-center tracking-[1em] text-xl font-black py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl shadow-inner focus:outline-none focus:border-blue-500 transition">

                    <button type="button" @click="window.verifyOtp(otp, $data)"
                        class="w-full py-4 px-6 bg-emerald-600 text-white font-bold text-center rounded-2xl shadow-md border-b-4 border-emerald-800 active:border-b-0 active:translate-y-[4px] transition-all">
                        Verifikasi & Lanjut
                    </button>

                    <button type="button" @click="step = 'request'" class="w-full text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-slate-600">
                        Kirim Ulang Kode
                    </button>
                </div>

                <!-- Final Reset Form after Phone Verified -->
                <form x-show="step === 'reset'" method="POST" action="{{ route('password.phone.reset') }}" class="space-y-4" x-cloak>
                    @csrf
                    <input type="hidden" name="phone_number" :value="phone">
                    <input type="hidden" name="firebase_token" id="firebase_token" value="verified_session">

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Kata Sandi Baru</label>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="block w-full px-4 py-3.5 bg-slate-50/80 border rounded-2xl text-sm focus:outline-none focus:bg-white shadow-inner">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" required placeholder="••••••••"
                            class="block w-full px-4 py-3.5 bg-slate-50/80 border rounded-2xl text-sm focus:outline-none focus:bg-white shadow-inner">
                    </div>

                    <button type="submit"
                        class="w-full py-4 px-6 bg-gradient-to-b from-blue-600 to-blue-700 text-white font-bold text-center rounded-2xl shadow-lg border-b-4 border-blue-900 active:border-b-0 active:translate-y-[4px] transition-all">
                        Simpan Sandi Baru
                    </button>
                </form>

            </div>
        </div>

        <!-- Firebase & Auth Logic -->
        <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-app-compat.js"></script>
        <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-auth-compat.js"></script>
        <script>
            // Initialize Firebase with env variables passed from Laravel
            const firebaseConfig = {
                apiKey: "{{ config('firebase.api_key') }}",
                authDomain: "{{ config('firebase.auth_domain') }}",
                projectId: "{{ config('firebase.project_id') }}",
                storageBucket: "{{ config('firebase.storage_bucket') }}",
                messagingSenderId: "{{ config('firebase.messaging_sender_id') }}",
                appId: "{{ config('firebase.app_id') }}"
            };

            if (firebaseConfig.apiKey) {
                firebase.initializeApp(firebaseConfig);
            }

            // This would be triggered by Alpine
            window.sendOtp = function(phoneNumber, alpineInstance) {
                const appVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
                    'size': 'invisible'
                });

                firebase.auth().signInWithPhoneNumber('+62' + phoneNumber, appVerifier)
                    .then((confirmationResult) => {
                        window.confirmationResult = confirmationResult;
                        alpineInstance.step = 'verify';
                    }).catch((error) => {
                        console.error("SMS Error:", error);
                        alert("Gagal mengirim SMS. Pastikan nomor benar dan konfigurasi Firebase aktif.");
                    });
            }

            window.verifyOtp = function(otp, alpineInstance) {
                if (!window.confirmationResult) return;
                window.confirmationResult.confirm(otp).then((result) => {
                    const user = result.user;
                    alpineInstance.step = 'reset';
                    // Optional: Get token and put in hidden field for backend verification
                    user.getIdToken().then(token => {
                        document.getElementById('firebase_token').value = token;
                    });
                }).catch((error) => {
                    alert("Kode OTP salah atau kedaluwarsa.");
                });
            }
        </script>
        </div>

        <!-- Footer -->
        <div class="mb-4 text-center">
            <p class="text-sm text-slate-500 font-medium">Kembali ke <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700 transition">Halaman Masuk</a></p>
        </div>

    </div>
</body>
</html>
