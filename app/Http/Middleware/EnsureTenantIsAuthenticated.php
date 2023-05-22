<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantIsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $currentDomain = str_replace('http://','',substr(request()->url(), strpos(request()->url(), 'http://'), strrpos(request()->url(), ':')));

        // dd($currentDomain)
        if(User::where('role','admin')->whereNot('remember_token', null)->first()) {
            return $next($request);
        } else {
            abort(404);
        }
    }
}
