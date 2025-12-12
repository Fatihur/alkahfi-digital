<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'check.active' => \App\Http\Middleware\CheckActive::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'api/midtrans/*',
        ]);

        // Redirect authenticated users away from guest routes (login, register, etc.)
        $middleware->redirectUsersTo(function ($request) {
            $user = $request->user();
            return match ($user?->role) {
                'admin' => route('admin.dashboard'),
                'bendahara' => route('bendahara.dashboard'),
                'wali_santri' => route('wali.dashboard'),
                default => route('landing.index'),
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
