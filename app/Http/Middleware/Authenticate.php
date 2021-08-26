<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // dd(\Request::getRequestUri());
        if (Str::contains(\Request::getRequestUri(), 'admin')) {
            if (!$request->expectsJson()) {
                return route('login');
            }
        }

        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
