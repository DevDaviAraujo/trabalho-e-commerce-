<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteControllers\WebsiteController;
use App\Http\Controllers\WebsiteControllers\CategoriaController;
use App\Http\Controllers\WebsiteControllers\UserController;
use App\Http\Controllers\WebsiteControllers\OfertaController;
use App\Http\Controllers\WebsiteControllers\SubCategoriaController;
use App\Http\Controllers\WebsiteControllers\ProdutoController;
use App\Http\Controllers\WebsiteControllers\MediaController;

Route::GET('/', [WebsiteController::class, 'home'])->name("home");
Route::GET('/carrinho', [WebsiteController::class, 'carrinho'])->name("carrinho");
Route::GET('/admin/login', [WebsiteController::class, 'admin_login'])->name('login');



Route::middleware(['auth'])->group(function () {

    Route::prefix("/admin")->group(function () {
        Route::GET('/', [WebsiteController::class, 'produtos'])->name('admin_home');


        Route::prefix("/categoria")->group(function () {
            Route::GET('/', [WebsiteController::class, 'categorias'])->name('categorias');
            Route::GET('/cadastro', [WebsiteController::class, 'categoriaCadastro'])->name('categoria_cadastro');
            Route::GET('/cadastro/{id}', [WebsiteController::class, 'categoriaCadastro'])->name('categoria_edicao');
            Route::GET('/deletar/{id}', [WebsiteController::class, 'categoriaDeletar'])->name('categoria_deletar');


            Route::POST('/cadastrar',[CategoriaController::class,'cadastrar'])->name('cadastrar_categoria');
            Route::POST('/deletar',[CategoriaController::class,'deletar'])->name('deletar_categoria');
        });

        Route::prefix("/subcategoria")->group(function () {
            Route::GET('/', [WebsiteController::class, 'subcategorias'])->name('subcategorias');
            Route::GET('/cadastro', [WebsiteController::class, 'subcategoriaCadastro'])->name('subcategoria_cadastro');
            Route::GET('/cadastro/{id}', [WebsiteController::class, 'subcategoriaCadastro'])->name('subcategoria_edicao');
            Route::GET('/deletar/{id}', [WebsiteController::class, 'subcategoriaDeletar'])->name('subcategoria_deletar');


            Route::POST('/cadastrar',[SubCategoriaController::class,'cadastrar'])->name('cadastrar_subcategoria');
            Route::POST('/deletar',[SubCategoriaController::class,'deletar'])->name('deletar_subcategoria');
        });


        Route::prefix("/produto")->group(function () {
            Route::GET('/', [WebsiteController::class, 'produtos'])->name('produtos');
            Route::GET('/cadastro', [WebsiteController::class, 'produtoCadastro'])->name('produto_cadastro');
            Route::GET('/cadastro/{id}', [WebsiteController::class, 'produtoCadastro'])->name('produto_edicao');
            Route::GET('/deletar/{id}', [WebsiteController::class, 'produtoDeletar'])->name('produto_deletar');
            Route::GET('/{id}', [WebsiteController::class, 'produtoVer'])->name('produto_visualizar');


            Route::POST('/cadastrar',[ProdutoController::class,'cadastrar'])->name('cadastrar_produto');
            Route::POST('/deletar',[ProdutoController::class,'deletar'])->name('deletar_produto');
        });

        Route::prefix("/user")->group(function () {
            Route::GET('/', [WebsiteController::class, 'users'])->name('users');
            Route::GET('/cadastro', [WebsiteController::class, 'userCadastro'])->name('user_cadastro');
            Route::GET('/cadastro/{id}', [WebsiteController::class, 'userCadastro'])->name('user_edicao');
            Route::GET('/deletar/{id}', [WebsiteController::class, 'userDeletar'])->name('user_deletar');


            Route::POST('/cadastrar',[UserController::class,'cadastrar'])->name('cadastrar_user');
            Route::POST('/deletar',[UserController::class,'deletar'])->name('deletar_user');
        });

         Route::prefix("/oferta")->group(function () {
            Route::GET('/', [WebsiteController::class, 'ofertas'])->name('ofertas');
            Route::GET('/cadastro', [WebsiteController::class, 'ofertaCadastro'])->name('oferta_cadastro');
            Route::GET('/cadastro/{id}', [WebsiteController::class, 'ofertaCadastro'])->name('oferta_edicao');
            Route::GET('/deletar/{id}', [WebsiteController::class, 'ofertaDeletar'])->name('oferta_deletar');
            Route::GET('/{id}', [WebsiteController::class, 'ofertaVer'])->name('oferta_visualizar');


            Route::POST('/cadastrar',[OfertaController::class,'cadastrar'])->name('cadastrar_oferta');
            Route::POST('/deletar',[OfertaController::class,'deletar'])->name('deletar_oferta');
        });

        Route::POST('media/delete/{id}', [MediaController::class, 'destroy'])->name('media.delete');

    });
});

Route::get('/subcategorias/{categoria_id}', [SubCategoriaController::class, 'getByCategoria']);

Route::POST('/logar', [UserController::class, 'logar'])->name('logar');
Route::POST('/deslogar', [UserController::class, 'deslogar'])->name('deslogar');

