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
use App\Models\Admin;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

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

    
    public function cadastrar(Request $request)
    {

        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('admins')->ignore($request->id),
                ],
                'documento' => [
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('admins')->ignore($request->id),
                ],
                'password' => $request->id
                    ? 'nullable|string|min:4|confirmed' // permite não alterar a senha ao editar
                    : 'required|string|min:4|confirmed',
            ],
            [
                'name.required' => 'O campo nome é obrigatório.',
                'email.required' => 'O campo e-mail é obrigatório.',
                'email.email' => 'Por favor, insira um e-mail válido.',
                'email.unique' => 'Este e-mail já está em uso.',
                'documento.unique' => 'Este documento já está em uso.',
                'password.required' => 'O campo senha é obrigatório.',
                'password.min' => 'A senha deve ter pelo menos 4 caracteres.',
                'password.confirmed' => 'A confirmação de senha não confere.',
            ]
        );

        DB::beginTransaction();

        try {

            if ($request->id) {

                $admin = Admin::where('id', $request->id)->update([

                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'documento' => $validated['documento'],
                    'password' => Hash::make($validated['password']),

                ]);

                DB::commit();
                return redirect()->back()->with('success', 'Alteração salva!');
                
            } else {

                $admin = Admin::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'documento' => $validated['documento'],
                    'password' => $validated['password'],

                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', $admin->name . ' cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Algo deu errado: ' . $e->getMessage());
        }
    }

    public function deletar(Request $request)
    {

        $validated = $request->validate(
            [
                'inputCodigo' => 'required|same:codigo',
            ],
            [
                'inputCodigo.required' => 'A descrição é obrigatória.',
                'inputCodigo.same' => 'Código inválido!',
            ]
        );

        DB::beginTransaction();

        try {

            Admin::where('id', $request->id)->delete();
            DB::commit();
            return redirect()->to(route('users'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Algo deu errado: ' . $e->getMessage());
        }
    }

    public function logar(Request $request)
    {
        $credenciais = $request->only('email', 'password');


        if (Auth::guard('admin')->attempt(['email' => $credenciais['email'], 'password' => $credenciais['password']])) {
            return redirect()->route('admin_home');
        }


        if (Auth::guard('admin')->attempt(['name' => $credenciais['email'], 'password' => $credenciais['password']])) {
            return redirect()->route('admin_home');
        }


        return redirect()->back()
            ->withErrors(['login' => 'Credenciais inválidas!'])
            ->withInput();
    }
    public function deslogar(Request $request)
    {
        Auth::guard('admin')->logout(); // Desloga o usuário autenticado
        $request->session()->invalidate(); // Invalida a sessão atual
        $request->session()->regenerateToken(); // Gera novo token CSRF

        return redirect()->route('login_admin')->with('success', 'Você saiu da sua conta.');
    }



}
