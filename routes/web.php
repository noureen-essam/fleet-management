<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookRideController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    Route::get('/Book-ride', [BookRideController::class, 'index'])->name('bookride');
    Route::post('/get/lines', [BookRideController::class, 'getAvailableLines'])->name('getlines');
    Route::post('/get/trips', [BookRideController::class, 'getAvailableTrips'])->name('gettrips');
    Route::post('/get/seats', [BookRideController::class, 'getSeats']);
    Route::post('/book/trip', [BookRideController::class, 'bookTrip']);



});




require __DIR__.'/auth.php';


