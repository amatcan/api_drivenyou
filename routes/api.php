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

Route::prefix('/colaboradores')->group(function(){
    Route::get('{id}/image/firma',[App\Http\Controllers\Api\ColaboradoresController::class,'imageFirma'])->name('colaboradores.image.firma');
});

Route::prefix('/clases')->group(function(){
    Route::get('{id}/image/firma/{cual?}',[App\Http\Controllers\Api\ClasesController::class,'imageFirma'])->name('clases.image.firma');
});

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
        Route::post('/{id}/token/{token}', [App\Http\Controllers\Api\UsersController::class, 'setToken']);
        Route::get('/search/{key}',[App\Http\Controllers\Api\UsersController::class,'search'])->name('user.search');
        Route::get('/alumno/{key}',[App\Http\Controllers\Api\UsersController::class,'alumno'])->name('user.alumno');
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
        Route::get('/alumno/{id}/accion/{accion}/{asistencia?}',[App\Http\Controllers\Api\ClasesController::class,'clasesAlumnoByAccion'])->name('clases.alumnobyaccion');
        Route::put('/{id}',[App\Http\Controllers\Api\ClasesController::class,'clasesUpdate'])->where('id', '[0-9]+')->name('clases.update');
        Route::post('/{id}/firma',[App\Http\Controllers\Api\ClasesController::class,'clasesUploadFirma'])->where('id', '[0-9]+')->name('clases.clasesUploadFirma');        
        
    });

    Route::prefix('/acciones')->group(function(){
        Route::get('/colaborador/{id}',[App\Http\Controllers\Api\AccionesformativasController::class,'accionesByColaborador'])->name('acciones.bycolaborador'); 
    });

    Route::prefix('/alumnos')->group(function(){
        Route::get('/colaborador/{id}/{accion?}',[App\Http\Controllers\Api\AlumnosController::class,'alumnosByColaborador'])->name('alumnos.bycolaborador'); 
    });

    Route::prefix('/autoescuelas')->group(function(){
        Route::get('/colaborador/{id}',[App\Http\Controllers\Api\AutoescuelasController::class,'autoescuelaColaborador'])->name('autoescuela.colaborador');
        Route::get('/{id}/profesores',[App\Http\Controllers\Api\AutoescuelasController::class,'autoescuelaProfesores'])->name('autoescuela.colaboradores');
        Route::get('/{id}/vehiculos',[App\Http\Controllers\Api\AutoescuelasController::class,'autoescuelaVehiculos'])->name('autoescuela.vehiculos');
    });

    Route::prefix('/horarios')->group(function(){
        Route::get('/colaborador/{colaborador}/alumnos/{accion?}',[App\Http\Controllers\Api\HorariosController::class,'horariosAlumnosByColaborador'])->name('horarios.horariosAlumnosByColaborador');
        Route::get('/colaborador/{colaborador}/{accion?}',[App\Http\Controllers\Api\HorariosController::class,'horariosColaborador'])->name('horarios.colaborador');        
        
    });

    Route::prefix('/vehiculos')->group(function(){
        Route::get('/marcas',[App\Http\Controllers\Api\VehiculosController::class,'allMarcas'])->name('vehiculos.marcas');
        
    });


});
