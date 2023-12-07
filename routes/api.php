<?php

declare(strict_types = 1);

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HourController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('send-email-reset-password', [AuthController::class, 'resetPasswordRequest']);
Route::post('reset-password', [AuthController::class, 'updatePassword']);
Route::get('get-user-to-register/{user:invite_token}', [AuthController::class, 'userToRegister']);
Route::post('register/{user:invite_token}', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    Route::resource('users', UserController::class);
    Route::post('users/{user}/reinvite', [UserController::class, 'reinvite']);

    Route::resource('companies', CompanyController::class);
    Route::get('companies/{user}/get', [CompanyController::class, 'getCompaniesOfUser']);

    Route::resource('hours', HourController::class);
});
