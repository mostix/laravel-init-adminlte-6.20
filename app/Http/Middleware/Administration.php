<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Administration
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
        if (Auth::guard(currentGuard())->check() && Auth::guard(currentGuard())->user() instanceof \App\User && Auth::guard(currentGuard())->user()->hasRole(['admin'])) {
            return $next($request);
        }

        return redirect('home')->with('warning', trans('msg.no_rights_to_view_content'));
    }
}
