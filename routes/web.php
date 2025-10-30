<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteControllers\WebsiteController;
use App\Http\Controllers\WebsiteControllers\CategoriaController;
use App\Http\Controllers\WebsiteControllers\SubCategoriaController;
use App\Http\Controllers\WebsiteControllers\ProdutoController;

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


            Route::POST('/cadastrar',[ProdutoController::class,'cadastrar'])->name('cadastrar_produto');
            Route::POST('/deletar',[ProdutoController::class,'deletar'])->name('deletar_produto');
        });

    });
});

Route::get('/subcategorias/{categoria_id}', [SubCategoriaController::class, 'getByCategoria']);

Route::POST('/logar', [WebsiteController::class, 'logar'])->name('logar');
