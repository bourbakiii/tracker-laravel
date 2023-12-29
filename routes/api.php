<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

;

use App\Http\Controllers\ProjectsController;

;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('signin', 'login');
    Route::post('signup', 'create');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('me', 'me');
});

Route::prefix('projects')->controller(ProjectsController::class)->group(function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'getById');
    Route::post('/', 'create');
    Route::put('/', 'edit');
    Route::delete('/{id}', 'delete');
});

