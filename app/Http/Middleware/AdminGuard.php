<?php

namespace App\Http\Middleware;

use Closure;

class AdminGuard
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
        if ($request->user->role !== 'admin') {
            return response()->json([
                'error' => 'Нет разрешения'
            ], 403);
        }

        return $next($request);
    }
}
