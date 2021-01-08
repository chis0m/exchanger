<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class ApiGeneralAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admins')->check()) {
            return $next($request);
        }
        if (Auth::guard('users')->check()) {
            return $next($request);
        }
        return response()->json(['status' => 401, 'message' => 'Unauthorized']);
    }
}
