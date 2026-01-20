<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');
        
        // Validate locale
        if (!in_array($locale, ['en', 'id'])) {
            // Default to English if invalid locale
            $locale = 'en';
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        // Store locale in session for future requests
        Session::put('locale', $locale);
        
        return $next($request);
    }
}
