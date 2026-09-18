<?php

// 1. Muat autoload Vendor Composer agar semua class Laravel terdeteksi di Vercel
require __DIR__ . '/../vendor/autoload.php';

// 2. Set environment variables secara mutlak untuk runtime Vercel serverless
putenv('LOG_CHANNEL=stderr');
putenv('SESSION_DRIVER=cookie');
putenv('CACHE_STORE=array');
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=:memory:');

// 3. Inisialisasi Aplikasi Laravel Core Bootstrap
$app = require __DIR__ . '/../bootstrap/app.php';

// 4. Tangani Request Secara Serverless menggunakan Http Kernel Native
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// 5. Pastikan konten output dikirim ke browser secara eksplisit tanpa cache buffer kosong
$response->send();
$kernel->terminate($request, $response);
