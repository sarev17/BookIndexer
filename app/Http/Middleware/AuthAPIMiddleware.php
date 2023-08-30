<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAPIMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // return response()->json(['error' => 'teste'], 401);
        if (!$request->bearerToken()) {
            return response()->json(['error' => 'Não autorizado'], 401);
        }
        if(!User::where('api_token',$request->bearerToken())->first()){
            return response()->json(['error' => 'Token inválido'], 401);
        }
        return $next($request);
    }
}
