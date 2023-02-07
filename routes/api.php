<?php

use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SanctumAuthController;
use GuzzleHttp\Middleware;
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

// Protegiendo las rutas con sanctum, para acceder tenemos que loggearnos
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource("categoria", CategoriaController::class);
    Route::apiResource("producto", ProductoController::class);
    Route::apiResource("cliente", ClienteController::class);
    Route::get("search", [ClienteController::class, 'search']);
    Route::apiResource("pedido", PedidoController::class);
    Route::apiResource("usuario", UsuarioController::class);
});


// JWT-AUTH
// Route::group([

//     'middleware' => 'api',
//     'prefix' => 'auth'

// ], function ($router) {

//     //Route::post('login', 'AuthController@login');
//     Route::post('login', [AuthController::class, 'login']);
//     Route::post('logout', [AuthController::class, 'logout']);
//     Route::post('refresh', [AuthController::class, 'refresh']);
//     Route::post('me', [AuthController::class, 'me']);
// });


// SANCTUM

// las rutas de login y registro no es necesario proteger
Route::post('login', [SanctumAuthController::class, 'login']);
Route::post('registro', [SanctumAuthController::class, 'registro']);

// rutas de perfil y logout (cerrar sesion) es necerio proteger
Route::middleware('auth:sanctum')->group(function () {
    Route::get('perfil', [SanctumAuthController::class, 'perfil']);
    // refresh sin funcionar todavia
    Route::get('refresh', [SanctumAuthController::class, 'refresh']);
    Route::post('logout', [SanctumAuthController::class, 'logout']);
});
