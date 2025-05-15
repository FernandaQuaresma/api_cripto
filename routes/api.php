<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCriptoController;

Route::get('/bateu', function () {
    return response()->json(['message' => 'Bateu']);
});

Route::post('/cripto', [ApiCriptoController::class, 'store']);


Route::get('/', function() {
    return response()->json(['sucesso' => true]);
});Route::get('/cripto', [ApiCriptoController::class, 'index']);
Route::get('/cripto/{codigo}', [ApiCriptoController::class, 'show']);
Route::put('/cripto/{codigo}', [ApiCriptoController::class, 'update']);
Route::delete('/cripto/{id}', [ApiCriptoController::class, 'destroy']);
