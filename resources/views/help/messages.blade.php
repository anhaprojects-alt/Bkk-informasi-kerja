<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKK - Pesan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f2ef] font-sans antialiased text-slate-800">
    <div class="min-h-screen max-w-6xl mx-auto px-4 py-6">
        <header class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('help.center') }}" class="text-slate-500 hover:text-blue-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Messaging</p>
                    <h1 class="text-xl font-black text-slate-900">Pesan & Komunikasi</h1>
                </div>
            </div>
            <a href="{{ route('help.center') }}" class="text-xs font-black uppercase tracking-widest text-blue-600">Pusat Bantuan</a>
        </header>

        @if (session('status'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-2xl">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid lg:grid-cols-4 gap-6">
            <aside class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-slate-100">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Kontak</p>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($participants as $participant)
                        <a href="{{ route('messages.show', $participant) }}" class="block p-4 {{ $activeUser && $activeUser->id === $participant->id ? 'bg-blue-50' : 'hover:bg-slate-50' }} transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-black text-sm">
                                    {{ mb_strtoupper(mb_substr($participant->name, 0, 1, 'UTF-8'), 'UTF-8') }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">{{ $participant->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $participant->role }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-4 text-sm text-slate-400">Belum ada kontak tersedia.</div>
                    @endforelse
                </div>
            </aside>

            <main class="lg:col-span-3 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                @if ($activeUser)
                    <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-black">
                                {{ mb_strtoupper(mb_substr($activeUser->name, 0, 1, 'UTF-8'), 'UTF-8') }}
                            </div>
                            <div>
                                <p class="font-black text-slate-900">{{ $activeUser->name }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $activeUser->role }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black uppercase text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Online</span>
                    </div>

                    <div class="p-4 space-y-4 min-h-[360px] max-h-[480px] overflow-y-auto bg-slate-50/30">
                        @forelse ($messages as $message)
                            <div class="flex {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[75%] rounded-2xl px-4 py-3 {{ $message->sender_id === Auth::id() ? 'bg-blue-600 text-white' : 'bg-white border border-slate-200 text-slate-700' }} shadow-sm">
                                    <p class="text-sm leading-6">{{ $message->body }}</p>
                                    <p class="mt-1 text-[10px] {{ $message->sender_id === Auth::id() ? 'text-blue-100' : 'text-slate-400' }} font-bold uppercase tracking-wide">
                                        {{ $message->created_at->format('d M H:i') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="flex items-center justify-center h-full text-sm text-slate-400 font-bold uppercase tracking-widest">Belum ada pesan.</div>
                        @endforelse
                    </div>

                    <form method="POST" action="{{ route('messages.store', $activeUser) }}" class="p-4 border-t border-slate-100 bg-white">
                        @csrf
                        <div class="flex gap-3">
                            <textarea name="body" rows="2" required maxlength="2000" placeholder="Ketik pesan Anda..." class="flex-1 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100"></textarea>
                            <button type="submit" class="bg-blue-600 text-white px-5 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-blue-700 transition">Kirim</button>
                        </div>
                    </form>
                @else
                    <div class="flex items-center justify-center h-full p-8 text-center text-slate-400 font-bold uppercase tracking-widest">
                        Pilih kontak untuk memulai percakapan.
                    </div>
                @endif
            </main>
        </div>
    </div>
</body>
</html>
