<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

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
    public function deslogar(Request $request)
    {
        Auth::logout(); // Desloga o usuário autenticado
        $request->session()->invalidate(); // Invalida a sessão atual
        $request->session()->regenerateToken(); // Gera novo token CSRF

        return redirect()->route('login')->with('success', 'Você saiu da sua conta.');
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
                    Rule::unique('users')->ignore($request->id),
                ],
                'documento' => [
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('users')->ignore($request->id),
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

                $user = User::where('id', $request->id)->update([

                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'documento' => $validated['documento'],
                    'password' => Hash::make($validated['password']),

                ]);

                DB::commit();
                return redirect()->back()->with('success', 'Alteração salva!');
                
            } else {

                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'documento' => $validated['documento'],
                    'password' => $validated['password'],

                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', $user->name . ' cadastrado com sucesso!');
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

            User::where('id', $request->id)->delete();
            DB::commit();
            return redirect()->to(route('users'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Algo deu errado: ' . $e->getMessage());
        }
    }
}
