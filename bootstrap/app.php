<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
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

// === TAMBAHKAN KODE INI DI BAGIAN PALING BAWAH (Sebelum return $app) ===
if (isset($_SERVER['VERCEL_JOB_ID']) || isset($_SERVER['NOW_REGION'])) {
    $app->useStoragePath('/tmp/storage');
    $app->bootstrapWith([
        LoadEnvironmentVariables::class,
        LoadConfiguration::class,
    ]);

    // Paksa jalur manifest cache Laravel ke folder /tmp yang writable
    config(['app.manifest' => '/tmp/bootstrap/cache']);
}

return $app;
