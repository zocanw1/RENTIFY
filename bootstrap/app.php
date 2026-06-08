<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'staff' => \App\Http\Middleware\StaffMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

if (getenv('VERCEL') || getenv('NOW_REGION') || isset($_ENV['VERCEL']) || isset($_ENV['NOW_REGION'])) {
    $storagePath = '/tmp/storage';
    $bootstrapPath = '/tmp/bootstrap';
    $folders = [
        $storagePath,
        $storagePath . '/framework',
        $storagePath . '/framework/views',
        $storagePath . '/framework/cache',
        $storagePath . '/framework/cache/data',
        $storagePath . '/framework/sessions',
        $storagePath . '/logs',
        $bootstrapPath,
        $bootstrapPath . '/cache',
    ];

    foreach ($folders as $folder) {
        if (! is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
    }

    $app->useStoragePath($storagePath);
    $app->useBootstrapPath($bootstrapPath);

    putenv('SESSION_DRIVER=cookie');
    putenv('CACHE_STORE=file');
    $_ENV['SESSION_DRIVER'] = 'cookie';
    $_ENV['CACHE_STORE'] = 'file';
    $_SERVER['SESSION_DRIVER'] = 'cookie';
    $_SERVER['CACHE_STORE'] = 'file';
}

return $app;
