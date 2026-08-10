<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\MealScheduleController;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\FoodBrowseController;
use App\Http\Controllers\FavoriteFoodController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');

    Route::resource('meal-plans', MealPlanController::class);
    Route::resource('meal-plans.schedules', MealScheduleController::class)
         ->shallow()
         ->parameters(['schedules' => 'mealSchedule']);
    Route::patch('schedules/{mealSchedule}/toggle', [MealScheduleController::class, 'toggle'])
         ->name('schedules.toggle');

    Route::resource('weight-logs', WeightLogController::class)
         ->except(['create', 'show']);

    Route::get('foods', [FoodBrowseController::class, 'index'])->name('foods.index');

    Route::get('favorites', [FavoriteFoodController::class, 'index'])->name('favorites.index');
    Route::post('favorites/{food}/toggle', [FavoriteFoodController::class, 'toggle'])->name('favorites.toggle');
});

require __DIR__.'/auth.php';