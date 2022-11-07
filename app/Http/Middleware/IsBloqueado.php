<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsBloqueado{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)    {

        if($request->user()->hasRole('bloqueado'))
            abort(403, 'Tu cuenta está bloqueada, contacta con admin@admin.com.');

        return $next($request);
    }
}
