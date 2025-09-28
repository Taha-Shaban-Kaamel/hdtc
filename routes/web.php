<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialAuthService;

Route::get('/', function () {
    return view('welcome');
});


 
Route::get('/auth/redirect', function () {

    return Socialite::driver('google')->redirect();
});


Route::get('/auth/google/callback', function () {
    $user = Socialite::driver('google')->stateless()->user();

    $socialAuthService = new SocialAuthService();
    $user = $socialAuthService->handleSocialAuth('google', $user);

    $tokenResponse = $socialAuthService->generateTokenResponse($user);

    return redirect(env('FRONTEND_URL')."?token=".$tokenResponse['access_token']);

});