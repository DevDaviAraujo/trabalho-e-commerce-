<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteControllers\WebsiteController;

Route::get('/',[WebsiteController::class, 'home'])->name("home");
Route::get('/carrinho',[WebsiteController::class, 'carrinho'])->name("carrinho");
