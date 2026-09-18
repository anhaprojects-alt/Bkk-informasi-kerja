<?php

// 1. Muat autoload Vendor Composer agar semua class Laravel terdeteksi di Vercel
require __DIR__ . '/../vendor/autoload.php';

// 2. Set environment variables secara mutlak untuk runtime Vercel serverless
putenv('LOG_CHANNEL=stderr');
putenv('SESSION_DRIVER=cookie');
putenv('CACHE_STORE=array');
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=:memory:');

// 3. Muat instansiasi core bootstrap Laravel Application
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. Hubungkan instansiasi Kernel secara eksplisit untuk mendaftarkan Core Services (View, Session, Router)
$app->boot();

// 5. Tangani Request Menggunakan Http Kernel Native standar Laravel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// 6. Kirim konten output HTML resmi ke layar browser Anda
$response->send();
$kernel->terminate($request, $response);
