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
     public function home()
    {
        $ofertas = Oferta::all();
        $produtos = Produto::all();

        return view('home', [
            'ofertas' => $ofertas,
            'produtos' => $produtos,
        ]);
    }    public function carrinho()
    {

        return view('carrinho');
    }

}
