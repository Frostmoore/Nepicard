<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, $request) {
            \Illuminate\Support\Facades\Log::warning('Limite di richieste superato', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_id' => optional($request->user())->id,
                'timestamp' => now(),
            ]);
    
            return response()->view('errors.429', [], 429);
        });
    })    
    ->create();
