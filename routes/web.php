<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExpenseController;

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
    Route::get('/', function() { return redirect()->route('events.index'); });
    Route::resource('events', EventController::class);
    Route::post('events/{event}/participants', [ParticipantController::class, 'store'])->name('participants.store');
    Route::post('participants/{participant}/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::post('events/{event}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
});

require __DIR__.'/auth.php';
