<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseCategorieController;
use App\Http\Controllers\InstructorController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth', 'verified', 'role:super admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('courses',function(){

        return view('courses.index');
    })->name('courses');

    Route::prefix('courses')->group(function(){
        Route::prefix('/categories')->group(function(){
            Route::get('index',[CourseCategorieController::class,'index'])->name('courses.categories.index');
            Route::get('create',[CourseCategorieController::class,'create'])->name('courses.categories.create');
            Route::post('store',[CourseCategorieController::class,'store'])->name('courses.categories.store');
            Route::get('edit/{id}',[CourseCategorieController::class,'edit'])->name('courses.categories.edit');
            Route::post('update/{id}',[CourseCategorieController::class,'update'])->name('courses.categories.update');
            Route::get('show/{id}',[CourseCategorieController::class,'show'])->name('courses.categories.show');
            Route::delete('delete/{id}',[CourseCategorieController::class,'destroy'])->name('courses.categories.destroy');
        });

        Route::get('create',function(){
            return view('courses.create');
        })->name('courses.create');

        Route::get('{id}/edit',function($id){
            return 'edit';
        })->name('courses.edit');

        Route::get('{id}/show',function($id){
            return 'show';
        })->name('courses.show');

        Route::get('{id}/delete',function($id){
            return 'delete';
        })->name('courses.delete');

        Route::get('store',function(){
            return 'store';
        })->name('courses.store');
    });

    // Instructor Routes
    Route::prefix('instructors')->group(function(){
        Route::get('/', [InstructorController::class, 'index'])->name('instructors.index');
        Route::get('/create', [InstructorController::class, 'create'])->name('instructors.create');
        Route::post('/', [InstructorController::class, 'store'])->name('instructors.store');
        Route::get('/{instructor}/edit', [InstructorController::class, 'edit'])->name('instructors.edit');
        Route::put('/{instructor}', [InstructorController::class, 'update'])->name('instructors.update');
        Route::get('/{instructor}', [InstructorController::class, 'show'])->name('instructors.show');
        Route::delete('/{instructor}', [InstructorController::class, 'destroy'])->name('instructors.destroy');
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('test-session', function () {
    dd(session()->get('locale'));
});

Route::get('lang/{locale}', function ($locale) {
    $availableLocales = config('app.available_locales', []);

    if (in_array($locale, $availableLocales)) {
        session()->put('locale', $locale);
    }
    return redirect()->back() ?? redirect('/');
})->name('lang.switch');

require __DIR__ . '/auth.php';
