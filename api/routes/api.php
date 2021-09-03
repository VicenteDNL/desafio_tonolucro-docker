<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RestauranteController;
use App\Http\Controllers\API\CardapioController;
use App\Http\Controllers\API\ProdutoController;

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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', [AuthController::class, 'me']);

    #Restautante
    Route::apiResource('restaurante', RestauranteController::class)->only([
        'store', 'update','destroy'
    ]);

    #Cardápio
    Route::apiResource('cardapio', CardapioController::class)->only([
        'store', 'update','destroy'
    ]);

    #Produto
    Route::apiResource('produto', ProdutoController::class)->only([
        'store', 'update','destroy'
    ]);

});

#Autenticação
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

#Restautante
Route::apiResource('restaurante', RestauranteController::class)->only([
    'index', 'show'
]);

#Cardápio
Route::apiResource('cardapio', CardapioController::class)->only([
    'index', 'show'
]);

#Produto
Route::apiResource('produto', ProdutoController::class)->only([
    'index', 'show'
]);
