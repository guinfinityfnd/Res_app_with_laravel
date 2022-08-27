<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes([

    'register' => false, // Register Routes...
  
    'reset' => false, // Reset Password Routes...
  
    'verify' => false, // Email Verification Routes...

    'confirm' => false, // Email Comfirmation Routes...
  
  ]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('order.form');
Route::post('order_submit', [App\Http\Controllers\HomeController::class, 'submit'])->name('order.submit');

Route::resource('dish', App\Http\Controllers\DishesController::class);
Route::get('order', [App\Http\Controllers\DishesController::class, 'order'])->name('kitchen.order');
Route::get('order/{order}/approve', [App\Http\Controllers\DishesController::class, 'approve']);
Route::get('order/{order}/cancel', [App\Http\Controllers\DishesController::class, 'cancel']);
Route::get('order/{order}/ready', [App\Http\Controllers\DishesController::class, 'ready']);

Route::get('order/{order}/serve', [App\Http\Controllers\HomeController::class, 'serve']);

