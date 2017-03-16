<?php

namespace App\Http\Middleware;

use Closure;

class Api2Auth
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
        $user = null;
        $key = request('server_key');
        if (!empty($key)) {
            $user = \App\User::where('server_key', '=', $key)->first();
            if (!empty($user)) {
                $request->route()->setParameter('ugroup', $user->ugroup);
            }
        }
        return $next($request);
    }
}
