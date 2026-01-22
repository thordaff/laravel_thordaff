<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PatientController;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Hospital Routes
    Route::resource('hospitals', HospitalController::class);
    
    // Patient Routes
    Route::resource('patients', PatientController::class);
    
    // Default redirect after login
    Route::get('/home', function () {
        return redirect('/hospitals');
    });
});