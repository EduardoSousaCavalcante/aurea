<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Models\Card;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CarouselController;

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

    // CRUD dos carrosséis
    Route::get('/dev/carousels', [CarouselController::class, 'index'])->name('carousels.index');
    Route::get('/dev/carousels/create', [CarouselController::class, 'create'])->name('carousels.create');
    Route::post('/dev/carousels', [CarouselController::class, 'store'])->name('carousels.store');
    Route::get('/dev/carousels/{carousel}/edit', [CarouselController::class, 'edit'])->name('carousels.edit');
    Route::put('/dev/carousels/{carousel}', [CarouselController::class, 'update'])->name('carousels.update');
    Route::delete('/dev/carousels/{carousel}', [CarouselController::class, 'destroy'])->name('carousels.destroy');
});
