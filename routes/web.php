<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteControllers\WebsiteController;

Route::get('/', [WebsiteController::class, 'home'])->name("home");
Route::get('/carrinho', [WebsiteController::class, 'carrinho'])->name("carrinho");
Route::get('/admin/login', [WebsiteController::class, 'admin_login'])->name('login');



Route::middleware(['auth:admin'])->group(function () {
    Route::get('/home', [WebsiteController::class, 'adminHome'])->name('admin_home');
});



Route::post('/logar', [WebsiteController::class, 'fazer_login'])->name('fazer_login');
