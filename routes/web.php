<?php

declare(strict_types=1);

use App\Controllers\UpdateController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use Src\Routing\Route;


return [
    Route::get('/', [LoginController::class, 'form']),
    Route::get('/register', [RegisterController::class, 'form']),
    Route::post('/register', [RegisterController::class, 'register']),
    Route::get('/login', [LoginController::class, 'form']),
    Route::post('/login', [LoginController::class, 'login']),
    Route::post('/logout', [LoginController::class, 'logout']),
    Route::get('/profile', [UpdateController::class, 'index']),
    Route::post('/update', [UpdateController::class, 'update']),

];