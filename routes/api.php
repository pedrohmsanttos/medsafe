<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1'], function () {
    /**
     * LIST: Tabela de Preço
     */
    Route::resource('tabelapreco', 'ProdutoTipoProdutoAPIController', [
        'except' => ['edit', 'show', 'store']
    ]);

    /**
     * CREAT: Corretor
     */
    Route::resource('corretor', 'CorretorAPIController', [
        'except' => ['edit', 'show', 'list']
    ]);

    /**
     * LIST: Corretora
     */
    Route::resource('corretoras', 'CorretoraAPIController', [
        'except' => ['edit', 'show', 'store']
    ]);

    /**
     * LIST: Categoria de produto
     */
    Route::resource('categorias', 'CategoriaProdutosAPIController', [
        'except' => ['edit', 'show', 'store']
    ]);

    /**
     * LIST: Planos
     */
    Route::resource('planos', 'TipoProdutosAPIController', [
        'except' => ['edit', 'show', 'store']
    ]);

    /**
     * LIST: Faturamentos
     */
    Route::resource('faturamentos', 'FaturamentosAPIController', [
        'except' => ['edit', 'show', 'store']
    ]);

    /**
     * CREAT and EDIT: Negocios
     */
    Route::resource('negocios', 'NegocioAPIController');
});
