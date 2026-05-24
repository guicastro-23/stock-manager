<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ContagemEstoqueController;


Route::get('/contagens-estoque', [ContagemEstoqueController::class, 'Index']);
Route::get('/contagens-estoque/{contagem}', [ContagemEstoqueController::class, 'apiShow']);
