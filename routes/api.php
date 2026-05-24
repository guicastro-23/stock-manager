<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContagemEstoqueController;
use App\Http\Controllers\Api\ItemContagemEstoqueController;

// Api de Contagem 
Route::get('/contagens-estoque', [ContagemEstoqueController::class, 'index']);
Route::post('/contagens-estoque', [ContagemEstoqueController::class, 'store']);
Route::get('/contagens-estoque/{contagem}', [ContagemEstoqueController::class, 'show']);
Route::put('/contagens-estoque/{id}', [ContagemEstoqueController::class, 'update']);
Route::delete('/contagens-estoque/{id}', [ContagemEstoqueController::class,'destroy']);
Route::patch('/contagens-estoque/{id}/status', [ContagemEstoqueController::class,'updateStatus']);


// Api de Itens de Contagem 
Route::get('/contagens-estoque/{contagens}/itens', [ItemContagemEstoqueController::class, 'index']);
Route::get('/contagens-estoque/{contagens}/itens/situacao', [ItemContagemEstoqueController::class, 'situacao']);
Route::patch('/itens-contagem-estoque/{id}', [ItemContagemEstoqueController::class, 'update']);
Route::post('/itens-contagem-estoque/{id}/confirmar', [ItemContagemEstoqueController::class, 'confirmar']);

