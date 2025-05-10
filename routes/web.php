<?php

declare(strict_types=1);

use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use Src\Routing\Route;


return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/db', [HomeController::class, 'db']),
    Route::get('/register', [RegisterController::class, 'form']),
    Route::post('/register', [RegisterController::class, 'register']),
    Route::get('/login', [LoginController::class, 'form']),
    Route::post('/login', [LoginController::class, 'login']),
    Route::get('/dashboard', [DashboardController::class, 'index']),

];