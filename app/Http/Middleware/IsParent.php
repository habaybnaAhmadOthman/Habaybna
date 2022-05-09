<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class IsParent
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

        if (Auth::user() &&  Auth::user()->role == 'parent') {

            return $next($request);
       }

       return redirect(404)->with('error','You have not admin access');
    }
}
