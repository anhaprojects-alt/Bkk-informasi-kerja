<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Edit Lowongan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800">
    <div class="max-w-2xl mx-auto py-10 px-6">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-blue-600 bg-white p-2.5 px-4 rounded-xl border border-slate-200 border-b-2 active:border-b-0 active:translate-y-[2px] transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-5 uppercase">Edit Lowongan Kerja</h1>
        </div>

        <div class="glass-card p-8 bg-white border-b-4 border-blue-600">
            <form method="POST" action="{{ route('jobs.update', $jobListing) }}" class="space-y-6" x-data="{ busy: false }" @submit="busy = true">
                @csrf @method('PUT')

                @if (Auth::user()->role === 'admin')
                    <div class="space-y-1.5">
                        <label for="company_id" class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Perusahaan Mitra</label>
                        <select id="company_id" name="company_id" required class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition appearance-none">
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" {{ $jobListing->company_id == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="space-y-1.5">
                    <label for="title" class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Judul Lowongan</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $jobListing->title) }}" required maxlength="255" class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label for="location" class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Lokasi Penempatan</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $jobListing->location) }}" required maxlength="255" class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                    </div>
                    <div class="space-y-1.5">
                        <label for="salary" class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Estimasi Gaji</label>
                        <input type="text" id="salary" name="salary" value="{{ old('salary', $jobListing->salary) }}" maxlength="255" class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="description" class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Deskripsi Pekerjaan</label>
                    <textarea id="description" name="description" rows="4" required class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">{{ old('description', $jobListing->description) }}</textarea>
                </div>

                <div class="space-y-1.5">
                    <label for="requirements" class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kualifikasi / Persyaratan</label>
                    <textarea id="requirements" name="requirements" rows="4" required class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">{{ old('requirements', $jobListing->requirements) }}</textarea>
                </div>

                <div class="space-y-1.5">
                    <label for="status" class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Status Publikasi</label>
                    <select id="status" name="status" required class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:border-blue-600 transition">
                        <option value="open" {{ $jobListing->status === 'open' ? 'selected' : '' }}>Aktif (Terbuka)</option>
                        <option value="pending" {{ $jobListing->status === 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                        <option value="closed" {{ $jobListing->status === 'closed' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                </div>

                <button type="submit" :disabled="busy" class="w-full py-4 bg-blue-600 text-white font-black rounded-full shadow-lg hover:bg-blue-700 transition-all text-sm uppercase tracking-widest">
                    <span x-show="!busy">Perbarui Lowongan</span>
                    <span x-show="busy">Menyimpan...</span>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
