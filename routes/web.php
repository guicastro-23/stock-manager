<?php

use App\Http\Controllers\ContagemEstoqueController;
use App\Http\Controllers\ItemContagemEstoqueController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function(){
    Route::get('/contagens/{contagem}', [ContagemEstoqueController::class, 'show'])
        ->name('contagens.show');
    Route::patch('/itens-contagem-estoque/{item}',[ItemContagemEstoqueController::class, 'update'])
        ->name('itens-contagem.update');
    Route::patch('/itens-contagem-estoque/{item}/observacao',[ItemContagemEstoqueController::class, 'updateObservacao'])
        ->name('itens-contagem.observacao');
    Route::patch('/contagens-estoque/{contagem}/status',[ContagemEstoqueController::class, 'updateStatus'])
        ->name('contagens-estoque.status');
    Route::post('/contagens-estoque', [ContagemEstoqueController::class, 'store'])
        ->name('contagens-estoque.store');
    Route::get('/contagens-estoque/create', [ContagemEstoqueController::class, 'create'])
        ->name('contagens-estoque.create');
    Route::get('/contagens-estoque', [ContagemEstoqueController::class, 'index'])
        ->name('contagens-estoque.index');
    Route::delete('/contagens-estoque/{id}', [ContagemEstoqueController::class,'destroy'])
        ->name('contagens-estoque.destroy');
    


});


require __DIR__.'/auth.php';
