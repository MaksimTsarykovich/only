<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Controllers\RegisterController;
use Src\Routing\Route;


return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/db', [HomeController::class, 'db']),
    Route::get('/register', [RegisterController::class, 'form']),
    Route::post('/register', [RegisterController::class, 'register']),
    Route::post('/show', [PostController::class, 'create']),

];