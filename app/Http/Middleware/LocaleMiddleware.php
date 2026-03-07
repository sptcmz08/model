<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Check Query String (optional, e.g. ?lang=th)
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            Session::put('locale', $locale);
        }
        // 2. Check Session
        elseif (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        // 3. Check Cookie (If Session expired but Cookie exists)
        elseif ($request->hasCookie('locale')) {
            $locale = $request->cookie('locale');
            Session::put('locale', $locale); // Restore to session
        }
        // 4. Default
        else {
            $locale = config('app.locale');
        }

        if (in_array($locale, ['en', 'th'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
