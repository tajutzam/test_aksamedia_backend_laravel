<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NilaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("/login" ,[AuthController::class , "authenticate"])->middleware(['guestApi']);


Route::middleware("auth:sanctum")->group(function(){
    Route::get("divisions" , [DivisionController::class , "getAll"]);
    Route::post("employees" , [EmployeeController::class , "store"]);
    Route::get("employees" , [EmployeeController::class , "getAll"]);
    Route::delete("/employees/{id}" , [EmployeeController::class , "destroy"]);
    Route::put("/employees/{id}" , [EmployeeController::class , "update"]);
    Route::post("/logout" , [AuthController::class , "logout"]);





});


Route::get("/nilaiRT" , [NilaiController::class , "getNilaiRT"]);
Route::get("/nilaiST" , [NilaiController::class , "getNilaiST"]);
