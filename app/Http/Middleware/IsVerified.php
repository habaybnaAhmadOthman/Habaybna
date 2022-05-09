<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class IsVerified
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
        if (Auth::user()) {

            if(!Auth::user()->is_verfied){

                return redirect('/check-otp');
            }
        }
        return $next($request);
    }
}
