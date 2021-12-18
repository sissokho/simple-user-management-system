<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UpdatePasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])
    ->prefix('users')
    ->name('users.')
    ->group(function () {
        Route::get('/create', [UserController::class, 'create'])
            ->middleware(['role:admin'])
            ->name('create');

        Route::post('/', [UserController::class, 'store'])
            ->middleware(['role:admin'])
            ->name('store');

        Route::get('/{user}/edit', [UserController::class, 'edit'])
            ->can('update', 'user')
            ->name('edit');

        Route::put('/{user}', [UserController::class, 'update'])
            ->can('update', 'user')
            ->name('update');

        Route::delete('/{user}', [UserController::class, 'destroy'])
            ->middleware(['role:admin'])
            ->can('delete', 'user')
            ->name('destroy');

        Route::put('/{user}/password', UpdatePasswordController::class)
            ->can('update-password', 'user')
            ->name('updatePassword');

        Route::post('/resend-reset-link', [UserController::class, 'resendPasswordResetLink'])
            ->middleware(['role:admin'])
            ->name('resetPassworkLink');
    });

require __DIR__ . '/auth.php';
