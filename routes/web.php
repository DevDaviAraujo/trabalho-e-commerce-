<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\WebsiteControllers\FeedBackController;
use App\Http\Controllers\WebsiteControllers\WebsiteController;
use App\Http\Controllers\WebsiteControllers\AdminController;
use App\Http\Controllers\WebsiteControllers\CategoriaController;
use App\Http\Controllers\WebsiteControllers\UserController;
use App\Http\Controllers\WebsiteControllers\OfertaController;
use App\Http\Controllers\WebsiteControllers\SubCategoriaController;
use App\Http\Controllers\WebsiteControllers\ProdutoController;
use App\Http\Controllers\WebsiteControllers\MediaController;
use App\Http\Controllers\WebsiteControllers\CarrinhoController;


/*
|--------------------------------------------------------------------------
| ROTAS DO SITE (PÚBLICAS)
|--------------------------------------------------------------------------
*/

Route::get('/', [WebsiteController::class, 'home'])->name("home");
Route::get('/carrinho', [WebsiteController::class, 'carrinho'])->name("carrinho");
Route::get('/fale-conosco', [WebsiteController::class, 'faleConosco'])->name("fale-conosco");
Route::get('/cadastro', [WebsiteController::class, 'cadastro'])->name("cadastro");

Route::get('/categoria/{categoria}/{subcategoria}', [WebsiteController::class, 'subcategoria'])
    ->name('subcategoria');

Route::get('/oferta/{descricao}', [WebsiteController::class, 'oferta'])->name('oferta');
Route::get('/sobre-nos', [WebsiteController::class, 'sobre_nos'])->name("sobre-nos");
Route::get('/produto/{id}', [WebsiteController::class, 'produto'])->name("produto");


/*
|--------------------------------------------------------------------------
| CARRINHO
|--------------------------------------------------------------------------
*/
Route::prefix("/carrinho")->group(function () {
    Route::get('/', [CarrinhoController::class, 'carrinho'])->name('carrinho');
    Route::post('/adicionar', [CarrinhoController::class, 'adicionar'])->name('adicionar_carrinho');
});


/*
|--------------------------------------------------------------------------
| FEEDBACK E USUÁRIO PÚBLICO
|--------------------------------------------------------------------------
*/
Route::post('/cadastrar', [FeedBackController::class, 'cadastrar'])->name('cadastrar-feedback');
Route::post('/cadastrar/usuario', [UserController::class, 'cadastrar'])->name('cadastrar_usuario');

Route::get('/login', [WebsiteController::class, 'login'])->name('login');
Route::get('/perfil/{id}', [WebsiteController::class, 'perfil'])->name("perfil");

Route::post('/logar', [UserController::class, 'logar'])->name('logar');
Route::post('/deslogar', [UserController::class, 'deslogar'])->name('deslogar');


