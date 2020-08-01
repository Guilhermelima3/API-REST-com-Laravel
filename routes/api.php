<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Rota para products.
 */
Route::apiResource('products','api\ProductController');


/**
 * Erro de acesso a rotas não existentes
 */
Route::fallback(function () {
    return response()->json([
        'message' => 'Página não encontrada. Verifique se a url de acesso está correta.'
    ], 404);
});
