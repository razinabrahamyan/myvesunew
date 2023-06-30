<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $roles = explode('|', $role);
        if ($request->user()->hasAnyRole($roles)) {
            return $next($request);
        }
        if (request()->segment(1) == 'app')
            return route('app.login', $request->route()->parameters($request));
        else return route('login');
    }

}