/*
|--------------------------------------------------------------------------
| ROTAS DE AUTENTICAÇÃO DO ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminController::class, 'login'])->name('login_admin');
Route::post('/admin/login', [AdminController::class, 'logar'])->name('admin.logar');
Route::post('/admin/logout', [AdminController::class, 'deslogar'])->name('admin.deslogar');


/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS DO ADMIN (AUTH:ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin'])->prefix('/admin')->group(function () {

    // Home do painel
    Route::get('/', [AdminController::class, 'produtos'])->name('admin_home');


    /*
    |--------------------------------------------------------------------------
    | CATEGORIA
    |--------------------------------------------------------------------------
    */
    Route::prefix("/categoria")->group(function () {
        Route::get('/', [AdminController::class, 'categorias'])->name('categorias');
        Route::get('/cadastro', [AdminController::class, 'categoriaCadastro'])->name('categoria_cadastro');
        Route::get('/cadastro/{id}', [AdminController::class, 'categoriaCadastro'])->name('categoria_edicao');
        Route::get('/deletar/{id}', [AdminController::class, 'categoriaDeletar'])->name('categoria_deletar');

        Route::post('/cadastrar', [CategoriaController::class, 'cadastrar'])->name('cadastrar_categoria');
        Route::post('/deletar', [CategoriaController::class, 'deletar'])->name('deletar_categoria');
    });


    /*
    |--------------------------------------------------------------------------
    | SUBCATEGORIA
    |--------------------------------------------------------------------------
    */
    Route::prefix("/subcategoria")->group(function () {
        Route::get('/', [AdminController::class, 'subcategorias'])->name('subcategorias');
        Route::get('/cadastro', [AdminController::class, 'subcategoriaCadastro'])->name('subcategoria_cadastro');
        Route::get('/cadastro/{id}', [AdminController::class, 'subcategoriaCadastro'])->name('subcategoria_edicao');
        Route::get('/deletar/{id}', [AdminController::class, 'subcategoriaDeletar'])->name('subcategoria_deletar');

        Route::post('/cadastrar', [SubCategoriaController::class, 'cadastrar'])->name('cadastrar_subcategoria');
        Route::post('/deletar', [SubCategoriaController::class, 'deletar'])->name('deletar_subcategoria');
    });


    /*
    |--------------------------------------------------------------------------
    | PRODUTOS
    |--------------------------------------------------------------------------
    */
    Route::prefix("/produto")->group(function () {
        Route::get('/', [AdminController::class, 'produtos'])->name('produtos');
        Route::get('/cadastro', [AdminController::class, 'produtoCadastro'])->name('produto_cadastro');
        Route::get('/cadastro/{id}', [AdminController::class, 'produtoCadastro'])->name('produto_edicao');
        Route::get('/deletar/{id}', [AdminController::class, 'produtoDeletar'])->name('produto_deletar');
        Route::get('/{id}', [AdminController::class, 'produtoVer'])->name('produto_visualizar');

        Route::post('/cadastrar', [ProdutoController::class, 'cadastrar'])->name('cadastrar_produto');
        Route::post('/deletar', [ProdutoController::class, 'deletar'])->name('deletar_produto');
    });


    /*
    |--------------------------------------------------------------------------
    | USUÁRIOS
    |--------------------------------------------------------------------------
    */
    Route::prefix("/user")->group(function () {
        Route::get('/', [AdminController::class, 'users'])->name('users');
        Route::get('/cadastro', [AdminController::class, 'userCadastro'])->name('user_cadastro');
        Route::get('/cadastro/{id}', [AdminController::class, 'userCadastro'])->name('user_edicao');
        Route::get('/deletar/{id}', [AdminController::class, 'userDeletar'])->name('user_deletar');

        Route::post('/cadastrar', [AdminController::class, 'cadastrar'])->name('cadastrar_user');
        Route::post('/deletar', [AdminController::class, 'deletar'])->name('deletar_user');
    });


    /*
    |--------------------------------------------------------------------------
    | OFERTAS
    |--------------------------------------------------------------------------
    */
    Route::prefix("/oferta")->group(function () {
        Route::get('/', [AdminController::class, 'ofertas'])->name('ofertas');
        Route::get('/cadastro', [AdminController::class, 'ofertaCadastro'])->name('oferta_cadastro');
        Route::get('/cadastro/{id}', [AdminController::class, 'ofertaCadastro'])->name('oferta_edicao');
        Route::get('/deletar/{id}', [AdminController::class, 'ofertaDeletar'])->name('oferta_deletar');
        Route::get('/{id}', [AdminController::class, 'ofertaVer'])->name('oferta_visualizar');

        Route::post('/cadastrar', [OfertaController::class, 'cadastrar'])->name('cadastrar_oferta');
        Route::post('/deletar', [OfertaController::class, 'deletar'])->name('deletar_oferta');
    });


    /*
    |--------------------------------------------------------------------------
    | FEEDBACKS
    |--------------------------------------------------------------------------
    */
    Route::prefix("/feedback")->group(function () {
        Route::get('/', [AdminController::class, 'feedbacks'])->name('feedbacks');
        Route::post('/deletar', [FeedBackController::class, 'deletar'])->name('deletar_feedback');
    });


    /*
    |--------------------------------------------------------------------------
    | MÍDIA (IMAGENS / VÍDEOS)
    |--------------------------------------------------------------------------
    */
    Route::post('media/delete/{id}', [MediaController::class, 'destroy'])->name('media.delete');
});


/*
|--------------------------------------------------------------------------
| UTILITÁRIOS
|--------------------------------------------------------------------------
*/
Route::get('/subcategorias/{categoria_id}', [SubCategoriaController::class, 'getByCategoria']);
