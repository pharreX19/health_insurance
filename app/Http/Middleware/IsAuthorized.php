<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IsAuthorized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(hasPermission($request->route()->getName())){
            return $next($request);
        }
        return response()->json(['message' => 'You are not allowed to access this resource', 'status' => Response::HTTP_FORBIDDEN], Response::HTTP_FORBIDDEN );
    }
}
