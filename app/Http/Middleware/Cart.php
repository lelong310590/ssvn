<?php

namespace App\Http\Middleware;

use Closure;

class Cart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Gloudemans\Shoppingcart\Facades\Cart::count())
            return $next($request);
        else
            return redirect('/');
    }
}
