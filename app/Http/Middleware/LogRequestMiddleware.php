<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LogRequestMiddleware
{
    
    public function handle(Request $request, Closure $next): Response
    {
        $data = $request->all();
        if ($request->isMethod('post') && $request->path() === 'api/login' && isset($data['password'])) {
            $data['password'] = 'HIDDEN';
        }

        Log::info("API Request: {$request->method()}, {$request->fullUrl()}", [
            'headers' => $request->headers->all(),
            'body' => $data,
        ]);
        
        return $next($request);
    }
}
