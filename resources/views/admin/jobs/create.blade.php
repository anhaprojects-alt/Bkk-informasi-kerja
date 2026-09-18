<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Tambah Lowongan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans antialiased text-slate-800">
    <div class="max-w-2xl mx-auto py-10 px-6">

        <div class="mb-6">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-indigo-600 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900 mt-4">Tambah Lowongan Kerja</h1>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            @if ($errors->any())
                <div role="alert" class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl">
                    <p class="font-semibold mb-1">Periksa kembali isian berikut:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Auth::user()->role === 'admin' && $companies->isEmpty())
                <div role="alert" class="mb-4 p-3 bg-amber-50 border border-amber-200 text-amber-700 text-xs rounded-xl">
                    Belum ada perusahaan terdaftar, sehingga lowongan belum dapat dibuat. Tambahkan data perusahaan terlebih dahulu.
                </div>
            @endif

            <form method="POST" action="{{ route('jobs.store') }}" class="space-y-4" x-data="{ busy: false }" x-on:submit="busy = true">
                @csrf

                @if (Auth::user()->role === 'admin')
                    <div>
                        <label for="company_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Perusahaan</label>
                        <select id="company_id" name="company_id" required
                            @error('company_id') aria-invalid="true" aria-describedby="company_id-error" @enderror
                            class="block w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:bg-white transition @error('company_id') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-indigo-500 @enderror">
                            <option value="">&mdash; Pilih Perusahaan &mdash;</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id')
                            <p id="company_id-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <div>
                    <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Judul Lowongan</label>
                    <input type="text" id="title" name="title" required maxlength="255" autocomplete="off"
                        value="{{ old('title') }}" placeholder="Contoh: Backend Developer"
                        @error('title') aria-invalid="true" aria-describedby="title-error" @enderror
                        class="block w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:bg-white transition @error('title') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-indigo-500 @enderror">
                    @error('title')
                        <p id="title-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="location" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Lokasi</label>
                        <input type="text" id="location" name="location" required maxlength="255" autocomplete="address-level2"
                            value="{{ old('location') }}" placeholder="Jakarta / Remote"
                            @error('location') aria-invalid="true" aria-describedby="location-error" @enderror
                            class="block w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:bg-white transition @error('location') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-indigo-500 @enderror">
                        @error('location')
                            <p id="location-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="salary" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Gaji (Opsional)</label>
                        <input type="text" id="salary" name="salary" maxlength="255" autocomplete="off"
                            value="{{ old('salary') }}" placeholder="Rp 8.000.000 - Rp 12.000.000"
                            @error('salary') aria-invalid="true" aria-describedby="salary-error" @enderror
                            class="block w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:bg-white transition @error('salary') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-indigo-500 @enderror">
                        @error('salary')
                            <p id="salary-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Deskripsi Pekerjaan</label>
                    <textarea id="description" name="description" rows="4" required placeholder="Jelaskan tanggung jawab dan detail pekerjaan..."
                        @error('description') aria-invalid="true" aria-describedby="description-error" @enderror
                        class="block w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:bg-white transition @error('description') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-indigo-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p id="description-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="requirements" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Persyaratan</label>
                    <textarea id="requirements" name="requirements" rows="4" required placeholder="Tuliskan kualifikasi dan persyaratan..."
                        @error('requirements') aria-invalid="true" aria-describedby="requirements-error" @enderror
                        class="block w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:bg-white transition @error('requirements') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-indigo-500 @enderror">{{ old('requirements') }}</textarea>
                    @error('requirements')
                        <p id="requirements-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Status</label>
                    <select id="status" name="status" required
                        @error('status') aria-invalid="true" aria-describedby="status-error" @enderror
                        class="block w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:bg-white transition @error('status') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-indigo-500 @enderror">
                        <option value="open" @selected(old('status', 'open') === 'open')>Aktif (Dibuka)</option>
                        <option value="pending" @selected(old('status') === 'pending')>Menunggu</option>
                        <option value="closed" @selected(old('status') === 'closed')>Ditutup</option>
                    </select>
                    @error('status')
                        <p id="status-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" :disabled="busy" :class="busy && 'opacity-60 cursor-not-allowed'"
                    class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-100 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                    <span x-show="!busy">Simpan Lowongan</span>
                    <span x-show="busy" x-cloak>Menyimpan...</span>
                </button>
            </form>
        </div>

    </div>
</body>
</html>
