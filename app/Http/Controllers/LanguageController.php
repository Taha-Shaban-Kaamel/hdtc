<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        $availableLocales = config('app.available_locales', []);
        
        if (!array_key_exists($lang, $availableLocales)) {
            abort(400, 'Language not supported');
        }

        App::setLocale($lang);
   
        
        Session::save();

        return redirect()->back();
    }
}
