<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:superAdmin'])->group(function () {
    Route::post('/assign_role', [UserController::class, 'dodajRolu']);
Route::post('/check_role', [UserController::class, 'provjeriRolu']);
Route::post('/remove_role', [UserController::class, 'obrisiRolu']);
});



