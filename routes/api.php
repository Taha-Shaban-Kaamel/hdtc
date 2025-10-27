<?php
use App\Http\Controllers\Api\authController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PlansController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\PlanController;
use App\Services\SocialAuthService;
use Google\Service\CloudIdentity\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::post('/subscriptions', [SubscriptionController::class, 'subscribe']);
Route::get('/subscriptions', [SubscriptionController::class, 'getSubscription']);
Route::delete('/subscriptions', [SubscriptionController::class, 'cancelSubscription']);
Route::post('/plans', [PlanController::class, 'createPlan']);
Route::get('/plans', [PlanController::class, 'getPlans']);

Route::group(['prefix' => 'auth/'], function () {
    Route::group(['prefix' => 'social/'], function () {
        Route::get('{provider}/redirect', [SocialAuthController::class, 'redirectToProvider']);
        Route::post('{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [authController::class, 'logout']);
        Route::get('profile', [authController::class, 'getUserProfile']);
        Route::post('updateProfile', [authController::class, 'updateProfile']);
        Route::get('/tokens', [SocialAuthController::class, 'tokens']);
        Route::delete('/tokens/{token_id}', [SocialAuthController::class, 'revokeToken']);
        Route::delete('/unlink', [SocialAuthController::class, 'unlinkSocialAccount']);
        Route::get('notifications/user', [NotificationController::class, 'getForUser']);
        Route::post('notifications/read', [NotificationController::class, 'markAsRead']);
        Route::post('subscriptions/subscribe', [PaymentController::class, 'createPayment']);
        Route::get('subscriptions', [\App\Http\Controllers\Api\SubscriptionController::class, 'getSubscription']);
        Route::delete('subscriptions', [\App\Http\Controllers\Api\SubscriptionController::class, 'cancelSubscription']);
    });
});
Route::match(['get', 'post'], 'pay/callback', [PaymentController::class, 'callback']);
Route::get('pay/status', [PaymentController::class, 'getStatus']);

Route::prefix('instructors')->group(function () {
    Route::get('/', [InstructorController::class, 'index']);
    Route::get('/{id}', [InstructorController::class, 'show']);
    Route::get('/{id}/courses', [InstructorController::class, 'courses']);
});


Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::get('/top_rated', [CourseController::class, 'topRated']);
    Route::get('/last_added', [CourseController::class, 'lastAdded']);
    Route::get('/{id}', [CourseController::class, 'show']);
});


Route::prefix('plans')->group(function () {
    Route::get('/', [PlansController::class, 'index']);
    Route::get('/{id}', [PlansController::class, 'show']);
});

Route::prefix('enrollments')
    ->middleware('auth:sanctum')
    ->controller(EnrollmentController::class)
    ->group(function () {
        Route::get('myEnrollments', 'myEnrollments');
        Route::get('/{enrollment}', 'show');
        Route::post('/{enrollment}', 'update');
        Route::delete('/{enrollment}', 'destroy');
        Route::post('/{course}/enroll', 'enroll');
    });
