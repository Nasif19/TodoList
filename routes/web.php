<?php

use App\Http\Controllers\TodoListController;
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

Route::prefix('todo')->name('todo-list.')->group(function () {
	Route::get('list', [TodoListController::class, 'index'])->name('index');
	Route::post('store', [TodoListController::class, 'store'])->name('store');
	Route::post('update', [TodoListController::class, 'update'])->name('update');
	Route::post('delete', [TodoListController::class, 'delete'])->name('delete');
	Route::post('change-status', [TodoListController::class, 'changeStatus'])->name('changeStatus');
});
