<?php

namespace App\Http\Middleware;

use App\Service\ProfileCacheService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('token')) {
            app(ProfileCacheService::class)->forget();
            return redirect()->route('login');
        }
        return $next($request);
    }
}
