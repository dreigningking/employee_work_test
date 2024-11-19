<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('test',function(){
    return 'good';
});
Route::post('login',[HomeController::class,'api_login']);
Route::group(['middleware'=> 'auth:sanctum'],function(){
    Route::get('employees',[HomeController::class,'index']);
    Route::post('employees',[HomeController::class,'store']);
    Route::get('employees/{employee}',[HomeController::class,'show']);
    Route::put('employees/{employee}',[HomeController::class,'api_update']);
    Route::delete('employees/{employee}',[HomeController::class,'api_delete']);
});
