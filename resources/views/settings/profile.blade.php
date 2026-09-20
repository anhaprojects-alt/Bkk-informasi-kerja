<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Pengaturan Profil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800">
    <div class="min-h-screen flex flex-col">

        <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <a href="{{ Auth::user()->role === 'applicant' ? route('applicant.dashboard') : route('dashboard') }}" class="text-slate-500 hover:text-blue-600 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <h1 class="text-lg font-black text-slate-900 tracking-tight uppercase">Edit Profil Akun</h1>
            </div>
            <x-partials.logo size="sm" :withText="false" />
        </header>

        <main class="flex-1 max-w-3xl mx-auto w-full p-6">
            @if (session('status'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-2xl shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="glass-card p-8 bg-white">
                <form method="POST" action="{{ route('settings.profile.update') }}" enctype="multipart/form-data" class="space-y-6" x-data="{ busy: false }" @submit="busy = true">
                    @csrf @method('PUT')

                    <div class="flex items-center gap-5 pb-6 border-b border-slate-100">
                        <div class="relative">
                            <img src="{{ $user->avatar_url }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-md">
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Foto Profil</p>
                            <input type="file" name="avatar" accept="image/*" class="mt-2 block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 file:font-black">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Banner Latar</label>
                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                            <img src="{{ $user->banner_url }}" alt="Banner" class="h-32 w-full object-cover">
                        </div>
                        <input type="file" name="banner" accept="image/*" class="mt-2 block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-slate-100 file:text-slate-700 file:font-black">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                        @error('name') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Headline Profesional</label>
                        <input type="text" name="headline" value="{{ old('headline', $user->headline) }}" placeholder="Contoh: Laravel Developer | UI Enthusiast"
                            class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                        @error('headline') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Ringkasan / Bio</label>
                        <textarea name="bio" rows="4" placeholder="Ceritakan pengalaman dan target karier Anda..." class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Provinsi</label>
                            <input type="text" name="province" value="{{ old('province', $user->province) }}" placeholder="DKI Jakarta"
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                            @error('province') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kota</label>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="Jakarta Selatan"
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                            @error('city') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Lokasi Detail</label>
                            <input type="text" name="location" value="{{ old('location', $user->location) }}" placeholder="Jakarta Selatan / Remote"
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                            @error('location') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    @if ($user->role === 'company')
                        <div class="space-y-5 border border-blue-100 rounded-2xl p-6 bg-blue-50/40" x-data="{ mapAddress: @js(old('company_address', $user->company?->address ?? '')) }">
                            <div>
                                <p class="text-xs font-black text-slate-900 uppercase tracking-widest">Profil Perusahaan & Lokasi</p>
                                <p class="text-[11px] text-slate-500 mt-1">Alamat ini digunakan untuk menampilkan lokasi perusahaan pada peta lowongan.</p>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Perusahaan</label>
                                <input type="text" name="company_name" value="{{ old('company_name', $user->company?->name ?? $user->name) }}" required
                                    class="block w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                                @error('company_name') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Alamat Lengkap Perusahaan</label>
                                <textarea name="company_address" rows="3" required x-model="mapAddress"
                                    placeholder="Contoh: Jl. Jenderal Sudirman No.  kav. 52-53, Senayan, Jakarta Selatan, DKI Jakarta"
                                    class="block w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition"></textarea>
                                <p class="text-[10px] text-slate-500">Gunakan alamat lengkap beserta kota dan provinsi agar titik peta lebih akurat.</p>
                                @error('company_address') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="rounded-xl overflow-hidden border-2 border-white shadow-md bg-slate-200 h-64">
                                <iframe
                                    class="w-full h-full"
                                    frameborder="0"
                                    scrolling="no"
                                    loading="lazy"
                                    :src="'https://maps.google.com/maps?q=' + encodeURIComponent(mapAddress || 'Indonesia') + '&t=&z=15&ie=UTF8&iwloc=&output=embed'"
                                    title="Pratinjau lokasi perusahaan">
                                </iframe>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Deskripsi Perusahaan</label>
                                    <textarea name="company_description" rows="3"
                                        class="block w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">{{ old('company_description', $user->company?->description ?? '') }}</textarea>
                                    @error('company_description') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Website Perusahaan</label>
                                    <input type="url" name="company_website" value="{{ old('company_website', $user->company?->website ?? '') }}" placeholder="https://perusahaan.com"
                                        class="block w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                                    @error('company_website') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                            @error('email') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nomor HP</label>
                            <input type="tel" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                            @error('phone_number') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-4 border border-dashed border-slate-200 rounded-2xl p-6 bg-slate-50/40">
                        <div class="flex items-center justify-between">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Curriculum Vitae (CV)</label>
                            @if ($user->cv_path)
                                <span class="text-[10px] font-black uppercase text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Sudah Terunggah</span>
                            @endif
                        </div>

                        <input type="file" name="cv" accept=".pdf" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-indigo-50 file:text-indigo-700 file:font-black">

                        @if ($user->cv_path)
                            <div class="mt-4 space-y-3">
                                <div class="flex items-center justify-between bg-white p-3 rounded-xl border border-slate-200 shadow-sm">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <svg class="h-6 w-6 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                        <span class="text-xs font-bold text-slate-700 truncate">{{ $user->cv_name }}</span>
                                    </div>
                                    <a href="{{ Storage::url($user->cv_path) }}" target="_blank" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline shrink-0">Download</a>
                                </div>

                                <!-- Intelligent Smart Preview -->
                                <div class="rounded-xl overflow-hidden border border-slate-200 bg-slate-800 shadow-inner group relative h-[400px]">
                                    <div class="absolute inset-0 flex items-center justify-center text-slate-500 opacity-20 group-hover:opacity-10 transition-opacity pointer-events-none">
                                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <iframe src="{{ Storage::url($user->cv_path) }}" class="w-full h-full border-none relative z-10" loading="lazy"></iframe>
                                </div>
                            </div>
                        @else
                            <p class="text-[10px] text-slate-400 font-medium italic">Unggah file PDF CV Anda untuk memudahkan HRD dalam meninjau profil Anda.</p>
                        @endif
                        @error('cv') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-6 border-t border-slate-100 space-y-6">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Ubah Kata Sandi (Kosongkan jika tidak ingin mengubah)</p>

                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kata Sandi Baru</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter"
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition">
                            @error('password') <p class="text-[10px] font-bold text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Konfirmasi Sandi Baru</label>
                            <input type="password" name="password_confirmation"
                                class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition">
                        </div>
                    </div>

                    <button type="submit" :disabled="busy"
                        class="w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all text-sm uppercase tracking-widest">
                        <span x-show="!busy">Simpan Perubahan Profil</span>
                        <span x-show="busy">Memproses...</span>
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
