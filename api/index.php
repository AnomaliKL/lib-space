<?php

// 1. Jika berjalan di Vercel, paksa pembuatan environment folder cache di RAM (/tmp)
if (isset($_SERVER['VERCEL_JOB_ID']) || isset($_SERVER['NOW_REGION'])) {
    $cacheDir = '/tmp/bootstrap/cache';

    // Buat folder bootstrap/cache secara virtual di /tmp jika belum ada
    if (! is_dir($cacheDir)) {
        mkdir($cacheDir, 0755, true);
    }

    // Set environment variable bawaan agar Laravel membaca folder ini sebagai manifest
    putenv("LARAVEL_PACKAGE_MANIFEST={$cacheDir}/packages.php");
    putenv("LARAVEL_SERVICES_MANIFEST={$cacheDir}/services.php");
}

// 2. Jalankan aplikasi Laravel seperti biasa
require __DIR__.'/../public/index.php';
