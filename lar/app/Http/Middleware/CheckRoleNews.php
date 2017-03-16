<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoleNews
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
        if ($request->route('ugroup') == \App\User::NEWS_EDITOR) {
            return $next($request);
        }
        return response()->json(['error' => 'У вас нет прав на эту операцию'], 401);
    }
}
