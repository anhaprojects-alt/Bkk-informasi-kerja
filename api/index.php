<?php

// 1. Muat autoload Vendor Composer agar semua class Laravel terdeteksi di Vercel
require __DIR__ . '/../vendor/autoload.php';

// 2. Override variabel lingkungan penting langsung di tingkat PHP Runtime untuk sistem Serverless Vercel
// Ini memaksa Laravel untuk tidak menulis file log atau cache ke harddisk Vercel yang bersifat Read-Only
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['CACHE_STORE'] = 'array';
$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = ':memory:'; // Gunakan database in-memory sementara jika DB eksternal belum diisi

// 3. Inisialisasi Aplikasi Laravel Core Bootstrap
$app = require __DIR__ . '/../bootstrap/app.php';

// 4. Tangani Request Secara Serverless menggunakan Http Kernel Native
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
