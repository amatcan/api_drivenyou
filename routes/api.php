<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::post('/auth/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () 
{
    Route::post('/auth/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/auth/user', function (Request $request) {
        return $request->user();
    });
    Route::prefix('/group')->group(function(){
        //usuarios de un grupo
        Route::get('/users/{group}',[App\Http\Controllers\Api\GroupsController::class,'users'])->name('group.users');
    });

    Route::prefix('/user')->group(function(){
        //usuarios de un grupo
        Route::get('/search/{key}',[App\Http\Controllers\Api\UsersController::class,'search'])->name('user.search');
    });

    Route::prefix('/utils')->group(function(){
        //ping y recogida de token
        Route::get('/ping',[App\Http\Controllers\Api\UtilsController::class,'ping'])->name('utils.ping');
    });

    Route::prefix('/colaboradores')->group(function(){
        //colaborador
        Route::get('',[App\Http\Controllers\Api\ColaboradoresController::class,'all'])->name('colaboradores.all');
        Route::get('/profesores',[App\Http\Controllers\Api\ColaboradoresController::class,'profesores'])->name('colaboradores.profesores');
        Route::get('/autoescuelas',[App\Http\Controllers\Api\ColaboradoresController::class,'autoescuelas'])->name('colaboradores.autoescuelas');
    });


});
