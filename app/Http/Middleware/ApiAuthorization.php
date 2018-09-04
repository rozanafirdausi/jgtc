<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ApiAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $apiHashKey = md5(env('API_PUBLIC_KEY', 'Suitmedia') . '+' . env('API_SECRET_KEY', 'SuitmediaMMXVII'));
        if ($request->header('X-PublicKey') != env('API_PUBLIC_KEY') ||
            $request->header('X-HashKey') != $apiHashKey
        ) {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorize to access this url',
            ]);
        }

        $result = $next($request);
        return $result;
    }
}
