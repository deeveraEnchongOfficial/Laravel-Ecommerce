<?php

namespace App\Http\Middleware;

use Closure;

class DeliveryUser
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
        if($request->user()->role=='delivery_user'){
            return $next($request);
            // return redirect()->route('login.form');
        }
        else{
            return redirect()->route('login.form');
            // return $next($request);
        }
    }
}
