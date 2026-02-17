<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Models\Card;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ClienteController;

// Página pública (inicio)
Route::get('/', function () {
    // Cards em ordem cronológica (do mais novo para o mais antigo)
    $cards = \App\Models\Card::orderBy('created_at', 'desc')->get();
    // Cards mais visualizados (top 4, por exemplo)
    $mostViewedCards = Card::orderBy('views', 'desc')->take(4)->get();
    $carousels = \App\Models\Carousel::all(); // Pega todos os carousels do banco
    return view('inicio', compact('cards', 'mostViewedCards', 'carousels'));
})->name('inicio');

// Autenticação
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Área restrita (só acessa logado)
Route::middleware('auth')->group(function () {
        // CRUD dos produtos
        Route::get('/dev/produtos', [App\Http\Controllers\ProdutoController::class, 'index'])->name('produtos.index');
        Route::get('/dev/produtos/create', [App\Http\Controllers\ProdutoController::class, 'create'])->name('produtos.create');
        Route::post('/dev/produtos', [App\Http\Controllers\ProdutoController::class, 'store'])->name('produtos.store');
        Route::get('/dev/produtos/{produto}/edit', [App\Http\Controllers\ProdutoController::class, 'edit'])->name('produtos.edit');
        Route::put('/dev/produtos/{produto}', [App\Http\Controllers\ProdutoController::class, 'update'])->name('produtos.update');
        Route::delete('/dev/produtos/{produto}', [App\Http\Controllers\ProdutoController::class, 'destroy'])->name('produtos.destroy');
        // Autocomplete produtos (AJAX)
        Route::get('/dev/produtos/autocomplete', [App\Http\Controllers\ProdutoController::class, 'autocomplete'])->name('produtos.autocomplete');
    // Área Dev
    Route::get('/dev', function () {
        return view('dev.index');
    })->name('dev.index');

    // CRUD dos cards
    Route::get('/dev/cards', [CardController::class, 'index'])->name('cards.index');
    Route::get('/dev/cards/create', [CardController::class, 'create'])->name('cards.create');
    Route::post('/dev/cards', [CardController::class, 'store'])->name('dev.cards.store');
    Route::get('/dev/cards/{card}/edit', [CardController::class, 'edit'])->name('cards.edit');
    Route::put('/dev/cards/{card}', [CardController::class, 'update'])->name('cards.update');
    Route::delete('/dev/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');

    //CRUD dos pedidos
    Route::get('/dev/pedidos', [App\Http\Controllers\PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/dev/pedidos/create', [App\Http\Controllers\PedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/dev/pedidos', [App\Http\Controllers\PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/dev/pedidos/{pedido}', [App\Http\Controllers\PedidoController::class, 'show'])->name('pedidos.show');
    Route::get('/dev/pedidos/{pedido}/edit', [App\Http\Controllers\PedidoController::class, 'edit'])->name('pedidos.edit');
    Route::put('/dev/pedidos/{pedido}', [App\Http\Controllers\PedidoController::class, 'update'])->name('pedidos.update');
    Route::delete('/dev/pedidos/{pedido}', [App\Http\Controllers\PedidoController::class, 'destroy'])->name('pedidos.destroy');
    
    //CRUD dos clientes
    Route::get('/dev/clientes', [App\Http\Controllers\ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/dev/clientes/create', [App\Http\Controllers\ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/dev/clientes', [App\Http\Controllers\ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/dev/clientes/{cliente}/edit', [App\Http\Controllers\ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/dev/clientes/{cliente}', [App\Http\Controllers\ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/dev/clientes/{cliente}', [App\Http\Controllers\ClienteController::class, 'destroy'])->name('clientes.destroy');

    // CRUD dos carrosséis
    Route::get('/dev/carousels', [CarouselController::class, 'index'])->name('carousels.index');
    Route::get('/dev/carousels/create', [CarouselController::class, 'create'])->name('carousels.create');
    Route::post('/dev/carousels', [CarouselController::class, 'store'])->name('carousels.store');
    Route::get('/dev/carousels/{carousel}/edit', [CarouselController::class, 'edit'])->name('carousels.edit');
    Route::put('/dev/carousels/{carousel}', [CarouselController::class, 'update'])->name('carousels.update');
    Route::delete('/dev/carousels/{carousel}', [CarouselController::class, 'destroy'])->name('carousels.destroy');
});
