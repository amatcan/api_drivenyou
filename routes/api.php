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
        Route::get('/{id}',[App\Http\Controllers\Api\ColaboradoresController::class,'infoColaborador'])->name('colaborador.info');
        Route::get('/{id}/clases/{momento?}',[App\Http\Controllers\Api\ColaboradoresController::class,'clasesColaborador'])->name('colaborador.clases');        
    });

    Route::prefix('/clases')->group(function(){
        Route::get('/colaborador/{id}/{momento?}',[App\Http\Controllers\Api\ClasesController::class,'clasesColaborador'])->name('clases.colaborador');
        Route::get('/alumno/{id}/{momento?}',[App\Http\Controllers\Api\ClasesController::class,'clasesAlumno'])->name('clases.alumno');
    });

    Route::prefix('/autoescuelas')->group(function(){
        Route::get('/colaborador/{id}',[App\Http\Controllers\Api\AutoescuelasController::class,'autoescuelaColaborador'])->name('autoescuela.colaborador');
    });

    Route::prefix('/horarios')->group(function(){
        Route::get('/colaborador/{colaborador}/{accion}?',[App\Http\Controllers\Api\HorariosController::class,'horariosColaborador'])->name('horarios.colaborador');
    });


});
