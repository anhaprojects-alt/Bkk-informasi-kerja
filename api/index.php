<?php

// 1. Muat autoload Vendor Composer agar semua class Laravel terdeteksi di Vercel
require __DIR__ . '/../vendor/autoload.php';

// 2. Inisialisasi Aplikasi Laravel Core Bootstrap
$app = require __DIR__ . '/../bootstrap/app.php';

// 3. Tangani Request Secara Serverless menggunakan Http Kernel Native
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
