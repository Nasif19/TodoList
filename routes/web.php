<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->prefix('todo')->name('todo-list.')->group(function () {
	Route::get('list', [TodoController::class, 'index'])->name('index');
	Route::post('store', [TodoController::class, 'store'])->name('store');
	Route::post('update', [TodoController::class, 'update'])->name('update');
	Route::post('delete', [TodoController::class, 'delete'])->name('delete');
	Route::post('change-status', [TodoController::class, 'changeStatus'])->name('changeStatus');
});

