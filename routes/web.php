<?php

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/users/create', [UserController::class, 'create'])
    ->middleware(['auth', 'role:admin', 'verified'])
    ->name('users.create');

Route::post('/users/create', [UserController::class, 'store'])
    ->middleware(['auth', 'role:admin', 'verified']);

require __DIR__ . '/auth.php';
