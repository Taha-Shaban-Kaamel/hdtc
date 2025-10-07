<?php

use App\Http\Controllers\CourseCategorieController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ChaptersController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\CacheClearer\ChainCacheClearer;

Route::middleware(['auth', 'verified', 'role:super admin'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

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


    Route::prefix('course/{course_id}')->group(function(){
        Route::get('chapters', [ChaptersController::class, 'index'])->name('chapters.index');
        Route::get('chapters/create',[ChaptersController::class,'create'])->name('chapters.create');
        Route::post('chapters',[ChaptersController::class,'store'])->name('chapters.store');
        Route::delete('chapters/{id}',[ChaptersController::class,'destroy'])->name('chapters.destroy');
        Route::get('chapters/{id}/edit',[ChaptersController::class,'edit'])->name('chapters.edit');
        Route::post('chapters/{id}/update',[ChaptersController::class,'update'])->name('chapters.update');
    });

    Route::prefix('instructors')->group(function () {
        Route::get('/', [InstructorController::class, 'index'])->name('instructors.index');
        Route::get('/create', [InstructorController::class, 'create'])->name('instructors.create');
        Route::post('/', [InstructorController::class, 'store'])->name('instructors.store');
        Route::get('/{instructor}/edit', [InstructorController::class, 'edit'])->name('instructors.edit');
        Route::put('/update/{id}', [InstructorController::class, 'update'])->name('instructors.update');
        Route::get('/{instructor}', [InstructorController::class, 'show'])->name('instructors.show');
        Route::delete('/{instructor}', [InstructorController::class, 'destroy'])->name('instructors.destroy');
    });
    
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
