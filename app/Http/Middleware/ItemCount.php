<?php

namespace App\Http\Middleware;

use Closure;

class ItemCount
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
        if (isset($request->thirdParty)) {
            if (count($request->items) > 0) {
                $request->attributes->add(array('count' => count($request->items)));
                return $next($request);
            }
        }
    }
}
