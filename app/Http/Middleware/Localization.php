<?php

namespace App\Http\Middleware;

use Closure;
use Route;

class Localization
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
        // set languages if requested, based on request and saved session
        $defaultLocale = strtolower(config('app.fallback_locale', 'en'));
        $localeOptions = explode(',', env('APP_MULTI_LOCALE_OPTIONS', $defaultLocale));
        if (request()->has('locale')) {
            $locale = request()->get('locale');
            if (in_array($locale, $localeOptions)) {
                $request->session()->put('locale', $locale);
                $request->session()->save();
            }
        }
        if ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
            if (in_array($locale, $localeOptions)) {
                app()->setLocale($locale);
            }
        }
        // send request to next process/middleware
        return $next($request);
    }
}
