<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Categoria;
use App\Models\SubCategoria; 
use Illuminate\Support\Str;


class WebsiteController extends Controller
{

    public function produtos()
    {
        $produtos = Categoria::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.produto.list', compact('produtos'));
    }


    public function produtoCadastro($id = false)
    {

        if ($id) {
            $produto = Categoria::where('id', $id)->first();
        } else {
            $produto = null;
        }
        return view(
            'admin.produto.create',
            ['produto' => $produto]
        );

    }

    public function produtoDeletar($id)
    {

        return view(
            'admin.produto.delete',
            [
                'produto' => Categoria::where('id', $id)->first(),
                'codigo' => Str::Random(5)
            ]
        );


    }

    public function subcategorias()
    {
        $subcategorias = SubCategoria::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.subcategoria.list', compact('subcategorias'));
    }


    public function subcategoriaCadastro($id = false)
    {


        if ($id) {
            $subcategoria = SubCategoria::where('id', $id)->first();
        } else {
            $subcategoria = null;
        }
        return view(
            'admin.subcategoria.create',
            ['subcategoria' => $subcategoria,
            'categorias' => Categoria::all()]
        );

    }

    public function subcategoriaDeletar($id)
    {

        return view(
            'admin.subcategoria.delete',
            [
                'subcategoria' => SubCategoria::where('id', $id)->first(),
                'codigo' => Str::Random(5)
            ]
        );


    }

    public function categorias()
    {
        $categorias = Categoria::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.categoria.list', compact('categorias'));
    }


    public function categoriaCadastro($id = false)
    {

        if ($id) {
            $categoria = Categoria::where('id', $id)->first();
        } else {
            $categoria = null;
        }
        return view(
            'admin.categoria.create',
            ['categoria' => $categoria]
        );

    }

    public function categoriaDeletar($id)
    {

        return view(
            'admin.categoria.delete',
            [
                'categoria' => Categoria::where('id', $id)->first(),
                'codigo' => Str::Random(5)
            ]
        );


    }

    public function home()
    {
        return view('home');
    }
    public function adminHome()
    {
        return view('admin.home');
    }

    public function carrinho()
    {

        return view('carrinho');
    }

    public function admin_login()
    {

        return view('admin.login');
    }

    public function logar(Request $request)
    {
        $credenciais = $request->only('email', 'password');


        if (Auth::attempt(['email' => $credenciais['email'], 'password' => $credenciais['password']])) {
            return redirect()->route('admin_home');
        }


        if (Auth::attempt(['name' => $credenciais['email'], 'password' => $credenciais['password']])) {
            return redirect()->route('admin_home');
        }


        return redirect()->back()
            ->withErrors(['login' => 'Credenciais inválidas!'])
            ->withInput();
    }


}
