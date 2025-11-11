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
use App\Models\FaleConosco;
use Illuminate\Support\Str;


class AdminController extends Controller
{

    public function feedbacks() {

        $feedbacks = FaleConosco::paginate(10);

        return view('admin.feedback.list',compact('feedbacks'));

    }

    public function ofertas()
    {
        $ofertas = Oferta::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.oferta.list', compact('ofertas'));
    }

    public function ofertaVer($id)
    {
        return view(
            'admin.oferta.read',
            [
                'oferta' => Oferta::where('id', $id)->first()
            ]
        );
    }

    public function ofertaCadastro($id = null)
    {
        $oferta = $id ? Oferta::find($id) : null;

        return view('admin.oferta.create', [
            'oferta' => $oferta,
            'produtos' => Produto::all(),
        ]);
    }


    public function ofertaDeletar($id)
    {

        return view(
            'admin.oferta.delete',
            [
                'oferta' => Oferta::where('id', $id)->first(),
                'codigo' => Str::Random(5)
            ]
        );


    }


    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.user.list', compact('users'));
    }

    public function userCadastro($id = null)
    {
        $user = $id ? User::find($id) : null;

        return view('admin.user.create', [
            'user' => $user,
        ]);
    }


    public function userDeletar($id)
    {

        return view(
            'admin.user.delete',
            [
                'user' => User::where('id', $id)->first(),
                'codigo' => Str::Random(5)
            ]
        );


    }

    public function produtos()
    {
        $produtos = Produto::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.produto.list', compact('produtos'));
    }

    public function produtoVer($id)
    {
        return view(
            'admin.produto.read',
            [
                'produto' => Produto::where('id', $id)->first()
            ]
        );
    }

    public function produtoCadastro($id = null)
    {
        $produto = $id ? Produto::find($id) : null;

        return view('admin.produto.create', [
            'produto' => $produto,
            'categorias' => Categoria::all(),
        ]);
    }


    public function produtoDeletar($id)
    {

        return view(
            'admin.produto.delete',
            [
                'produto' => Produto::where('id', $id)->first(),
                'codigo' => Str::Random(5)
            ]
        );

    }

    public function subcategorias()
    {
        $subcategorias = SubCategoria::where('id','!=',1)->orderBy('created_at', 'desc')->paginate(10);

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
            [
                'subcategoria' => $subcategoria,
                'categorias' => Categoria::where('id','!=',1)->get()
            ]
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
        $categorias = Categoria::where('id','!=',1)->orderBy('created_at', 'desc')->paginate(10);

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
        return view('admin.home');
    }


    public function login()
    {

        return view('admin.login');
    }


}
