<?php
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\PlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialAuthService;
use App\Http\Controllers\Api\authController;
// Subscribe to a service or feature
Route::post('/subscriptions', [SubscriptionController::class, 'subscribe']);

// Get current subscription details
Route::get('/subscriptions', [SubscriptionController::class, 'getSubscription']);

// Cancel the current subscription
Route::delete('/subscriptions', [SubscriptionController::class, 'cancelSubscription']);

Route::post('/plans', [PlanController::class, 'createPlan']);
Route::get('/plans', [PlanController::class, 'getPlans']);



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



