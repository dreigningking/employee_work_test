<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::group(['middleware'=> 'auth:sanctum'],function(){
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('create', [HomeController::class, 'create'])->name('create');
    Route::post('store', [HomeController::class, 'store'])->name('store');
    Route::get('show/{employee}', [HomeController::class, 'show'])->name('show');
    Route::get('edit/{employee}', [HomeController::class, 'edit'])->name('edit');
    Route::put('update', [HomeController::class, 'update'])->name('update');
    Route::delete('delete', [HomeController::class, 'destroy'])->name('delete');    
});

