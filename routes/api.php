<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\EstudianteController;


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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/estudiantes', [EstudianteController::class, 'index']);
Route::get('/estudiantes/{id}', [EstudianteController::class, 'show']);
Route::post('/estudiantes', [EstudianteController::class, 'store']);
Route::put('/estudiantes/{id}', [EstudianteController::class, 'update']);
Route::delete('/estudiantes/{id}', [EstudianteController::class, 'destroy']);
Route::get('/estudiantes/filter', [EstudianteController::class, 'filter']);

Route::get('notas/{estudiante_id}', [NotaController::class, 'index']);
Route::post('notas/{estudiante_id}', [NotaController::class, 'store']); 
Route::put('notas/{id}', [NotaController::class, 'update']); 
Route::delete('notas/{id}', [NotaController::class, 'destroy']);
