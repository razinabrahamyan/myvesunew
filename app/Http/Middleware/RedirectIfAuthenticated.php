<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
            if (Auth::guard($guard)->check()) {
                if ($guard === "web" ) {
                    if(Auth::user()->hasAnyRole(['superadmin','admin'])){
                        return redirect()->route("dashboard");
                    }
                }
                elseif ($guard === "app" || request()->segment(1) === 'app'){
                    return redirect()->route('app');
                }
            }
            return $next($request);
    }
}
