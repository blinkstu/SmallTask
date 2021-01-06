<?php

namespace App\Http\Middleware;

use Closure;

class Auth
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

        $user = auth('api')->user();
        if(!$user){
            return response()->json(['error' => 'Unauthorized or missing token'], 401);
        }

        $request->user = $user;
        

        return $next($request);
    }
}
