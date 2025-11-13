<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Categoria;
use App\Models\SubCategoria;
use App\Models\Produto;
use App\Models\User;
use App\Models\Oferta;
use Illuminate\Support\Str;


class WebsiteController extends Controller
{
    public function perfil($id) {

        $user = User::find($id);

        return view('perfil',compact('user'));

    }

    public function login() {

        return view('login');

    }

    public function cadastro() {

        return view('cadastro');

    }
     public function home()
    {
        $ofertas = Oferta::all();
        $produtos = Produto::all();

        return view('home', [
            'ofertas' => $ofertas,
            'produtos' => $produtos,
        ]);
    }   
    
    public function faleConosco()
    {

        return view('faleConosco');
    }

    public function carrinho()
    {

        return view('carrinho');
    }

}
