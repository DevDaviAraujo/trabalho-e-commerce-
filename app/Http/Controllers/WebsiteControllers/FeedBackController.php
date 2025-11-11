<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\FaleConosco;
use Illuminate\Support\Facades\DB;

class FeedBackController extends Controller
{
    public function cadastrar(Request $request)
    {
        $validate = $request->validate([

            'nome' => 'required|max:55',
            'email' => 'required|email|max:55',
            'assunto' => 'required|max:55',
            'mensagem' => 'required|max:255',

        ], [

            'required' => 'Preencha o campo!',
            'email' => 'endereço de e-mail inválido!',
            'max' => 'ultrapassou o limite de caracteres!',

        ]);

        
        DB::beginTransaction();

        try {

            FaleConosco::create([

                'nome' => $validate['nome'],
                'email' => $validate['email'],
                'assunto' => $validate['assunto'],
                'mensagem' => $validate['mensagem'],


            ]);

            DB::commit();
            return redirect()->back()->with(['success' => 'Seu FeedBack foi enviado!']);

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Algo deu errado: ' . $e]);

        }
    }

    public function limpar() {

         DB::beginTransaction();
        try {
           
            FaleConosco::query()->delete();

            DB::commit();
            return redirect()->back()->with(['success' => 'feedback deletado!']);

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Algo deu errado: ' . $e]);
        }
    }

    public function deletar(Request $request) {

        DB::beginTransaction();
        try {
            $feedback = FaleConosco::where('id',$request->id)->first();
            $feedback->delete();

            DB::commit();
            return redirect()->back()->with(['success' => 'feedback deletado!']);

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Algo deu errado: ' . $e]);
        }

    }
}
