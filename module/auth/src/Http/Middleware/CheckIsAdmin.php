<?php
/**
 * CheckIsAdmin.php
 * Created by: trainheartnet
 * Created at: 14/07/2021
 * Contact me at: longlengoc90@gmail.com
 */

namespace Auth\Http\Middleware;

use Closure;

class CheckIsAdmin
{
    public function handle($request, Closure $next) {

        if (auth('nqadmin')->check() && auth('nqadmin')->user()->hard_role == 99) {
            return $next($request);
        }

        return redirect(route('front.home.index.get'));
    }
}