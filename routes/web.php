<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteControllers\WebsiteController;

Route::get('/',[WebsiteController::class, 'home'])->name("home");
Route::get('/carrinho',[WebsiteController::class, 'carrinho'])->name("carrinho");
Route::get('/admin/login',[WebsiteController::class,'admin_login'])->name('login.admin');

Route::get('/home',[WebsiteController::class,'home'])->name('home.admin');


Route::post('/logar',[WebsiteController::class,'fazer_login'])->name('fazer_login');
