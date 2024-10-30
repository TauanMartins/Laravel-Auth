<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('validate.keycloak.token')->group(function () {
//     Route::get('/welcome', [UserAccountController::class, 'changeUserPassword']);
// }); 
Route::post('/auth/login', [AuthController::class, 'login']);