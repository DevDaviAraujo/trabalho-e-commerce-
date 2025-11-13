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
    public function cadastrar(Request $request)  {

        $validated = $request->validate([
           'documento' => 'required|string|max:11',
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'cep' => 'required|string|max:8', 
            'rua' => 'required|string|max:255',
            'numero' => 'required|numeric',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|size:2',
            'complemento' => 'required|string|max:255',
        ],[
            'documento.required' => 'O campo documento é obrigatório.',
            'documento.string'   => 'O documento deve conter apenas caracteres válidos.',
            'documento.max'      => 'O documento deve ter no máximo 11 caracteres.',

            'nome.required' => 'Por favor, informe o nome completo.',
            'nome.string'   => 'O nome deve conter apenas caracteres válidos.',
            'nome.max'      => 'O nome pode ter no máximo 255 caracteres.',

            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email'    => 'Por favor, informe um e-mail válido.',
            'email.max'      => 'O e-mail pode ter no máximo 255 caracteres.',

            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.string'   => 'O telefone deve conter apenas caracteres válidos.',
            'telefone.max'      => 'O telefone pode ter no máximo 20 caracteres.',

            'cep.required' => 'O CEP é obrigatório.',
            'cep.max'      => 'O CEP deve ter no máximo 8 dígitos.',

            'rua.required' => 'O nome da rua é obrigatório.',
            'rua.string'   => 'A rua deve conter apenas caracteres válidos.',
            'rua.max'      => 'O nome da rua pode ter no máximo 255 caracteres.',

            'numero.required' => 'O número do endereço é obrigatório.',
            'numero.numeric'  => 'O número do endereço deve conter apenas números.',

            'bairro.required' => 'O bairro é obrigatório.',
            'bairro.string'   => 'O bairro deve conter apenas caracteres válidos.',
            'bairro.max'      => 'O bairro pode ter no máximo 255 caracteres.',

            'cidade.required' => 'A cidade é obrigatória.',
            'cidade.string'   => 'A cidade deve conter apenas caracteres válidos.',
            'cidade.max'      => 'A cidade pode ter no máximo 255 caracteres.',

            'uf.required' => 'O estado (UF) é obrigatório.',
            'uf.string'   => 'A UF deve conter apenas letras.',
            'uf.size'     => 'A UF deve ter exatamente 2 caracteres (ex: SP, RJ).',

        ]);

        DB::beginTransaction();

        try {

            User::create([

                'documento' => $validated['documento'],
                'nome' => $validated['nome'],
                'email' => $validated['email'],
                'telefone' => $validated['telefone'],

            ]);

            Endereco::create([

                'rua' => $validated['rua'],
                'bairro' => $validated['bairro'],
                'numero' => $validated['numero'],
                'cidade' => $validated['cidade'],
                'uf' => $validated['uf'],
                'cep' => $validated['cep'],
                'complemento' => $validated['complemento'],

            ]);

            DB::commit();
            return redirect()->to(route('login'));

        } catch (Ecxeption $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Algo deu errado: ' . $e->getMessage());

        }



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
    public function deslogar(Request $request)
    {
        Auth::logout(); // Desloga o usuário autenticado
        $request->session()->invalidate(); // Invalida a sessão atual
        $request->session()->regenerateToken(); // Gera novo token CSRF

        return redirect()->route('login')->with('success', 'Você saiu da sua conta.');
    }

}
