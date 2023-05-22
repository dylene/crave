<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;
        
        foreach ($guards as $guard) {
            if ($guard == 'admin' && Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::ADMIN);
            } else if ($guard == 'web' && Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::TENANT);
            } else if(!$guard) {
                if (Auth::guard('admin')->check()) {
                    return redirect(RouteServiceProvider::ADMIN);
                } else if (Auth::guard()->check()) {
                    dd(Auth::guard()->user());
                    return redirect(RouteServiceProvider::TENANT);
                }
            }
        }

        return $next($request);
    }

}
