<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Tambah Lowongan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 font-sans antialiased text-slate-800">
    <div class="max-w-2xl mx-auto py-10 px-6">

        <!-- Header Nav Controls -->
        <div class="mb-6">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-blue-600 shadow-sm bg-white p-2.5 px-4 rounded-xl border border-slate-200 border-b-2 active:border-b-0 active:translate-y-[2px] transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-5">Tambah Lowongan Kerja</h1>
        </div>

        <!-- 3D Layered Card Box -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-[0_15px_35px_rgba(0,0,0,0.02)] border-b-4 border-slate-200/90">
            @if ($errors->any())
                <div role="alert" class="mb-5 p-4 bg-red-50 border border-red-200 text-red-800 text-xs font-bold rounded-2xl shadow-sm">
                    <p class="font-black uppercase tracking-wider mb-1.5 text-red-900">Periksa kembali isian berikut:</p>
                    <ul class="list-disc list-inside space-y-1 font-semibold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Auth::user()->role === 'admin' && $companies->isEmpty())
                <div role="alert" class="mb-5 p-4 bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold rounded-2xl shadow-sm">
                    Belum ada perusahaan terdaftar, sehingga lowongan belum dapat dibuat. Tambahkan data perusahaan terlebih dahulu melalui manajemen data mitra.
                </div>
            @endif

            <form method="POST" action="{{ route('jobs.store') }}" class="space-y-4" x-data="{ busy: false }" x-on:submit="busy = true">
                @csrf

                @if (Auth::user()->role === 'admin')
                    <div class="space-y-1.5">
                        <label for="company_id" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Perusahaan Mitra</label>
                        <div class="relative">
                            <select id="company_id" name="company_id" required
                                @error('company_id') aria-invalid="true" aria-describedby="company_id-error" @enderror
                                class="block w-full px-4 py-3 bg-slate-50/80 border rounded-2xl text-xs font-semibold focus:outline-none focus:bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] focus:shadow-none appearance-none transition duration-150 @error('company_id') border-red-300 focus:ring-2 focus:ring-red-100 @else border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror">
                                <option value="">&mdash; Pilih Perusahaan &mdash;</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>{{ $company->name }}</option>
                                @endforeach
                            </select>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </div>
                        @error('company_id')
                            <p id="company_id-error" class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <div class="space-y-1.5">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Judul Lowongan</label>
                    <input type="text" id="title" name="title" required maxlength="255" autocomplete="off"
                        value="{{ old('title') }}" placeholder="Contoh: Backend Developer"
                        @error('title') aria-invalid="true" aria-describedby="title-error" @enderror
                        class="block w-full px-4 py-3 bg-slate-50/80 border rounded-2xl text-xs font-semibold focus:outline-none focus:bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] focus:shadow-none transition duration-150 @error('title') border-red-300 focus:ring-2 focus:ring-red-100 @else border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror">
                    @error('title')
                        <p id="title-error" class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="location" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Lokasi Penempatan</label>
                        <input type="text" id="location" name="location" required maxlength="255" autocomplete="address-level2"
                            value="{{ old('location') }}" placeholder="Jakarta / Remote"
                            @error('location') aria-invalid="true" aria-describedby="location-error" @enderror
                            class="block w-full px-4 py-3 bg-slate-50/80 border rounded-2xl text-xs font-semibold focus:outline-none focus:bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] focus:shadow-none transition duration-150 @error('location') border-red-300 focus:ring-2 focus:ring-red-100 @else border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror">
                        @error('location')
                            <p id="location-error" class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="salary" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Estimasi Gaji (Opsional)</label>
                        <input type="text" id="salary" name="salary" maxlength="255" autocomplete="off"
                            value="{{ old('salary') }}" placeholder="Rp 8.000.000 - Rp 12.000.000"
                            @error('salary') aria-invalid="true" aria-describedby="salary-error" @enderror
                            class="block w-full px-4 py-3 bg-slate-50/80 border rounded-2xl text-xs font-semibold focus:outline-none focus:bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] focus:shadow-none transition duration-150 @error('salary') border-red-300 focus:ring-2 focus:ring-red-100 @else border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror">
                        @error('salary')
                            <p id="salary-error" class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Deskripsi Pekerjaan</label>
                    <textarea id="description" name="description" rows="4" required placeholder="Jelaskan tanggung jawab dan detail pekerjaan..."
                        @error('description') aria-invalid="true" aria-describedby="description-error" @enderror
                        class="block w-full px-4 py-3 bg-slate-50/80 border rounded-2xl text-xs font-semibold focus:outline-none focus:bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] focus:shadow-none transition duration-150 @error('description') border-red-300 focus:ring-2 focus:ring-red-100 @else border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p id="description-error" class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="requirements" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Kualifikasi / Persyaratan</label>
                    <textarea id="requirements" name="requirements" rows="4" required placeholder="Tuliskan kualifikasi dan persyaratan..."
                        @error('requirements') aria-invalid="true" aria-describedby="requirements-error" @enderror
                        class="block w-full px-4 py-3 bg-slate-50/80 border rounded-2xl text-xs font-semibold focus:outline-none focus:bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] focus:shadow-none transition duration-150 @error('requirements') border-red-300 focus:ring-2 focus:ring-red-100 @else border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror">{{ old('requirements') }}</textarea>
                    @error('requirements')
                        <p id="requirements-error" class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Status Publikasi</label>
                    <div class="relative">
                        <select id="status" name="status" required
                            @error('status') aria-invalid="true" aria-describedby="status-error" @enderror
                            class="block w-full px-4 py-3 bg-slate-50/80 border rounded-2xl text-xs font-semibold focus:outline-none focus:bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] focus:shadow-none appearance-none transition duration-150 @error('status') border-red-300 focus:ring-2 focus:ring-red-100 @else border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror">
                            <option value="open" @selected(old('status', 'open') === 'open')>Aktif (Langsung Dibuka)</option>
                            <option value="pending" @selected(old('status') === 'pending')>Menunggu Persetujuan</option>
                            <option value="closed" @selected(old('status') === 'closed')>Ditutup</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </div>
                    @error('status')
                        <p id="status-error" class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Tactile 3D Button -->
                <button type="submit" :disabled="busy" :class="busy && 'opacity-60 cursor-not-allowed'"
                    class="w-full py-4 px-6 bg-gradient-to-b from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-bold rounded-2xl shadow-[0_8px_20px_rgba(29,78,216,0.25)] border-b-4 border-blue-900 active:border-b-0 active:translate-y-[4px] transition-all duration-150 text-xs font-black uppercase tracking-wider mt-2">
                    <span x-show="!busy">Simpan & Terbitkan Lowongan</span>
                    <span x-show="busy" x-cloak>Menyimpan...</span>
                </button>
            </form>
        </div>

    </div>
</body>
</html>
