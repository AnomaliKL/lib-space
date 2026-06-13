<?php

// Paksa override konstanta internal PHP untuk membelokkan folder manifest Laravel
if (isset($_SERVER['VERCEL_JOB_ID']) || isset($_SERVER['NOW_REGION'])) {

    // Buat folder bayangan di RAM Vercel yang writable
    if (! is_dir('/tmp/bootstrap/cache')) {
        mkdir('/tmp/bootstrap/cache', 0755, true);
    }

    // Gandakan file pancingan agar package manifest tidak dibuild ulang oleh framework saat runtime
    if (! file_exists('/tmp/bootstrap/cache/packages.php')) {
        file_put_contents('/tmp/bootstrap/cache/packages.php', '<?php return []; ?>');
    }
    if (! file_exists('/tmp/bootstrap/cache/services.php')) {
        file_put_contents('/tmp/bootstrap/cache/services.php', '<?php return []; ?>');
    }

    // Tembakkan langsung ke memory override internal laravel sebelum index.php dimuat
    $_ENV['LARAVEL_PACKAGE_MANIFEST'] = '/tmp/bootstrap/cache/packages.php';
    $_ENV['LARAVEL_SERVICES_MANIFEST'] = '/tmp/bootstrap/cache/services.php';

    putenv('LARAVEL_PACKAGE_MANIFEST=/tmp/bootstrap/cache/packages.php');
    putenv('LARAVEL_SERVICES_MANIFEST=/tmp/bootstrap/cache/services.php');
}

// Jalankan index utama
require __DIR__.'/../public/index.php';
