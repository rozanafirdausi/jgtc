<?php

namespace App\Http\Middleware;

use App\SuitEvent\Models\User;
use App\SuitEvent\Models\UserToken;
use Closure;
use Illuminate\Support\Facades\Auth;

class ApiTokenAuth
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
        $token = $request->get('token');
        $userToken = UserToken::where('token', '=', $token)->with('user')->first();

        if ($userToken &&
            $userToken->user &&
            $userToken->user->status == User::STATUS_ACTIVE) {
            // authenticate user
            Auth::onceUsingId($userToken->user_id);
        }

        return $next($request);
    }
}
