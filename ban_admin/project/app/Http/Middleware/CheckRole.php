<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

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

    public function handle($request, Closure $next)
    {
        if(Auth::user()->role != 'admin')
        {
            abort(401);
        }
        return $next($request);
    }
}
