<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ContagemEstoqueController;


Route::get('/contagens-estoque', [ContagemEstoqueController::class, 'index']);
Route::post('/contagens-estoque', [ContagemEstoqueController::class, 'store']);
Route::get('/contagens-estoque/{contagem}', [ContagemEstoqueController::class, 'show']);
Route::put('/contagens-estoque/{id}', [ContagemEstoqueController::class, 'update']);
Route::delete('/contagens-estoque/{id}', [ContagemEstoqueController::class,'destroy']);
Route::patch('/contagens-estoque/{id}/status', [ContagemEstoqueController::class,'updateStatus']);
