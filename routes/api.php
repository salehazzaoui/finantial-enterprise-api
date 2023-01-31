<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Entreprise\CreateController;
use App\Http\Controllers\Entreprise\DeleteController;
use App\Http\Controllers\Entreprise\GetController;
use App\Http\Controllers\Entreprise\UpdateController;
use App\Http\Controllers\Transaction\CreateController as TransactionCreateController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

require __DIR__ . '/auth.php';

// public routes
Route::get('/entreprises', [GetController::class, 'getAllEntreprises']);
Route::get('/entreprises/{id}', [GetController::class, 'getEntreprise']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/entreprise/{entrepriseId}/transaction', [TransactionCreateController::class, 'store']);
    Route::get('/entreprise/{entrepriseId}/transaction', [UserController::class, 'filterEntrepriseTransactions']);

    Route::put('/users/info', [ProfileController::class, 'editProfile']);
    Route::put('/users/password', [ProfileController::class, 'updatePassword']);

    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::post('/users/{userId}/entreprise/{entrepriseId}', [AdminController::class, 'addUserToEntreprise']);
        Route::get('/users', [AdminController::class, 'searchUser']);
        Route::post('/users', [AdminController::class, 'addUser']);
        Route::put('/users/{id}', [AdminController::class, 'updateUser']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);

        Route::post('/entreprises', [CreateController::class, 'store']);
        Route::put('/entreprises/{id}', [UpdateController::class, 'update']);
        Route::delete('/entreprises/{id}', [DeleteController::class, 'destroy']);
    });
});
