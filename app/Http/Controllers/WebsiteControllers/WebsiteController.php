<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function home() {

        return view('home');
    }

     public function carrinho() {

        return view('carrinho');
    }
}
