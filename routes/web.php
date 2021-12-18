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

Route::get('/users/create', [UserController::class, 'create'])
    ->middleware(['auth', 'role:admin', 'verified'])
    ->name('users.create');

Route::post('/users/create', [UserController::class, 'store'])
    ->middleware(['auth', 'role:admin', 'verified']);

Route::get('/users/{user}/edit', [UserController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->can('update', 'user')
    ->name('users.edit');

Route::put('/users/{user}', [UserController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->can('update', 'user')
    ->name('users.update');

Route::delete('/users/{user}', [UserController::class, 'destroy'])
    ->middleware(['auth', 'role:admin', 'verified'])
    ->can('delete', 'user')
    ->name('users.destroy');

Route::put('/users/{user}/password', UpdatePasswordController::class)
    ->middleware(['auth', 'verified'])
    ->can('update-password', 'user')
    ->name('users.updatePassword');

Route::post('/users/resend-reset-link', [UserController::class, 'resendPasswordResetLink'])
    ->middleware(['auth', 'role:admin', 'verified'])
    ->name('users.resetPassworkLink');

require __DIR__ . '/auth.php';
