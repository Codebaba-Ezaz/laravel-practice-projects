<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class ,'showLogin'])->name('login');
Route::post('/login', [AuthController::class ,'login']);
Route::get('/dashboard', [AuthController::class,'dashboard'])->name('dashboard');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');