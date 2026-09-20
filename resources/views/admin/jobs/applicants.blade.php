<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>BKK - Kelola Pelamar: {{ $jobListing->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800">
    <div class="max-w-5xl mx-auto py-10 px-6">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('dashboard') }}" class="text-xs font-black uppercase text-blue-600 hover:underline">← Kembali ke Dashboard</a>
                <h1 class="text-2xl font-black text-slate-900 mt-2">Pelamar: {{ $jobListing->title }}</h1>
                <p class="text-sm text-slate-500 font-medium">{{ $jobListing->company->name ?? '' }} • {{ $applicants->total() }} Aplikasi Masuk</p>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-black uppercase text-slate-400 block mb-1">Status Lowongan</span>
                <span class="px-3 py-1 rounded-full text-xs font-black {{ $jobListing->status === 'open' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                    {{ strtoupper($jobListing->status) }}
                </span>
            </div>
        </div>

        <div class="glass-card bg-white overflow-hidden border-b-4 border-indigo-600">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400 tracking-widest border-b border-slate-100">
                        <tr>
                            <th class="p-4">Nama Pelamar</th>
                            <th class="p-4">Dokumen</th>
                            <th class="p-4">Tanggal Melamar</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-bold text-slate-700">
                        @forelse($applicants as $applicant)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $applicant->user->avatar_url }}" class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
                                        <div>
                                            <p class="font-black text-slate-900 leading-tight">{{ $applicant->user->name }}</p>
                                            <p class="text-[10px] text-slate-400 font-medium">{{ $applicant->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col gap-1">
                                        <a href="{{ $applicant->resume }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                            CV / Portfolio
                                        </a>
                                        @if($applicant->user->cv_path)
                                            <a href="{{ Storage::url($applicant->user->cv_path) }}" target="_blank" class="text-indigo-600 hover:underline flex items-center gap-1 text-[10px]">
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                                Dokumen Sistem
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 text-xs text-slate-500">{{ $applicant->created_at->format('d M Y H:i') }}</td>
                                <td class="p-4">
                                    @php
                                        $colors = [
                                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'accepted' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'rejected' => 'bg-red-50 text-red-600 border-red-100',
                                        ];
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-lg border text-[10px] font-black uppercase tracking-wider {{ $colors[$applicant->status] }}">
                                        {{ $applicant->status }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('messages.show', $applicant->user) }}" class="p-2 text-slate-400 hover:text-blue-600 transition" title="Kirim Pesan">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                        </a>

                                        <form method="POST" action="{{ route('applicants.status.update', $applicant) }}" class="inline-flex gap-1">
                                            @csrf @method('PATCH')
                                            <button name="status" value="accepted" class="bg-emerald-600 text-white p-1.5 rounded-lg hover:bg-emerald-700 transition shadow-sm" title="Terima">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7" /></svg>
                                            </button>
                                            <button name="status" value="rejected" class="bg-red-600 text-white p-1.5 rounded-lg hover:bg-red-700 transition shadow-sm" title="Tolak">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-12 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">Belum ada pelamar untuk lowongan ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $applicants->links() }}
            </div>
        </div>
    </div>
</body>
</html>
