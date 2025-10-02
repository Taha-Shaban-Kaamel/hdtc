<?php

use App\Http\Middleware\setLocal;
use App\Http\Middleware\webSetLocale;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        $middleware->appendToGroup('web', [webSetLocale::class]);

        $middleware->appendToGroup('api', [setLocal::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
