<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKK - Dashboard Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans antialiased text-slate-800">
    <div class="min-h-screen flex">

        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-indigo-900 text-white flex flex-col justify-between hidden md:flex">
            <div>
                <!-- Sidebar Brand -->
                <div class="p-5 flex items-center space-x-2 border-b border-indigo-800">
                    <div class="p-1.5 bg-white rounded-lg text-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold tracking-wider">BKK Admin</span>
                </div>

                <!-- Nav links -->
                <nav class="p-4 space-y-1">
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 bg-indigo-800 text-white rounded-xl font-medium transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 hover:text-white rounded-xl transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Perusahaan</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 hover:text-white rounded-xl transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span>Lowongan Kerja</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 hover:text-white rounded-xl transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>Data Pelamar</span>
                    </a>
                </nav>
            </div>

            <!-- Sidebar Footer (Logout) -->
            <div class="p-4 border-t border-indigo-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-red-600 hover:text-white rounded-xl transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Navbar Header -->
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 z-10 shadow-sm">
                <div class="flex items-center space-x-3">
                    <h2 class="text-xl font-bold text-slate-800">Dashboard Utama</h2>
                </div>

                <div class="flex items-center space-x-4">
                    <span class="text-sm font-semibold text-slate-600 bg-slate-100 py-1.5 px-3 rounded-lg">
                        {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                    </span>
                </div>
            </header>

            <!-- Main Content Container -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">

                <!-- Welcome Banner -->
                <div class="p-6 bg-indigo-600 text-white rounded-2xl shadow-xl shadow-indigo-100 flex flex-col md:flex-row justify-between items-center mb-6">
                    <div class="mb-4 md:mb-0">
                        <h3 class="text-xl font-bold">Selamat Datang di Panel Utama BKK</h3>
                        <p class="text-indigo-100 text-sm mt-1">Kelola data lowongan kerja, validasi akun perusahaan, dan pantau statistik pelamar hari ini.</p>
                    </div>
                    <button class="px-5 py-2.5 bg-white text-indigo-600 font-semibold rounded-xl shadow-sm text-sm hover:bg-slate-50 transition">
                        Tambah Lowongan Baru
                    </button>
                </div>

                <!-- Analytics Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">

                    <!-- Card 1 -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-4">
                        <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Perusahaan Mitra</span>
                            <h4 class="text-2xl font-bold text-slate-800 mt-0.5">12 Aktif</h4>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-4">
                        <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Lowongan Kerja</span>
                            <h4 class="text-2xl font-bold text-slate-800 mt-0.5">48 Dibuka</h4>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-4">
                        <div class="p-3.5 bg-sky-50 text-sky-600 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Pelamar Terdaftar</span>
                            <h4 class="text-2xl font-bold text-slate-800 mt-0.5">156 Orang</h4>
                        </div>
                    </div>

                </div>

                <!-- Recent Job Listings Section -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-slate-200 flex justify-between items-center">
                        <h4 class="font-bold text-slate-800">Daftar Lowongan Pekerjaan Terbaru</h4>
                        <span class="text-xs font-semibold bg-slate-100 text-slate-600 py-1 px-2.5 rounded-full">Real-time Feed</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-400 uppercase text-xs font-bold border-b border-slate-200">
                                    <th class="p-4">Judul Lowongan</th>
                                    <th class="p-4">Perusahaan</th>
                                    <th class="p-4">Lokasi</th>
                                    <th class="p-4">Status</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                <tr>
                                    <td class="p-4 font-semibold text-slate-800">Senior Laravel Backend Developer</td>
                                    <td class="p-4 text-slate-500">PT Maju Mundur Sejahtera</td>
                                    <td class="p-4 text-slate-500">Jakarta Selatan</td>
                                    <td class="p-4">
                                        <span class="inline-flex py-1 px-2.5 text-xs font-semibold bg-emerald-50 text-emerald-600 rounded-full">Aktif</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <button class="text-indigo-600 font-semibold hover:text-indigo-800 text-xs mr-3">Edit</button>
                                        <button class="text-slate-400 font-semibold hover:text-red-600 text-xs">Tutup</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-semibold text-slate-800">Mobile UI/UX Designer (Figma Expert)</td>
                                    <td class="p-4 text-slate-500">Tech Media Solusindo</td>
                                    <td class="p-4 text-slate-500">Bandung (Remote)</td>
                                    <td class="p-4">
                                        <span class="inline-flex py-1 px-2.5 text-xs font-semibold bg-emerald-50 text-emerald-600 rounded-full">Aktif</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <button class="text-indigo-600 font-semibold hover:text-indigo-800 text-xs mr-3">Edit</button>
                                        <button class="text-slate-400 font-semibold hover:text-red-600 text-xs">Tutup</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>

    </div>
</body>
</html>
