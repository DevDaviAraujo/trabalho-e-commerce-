<?php

use App\Http\Controllers\WebsiteControllers\FeedBackController;
use App\Http\Controllers\WebsiteControllers\WebsiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteControllers\AdminController;
use App\Http\Controllers\WebsiteControllers\CategoriaController;
use App\Http\Controllers\WebsiteControllers\UserController;
use App\Http\Controllers\WebsiteControllers\OfertaController;
use App\Http\Controllers\WebsiteControllers\SubCategoriaController;
use App\Http\Controllers\WebsiteControllers\ProdutoController;
use App\Http\Controllers\WebsiteControllers\MediaController;

Route::GET('/', [WebsiteController::class, 'home'])->name("home");
Route::GET('/carrinho', [WebsiteController::class, 'carrinho'])->name("carrinho");
Route::GET('/fale-conosco', [WebsiteController::class, 'faleConosco'])->name("fale-conosco");
Route::GET('/admin/login', [AdminController::class, 'login'])->name('login');
route::POST('/cadastrar', [FeedBackController::class, 'cadastrar'])->name('cadastrar-feedback');

Route::middleware(['auth'])->group(function () {

    Route::prefix("/admin")->group(function () {
        Route::GET('/', [AdminController::class, 'produtos'])->name('admin_home');

        Route::prefix("/categoria")->group(function () {
            Route::GET('/', [AdminController::class, 'categorias'])->name('categorias');
            Route::GET('/cadastro', [AdminController::class, 'categoriaCadastro'])->name('categoria_cadastro');
            Route::GET('/cadastro/{id}', [AdminController::class, 'categoriaCadastro'])->name('categoria_edicao');
            Route::GET('/deletar/{id}', [AdminController::class, 'categoriaDeletar'])->name('categoria_deletar');


            Route::POST('/cadastrar', [CategoriaController::class, 'cadastrar'])->name('cadastrar_categoria');
            Route::POST('/deletar', [CategoriaController::class, 'deletar'])->name('deletar_categoria');
        });

        Route::prefix("/subcategoria")->group(function () {
            Route::GET('/', [AdminController::class, 'subcategorias'])->name('subcategorias');
            Route::GET('/cadastro', [AdminController::class, 'subcategoriaCadastro'])->name('subcategoria_cadastro');
            Route::GET('/cadastro/{id}', [AdminController::class, 'subcategoriaCadastro'])->name('subcategoria_edicao');
            Route::GET('/deletar/{id}', [AdminController::class, 'subcategoriaDeletar'])->name('subcategoria_deletar');


            Route::POST('/cadastrar', [SubCategoriaController::class, 'cadastrar'])->name('cadastrar_subcategoria');
            Route::POST('/deletar', [SubCategoriaController::class, 'deletar'])->name('deletar_subcategoria');
        });


        Route::prefix("/produto")->group(function () {
            Route::GET('/', [AdminController::class, 'produtos'])->name('produtos');
            Route::GET('/cadastro', [AdminController::class, 'produtoCadastro'])->name('produto_cadastro');
            Route::GET('/cadastro/{id}', [AdminController::class, 'produtoCadastro'])->name('produto_edicao');
            Route::GET('/deletar/{id}', [AdminController::class, 'produtoDeletar'])->name('produto_deletar');
            Route::GET('/{id}', [AdminController::class, 'produtoVer'])->name('produto_visualizar');


            Route::POST('/cadastrar', [ProdutoController::class, 'cadastrar'])->name('cadastrar_produto');
            Route::POST('/deletar', [ProdutoController::class, 'deletar'])->name('deletar_produto');
        });

        Route::prefix("/user")->group(function () {
            Route::GET('/', [AdminController::class, 'users'])->name('users');
            Route::GET('/cadastro', [AdminController::class, 'userCadastro'])->name('user_cadastro');
            Route::GET('/cadastro/{id}', [AdminController::class, 'userCadastro'])->name('user_edicao');
            Route::GET('/deletar/{id}', [AdminController::class, 'userDeletar'])->name('user_deletar');


            Route::POST('/cadastrar', [UserController::class, 'cadastrar'])->name('cadastrar_user');
            Route::POST('/deletar', [UserController::class, 'deletar'])->name('deletar_user');
        });

        Route::prefix("/oferta")->group(function () {
            Route::GET('/', [AdminController::class, 'ofertas'])->name('ofertas');
            Route::GET('/cadastro', [AdminController::class, 'ofertaCadastro'])->name('oferta_cadastro');
            Route::GET('/cadastro/{id}', [AdminController::class, 'ofertaCadastro'])->name('oferta_edicao');
            Route::GET('/deletar/{id}', [AdminController::class, 'ofertaDeletar'])->name('oferta_deletar');
            Route::GET('/{id}', [AdminController::class, 'ofertaVer'])->name('oferta_visualizar');


            Route::POST('/cadastrar', [OfertaController::class, 'cadastrar'])->name('cadastrar_oferta');
            Route::POST('/deletar', [OfertaController::class, 'deletar'])->name('deletar_oferta');
        });

        Route::prefix("/feedback")->group(function () {
            Route::GET('/', [AdminController::class, 'feedbacks'])->name('feedbacks');
            Route::POST('/deletar', [FeedBackController::class, 'deletar'])->name('deletar_feedback');
        });

        Route::POST('media/delete/{id}', [MediaController::class, 'destroy'])->name('media.delete');

    });
});

Route::get('/subcategorias/{categoria_id}', [SubCategoriaController::class, 'getByCategoria']);

Route::POST('/logar', [UserController::class, 'logar'])->name('logar');
Route::POST('/deslogar', [UserController::class, 'deslogar'])->name('deslogar');

