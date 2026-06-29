<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
<<<<<<< HEAD
=======
use App\Http\Controllers\EnderecoController;
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StoreController::class, 'index'])->name('home');
Route::get('/produto/{slug}', [StoreController::class, 'produto'])->name('produto.show');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'entrar'])->name('login.entrar');
Route::get('/cadastro', [AuthController::class, 'cadastroForm'])->name('cadastro');
Route::post('/cadastro', [AuthController::class, 'cadastrar'])->name('cadastro.salvar');
Route::post('/logout', [AuthController::class, 'sair'])->name('logout');

Route::get('/carrinho', [StoreController::class, 'carrinho'])->name('carrinho');
Route::post('/carrinho/adicionar/{produto}', [StoreController::class, 'adicionarCarrinho'])->name('carrinho.adicionar');
Route::delete('/carrinho/remover/{produtoId}', [StoreController::class, 'removerCarrinho'])->name('carrinho.remover');
Route::delete('/carrinho/limpar', [StoreController::class, 'limparCarrinho'])->name('carrinho.limpar');

Route::get('/checkout', [StoreController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [StoreController::class, 'finalizarCompra'])->name('checkout.finalizar');

Route::get('/biblioteca', [StoreController::class, 'biblioteca'])->name('biblioteca');
<<<<<<< HEAD
Route::get('/jogos', fn () => redirect('/biblioteca'));
=======
Route::get('/jogos', fn() => redirect('/biblioteca'));

Route::get('/enderecos', [EnderecoController::class, 'index'])->name('enderecos');
Route::post('/enderecos', [EnderecoController::class, 'salvar'])->name('enderecos.salvar');
Route::delete('/enderecos/{endereco}', [EnderecoController::class, 'excluir'])->name('enderecos.excluir');
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a

Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin');
Route::get('/admin/categorias', [AdminController::class, 'categorias'])->name('admin.categorias');
Route::post('/admin/categorias', [AdminController::class, 'salvarCategoria'])->name('admin.categorias.salvar');
Route::delete('/admin/categorias/{categoria}', [AdminController::class, 'excluirCategoria'])->name('admin.categorias.excluir');

Route::get('/admin/plataformas', [AdminController::class, 'plataformas'])->name('admin.plataformas');
Route::post('/admin/plataformas', [AdminController::class, 'salvarPlataforma'])->name('admin.plataformas.salvar');
Route::delete('/admin/plataformas/{plataforma}', [AdminController::class, 'excluirPlataforma'])->name('admin.plataformas.excluir');

<<<<<<< HEAD
=======
Route::get('/admin/cidades', [AdminController::class, 'cidades'])->name('admin.cidades');
Route::post('/admin/cidades', [AdminController::class, 'salvarCidade'])->name('admin.cidades.salvar');
Route::delete('/admin/cidades/{cidade}', [AdminController::class, 'excluirCidade'])->name('admin.cidades.excluir');

>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
Route::get('/admin/produtos', [AdminController::class, 'produtos'])->name('admin.produtos');
Route::post('/admin/produtos', [AdminController::class, 'salvarProduto'])->name('admin.produtos.salvar');
Route::delete('/admin/produtos/{produto}', [AdminController::class, 'excluirProduto'])->name('admin.produtos.excluir');

// Mantém compatibilidade com as páginas antigas do projeto.
<<<<<<< HEAD
Route::get('/developer', fn () => redirect('/admin/produtos'));
Route::get('/upload', fn () => redirect('/admin/produtos'));


use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index']);
=======
Route::get('/developer', fn() => redirect('/admin/produtos'));
Route::get('/upload', fn() => redirect('/admin/produtos'));
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
