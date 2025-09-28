<?php
use App\Http\Controllers\Api\SocialAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialAuthService;
use App\Http\Controllers\Api\authController;

Route::group(['prefix' => 'auth/'], function () {
    Route::group(['prefix' => 'social/'], function () {
        Route::get('{provider}/redirect', [SocialAuthController::class, 'redirectToProvider']);
        Route::post('{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);
    }); 

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout',[authController::class,'logout']);
        Route::get('profile', [authController::class, 'getUserProfile']);
        Route::post('updateProfile', [authController::class, 'updateProfile']);
        Route::get('/tokens', [SocialAuthController::class, 'tokens']);
        Route::delete('/tokens/{token_id}', [SocialAuthController::class, 'revokeToken']);
        Route::delete('/unlink', [SocialAuthController::class, 'unlinkSocialAccount']);
    });
});



