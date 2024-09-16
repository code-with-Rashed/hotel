<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            '/sslcommerz/pay',
            '/sslcommerz/success',
            '/sslcommerz/cancel',
            '/sslcommerz/failure',
            '/sslcommerz/ipn',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
