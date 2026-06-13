<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

/*
|--------------------------------------------------------------------------
| Vercel Serverless Read-Only Filesystem Fix
|--------------------------------------------------------------------------
*/
if (isset($_SERVER['VERCEL_JOB_ID']) || isset($_SERVER['NOW_REGION'])) {
    // 1. Belokkan folder storage (untuk log, session, dll) ke /tmp
    $app->useStoragePath('/tmp/storage');

    // 2. Paksa Laravel menulis manifest package & service ke /tmp yang writable
    $app->instance('path.bootstrap', '/tmp/bootstrap');

    // 3. Buat foldernya secara otomatis di RAM jika belum ada
    if (! is_dir('/tmp/bootstrap/cache')) {
        mkdir('/tmp/bootstrap/cache', 0755, true);
    }
}

return $app;
