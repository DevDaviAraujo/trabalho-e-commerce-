<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebsiteController extends Controller
{
    public function home() {

        return view('home');
    }

     public function carrinho() {

        return view('carrinho');
    }

    public function admin_login() {

        return view('admin.login');
    }

    public function fazer_login(Request $formulario) {
    
        $credenciais = $formulario->validate([

            'email' => ['required','email'],
            'senha' => ['required'],

        ]);

        if (Auth::attempt($credenciais)) {

            $formulario->session()->regenerate();
            return redirect()->intended('admin.home');

        }

        dd('dadsasdas');

        return redirect()->back()->withErrors('Usuário inválido!');

    }
}
