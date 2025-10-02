<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class webSetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
  
        if (session()->has('locale')) {
            $locale = session()->get('locale');
            if (in_array($locale, config('app.available_locales', ['en' => 'English']))) {
                app()->setLocale($locale);
                $direction = $locale === 'ar' ? 'rtl' : 'ltr';
                session()->put('direction', $direction);
                $request->attributes->add(['direction' => $direction]);
            }
        } else {
            $direction = app()->getLocale() === 'ar' ? 'rtl' : 'ltr';
            session()->put('direction', $direction);
            $request->attributes->add(['direction' => $direction]);
        }

        return $next($request);
    }
}
