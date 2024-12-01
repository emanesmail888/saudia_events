<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;


use Closure;
use Illuminate\Http\Request;

class SetAppLang
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
        $availableLocales = config('app.available_locales');
        $requestedLocale = $request->segment(1);
    
        if (!in_array($requestedLocale, $availableLocales)) {
            $defaultLocale = config('app.fallback_locale');
            App::setLocale($defaultLocale);
        } else {
            App::setLocale($requestedLocale);
        }
        URL::defaults(['locale'=>app()->getLocale()]);
        
        return $next($request);
    }
}
