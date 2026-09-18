<?php

// 1. Muat autoload Vendor Composer agar semua class Laravel terdeteksi di Vercel
require __DIR__ . '/../vendor/autoload.php';

// 2. Set environment variables secara mutlak untuk runtime Vercel serverless
putenv('LOG_CHANNEL=stderr');
putenv('SESSION_DRIVER=cookie');
putenv('CACHE_STORE=array');
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=:memory:');

// 3. Muat aplikasi Laravel menggunakan handler index native agar inisialisasi IoC Service Container lengkap
$app = require __DIR__ . '/../bootstrap/app.php';

// 4. Jalankan siklus Http Kernel standar untuk mendaftarkan semua dependensi dasar secara otomatis
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// 5. Kirim konten halaman HTML resmi ke browser Anda
$response->send();
$kernel->terminate($request, $response);
