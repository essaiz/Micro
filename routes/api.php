<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\NotaController;


Route::apiResource('estudiantes', EstudianteController::class);
Route::get('notas/{estudiante_id}', [NotaController::class, 'index']);
Route::post('notas/{estudiante_id}', [NotaController::class, 'store']);
Route::delete('notas/{id}', [NotaController::class, 'destroy']);

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
