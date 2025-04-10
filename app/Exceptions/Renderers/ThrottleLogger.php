<?php

namespace App\Exceptions\Renderers;

use Closure;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ThrottleLogger
{
    public function __invoke(ThrottleRequestsException $e, Closure $next): Response
    {
        Log::warning('Limite di richieste superato', [
            'ip' => request()->ip(),
            'url' => request()->fullUrl(),
            'user_id' => optional(request()->user())->id,
            'timestamp' => now(),
        ]);

        return response()->view('errors.429', [], 429);
    }
}
