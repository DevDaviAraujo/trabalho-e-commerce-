<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebsiteController extends Controller
{
    public function adminHome()
    {
        return view('home');
    }

    public function carrinho()
    {

        return view('carrinho');
    }

    public function admin_login()
    {

        return view('admin.login');
    }

    public function fazer_login(Request $request)
{
    $credenciais = $request->only('email', 'password');

    if (Auth::attempt(['email' => $credenciais['email'], 'password' => $credenciais['password']])) {
        return response()->json(['success' => true, 'redirect' => route('admin_home')]);
    }

    if (Auth::attempt(['name' => $credenciais['email'], 'password' => $credenciais['password']])) {
        return response()->json(['success' => true, 'redirect' => route('admin_home')]);
    }

    return response()->json(['success' => false, 'message' => 'Credenciais inválidas.'], 401);
}

}
