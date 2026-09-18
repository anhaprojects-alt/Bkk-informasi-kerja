<?php

// 1. Muat autoload Vendor Composer agar semua class Laravel terdeteksi di Vercel
require __DIR__ . '/../vendor/autoload.php';

// 2. Paksa aktifkan tampilan error Laravel secara manual untuk mempermudah debugging di Vercel
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 3. Inisialisasi Aplikasi Laravel Core Bootstrap
$app = require __DIR__ . '/../bootstrap/app.php';

// 4. Tangani Request Secara Serverless menggunakan Http Kernel Native
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

try {
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    echo "<h3>Laravel Serverless Catch Error:</h3>";
    echo "<p><b>Message:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><b>File:</b> " . htmlspecialchars($e->getFile()) . " pada baris " . $e->getLine() . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
