<?php

namespace App\SuitEvent\Middleware;

use App\SuitEvent\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOnlyMiddleware
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
        $user = Auth::guard($guard)->user();

        if ($user->role != User::ADMIN) {
            return redirect(route('frontend.home'));
        }

        return $next($request);
    }
}
