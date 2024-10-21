<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
//use Exception;


class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Intenta autenticar el token JWT
            JWTAuth::parseToken()->authenticate();

        } catch (JWTException $e) {
            if ($e instanceof TokenInvalidException) {
                // El token es inválido
                return response()->json(['status' => 'Token is Invalid'], 401);
            } 
            if ($e instanceof TokenExpiredException) {
                // El token ha expirado
                return response()->json(['status' => 'Token is Expired'], 401);
            } 
                return response()->json(['status' => 'Authorization Token not found'], 401);
            
        }

        // Continua con la solicitud si el token es válido
        return $next($request);
    }
}
