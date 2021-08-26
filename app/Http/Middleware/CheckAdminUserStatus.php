<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class CheckAdminUserStatus
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
        if (Auth::user()->status == 'inactive') {
            Auth::logout();
            return redirect()->route('admin.login')->with('LoginStatusError', 'Your account has been disabled. Please contact with site authority for more informations.');
        }

        if (Auth::user()->status == 'block') {
            Auth::logout();
            return redirect()->route('admin.login')->with('LoginStatusError', 'Your account has been blocked. Please contact with site authority for more informations.');
        }
        return $next($request);
    }
}
