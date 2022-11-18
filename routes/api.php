<?php

use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Agregando Rutas (apiResource)
/*
    GET /api/categoria              (index -> listar)
    POST /api/categoria             (store -> guardar)
    GET /api/categoria/{id}         (show -> mostrar)
    PUT /api/categoria/{id}         (update -> modificar)
    DELETE /api/categoria/{id}      (destroy -> eliminar)
*/
Route::apiResource("categoria", CategoriaController::class);
Route::apiResource("producto", ProductoController::class);
Route::apiResource("cliente", ClienteController::class);
Route::apiResource("pedido", PedidoController::class);
Route::apiResource("usuario", UsuarioController::class);
