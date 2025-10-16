<?php

use App\Http\Controllers\ChaptersController;
use App\Http\Controllers\CourseCategorieController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\CacheClearer\ChainCacheClearer;

Route::middleware(['auth', 'verified', 'role:super admin|admin'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/create', [NotificationController::class, 'create'])->name('notifications.create');
        Route::post('/send', [NotificationController::class, 'send'])->name('notifications.send');
    });
    Route::prefix('courses')->group(function () {
        Route::prefix('/categories')->group(function () {
            Route::get('index', [CourseCategorieController::class, 'index'])->name('courses.categories.index');
            Route::get('create', [CourseCategorieController::class, 'create'])->name('courses.categories.create');
            Route::post('store', [CourseCategorieController::class, 'store'])->name('courses.categories.store');
            Route::get('edit/{id}', [CourseCategorieController::class, 'edit'])->name('courses.categories.edit');
            Route::post('update/{id}', [CourseCategorieController::class, 'update'])->name('courses.categories.update');
            Route::get('show/{id}', [CourseCategorieController::class, 'show'])->name('courses.categories.show');
            Route::delete('delete/{id}', [CourseCategorieController::class, 'destroy'])->name('courses.categories.destroy');
        });
        Route::resource('courses', CourseController::class);
    });

    Route::prefix('course/{course_id}')->group(function () {
        Route::get('chapters', [ChaptersController::class, 'index'])->name('chapters.index');
        Route::get('chapters/create', [ChaptersController::class, 'create'])->name('chapters.create');
        Route::post('chapters', [ChaptersController::class, 'store'])->name('chapters.store');
        Route::delete('chapters/{id}', [ChaptersController::class, 'destroy'])->name('chapters.destroy');
        Route::get('chapters/{id}/edit', [ChaptersController::class, 'edit'])->name('chapters.edit');
        Route::post('chapters/{id}/update', [ChaptersController::class, 'update'])->name('chapters.update');
    });
    Route::prefix('plans')->group(function () {

        Route::get('plans', [PlanController::class, 'index'])->name('plans.index');
        Route::get('plans/create', [PlanController::class, 'create'])->name('plans.create');
        Route::post('plans', [PlanController::class, 'store'])->name('plans.store');

        Route::get('plans/{id}', [PlanController::class, 'show'])->name('plans.show');
        Route::get('plans/{id}/edit', [PlanController::class, 'edit'])->name('plans.edit');
        Route::post('plans/{id}/update', [PlanController::class, 'update'])->name('plans.update');
        Route::delete('plans/{id}', [PlanController::class, 'destroy'])->name('plans.destroy');

    });
    Route::get('/subscriptions', [\App\Http\Controllers\SubscriptionsController::class, 'index'])
        ->name('subscription.index');
    Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'index'])
        ->name('payments.index');
//    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');



    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');

        // Courses
        Route::get('/courses', [ReportController::class, 'courses'])->name('courses');
        Route::get('/courses/export-excel', [ReportController::class, 'exportCoursesExcel'])->name('courses.export.excel');
        Route::get('/courses/export-pdf', [ReportController::class, 'exportCoursesPdf'])->name('courses.export.pdf');

        // Instructors
        Route::get('/instructors', [ReportController::class, 'instructors'])->name('instructors');
        Route::get('/instructors/export-excel', [ReportController::class, 'exportInstructorsExcel'])->name('instructors.export.excel');
        Route::get('/instructors/export-pdf', [ReportController::class, 'exportInstructorsPdf'])->name('instructors.export.pdf');

        // Subscriptions
        Route::get('/subscriptions', [ReportController::class, 'subscriptions'])->name('subscriptions');
        Route::get('/subscriptions/export-excel', [ReportController::class, 'exportSubscriptionsExcel'])->name('export.subscriptions.excel');
        Route::get('/subscriptions/export-pdf', [ReportController::class, 'exportSubscriptionsPdf'])->name('export.subscriptions.pdf');


        // Plans
        Route::get('/plans', [ReportController::class, 'plans'])->name('plans');
        Route::get('/plans/export-excel', [ReportController::class, 'exportPlansExcel'])->name('plans.export.excel');
        Route::get('/plans/export-pdf', [ReportController::class, 'exportPlansPdf'])->name('plans.export.pdf');

        // General
        Route::get('/general/export-excel', [ReportController::class, 'exportGeneralExcel'])->name('export.excel');
        Route::get('/general/export-pdf', [ReportController::class, 'exportGeneralPdf'])->name('export.pdf');
    });
    Route::prefix('course/{course}/chapter/{chapter}')->group(function () {
        Route::resource('lectures', LectureController::class)->names('lectures');
    });

    Route::prefix('instructors')->group(function () {
        Route::get('/', [InstructorController::class, 'index'])->name('web.instructors.index');
        Route::get('/create', [InstructorController::class, 'create'])->name('web.instructors.create');
        Route::post('/', [InstructorController::class, 'store'])->name('web.instructors.store');
        Route::get('/{instructor}/edit', [InstructorController::class, 'edit'])->name('web.instructors.edit');
        Route::put('/update/{id}', [InstructorController::class, 'update'])->name('web.instructors.update');
        Route::get('/{instructor}', [InstructorController::class, 'show'])->name('web.instructors.show');
        Route::delete('/{instructor}', [InstructorController::class, 'destroy'])->name('web.instructors.destroy');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

});

Route::prefix('admins')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admins.index');
    Route::get('/create', [AdminController::class, 'create'])->name('admins.create');
    Route::post('/', [AdminController::class, 'store'])->name('admins.store');
    Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
    Route::put('/update/{id}', [AdminController::class, 'update'])->name('admins.update');
    Route::get('/{admin}', [AdminController::class, 'show'])->name('admins.show');
    Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');
});

Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('lang/{locale}', function ($locale) {
    $availableLocales = config('app.available_locales', []);

    if (in_array($locale, $availableLocales)) {
        session()->put('locale', $locale);
    }

    return redirect()->back() ?? redirect('/');
})->name('lang.switch');

require __DIR__ . '/auth.php';
