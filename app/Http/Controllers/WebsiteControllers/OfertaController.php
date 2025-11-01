<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Oferta;

class OfertaController extends Controller
{
    public function cadastrar(Request $request)
    {
        $validated = $request->validate(
            [
                'categoria_id' => 'required'
            ],
            [
                'desc.required' => 'A descrição é obrigatória.',
                'categoria_id.required' => 'A categoria é obrigatória.',
                'desc.unique' => 'Já existe esse cadastro!',
            ]
        );

        if ($request->id) {

            $oferta = Oferta::where('id', $request->id)->update([

                'descricao' => ucfirst(trim($validated['desc'])),
                'categoria_id' => $validated['categoria_id']

            ]);

            return redirect()->back()->with('success', 'Alteração salva!');

        } else {

            $oferta = Oferta::create([
                'descricao' => ucfirst(trim($validated['desc'])),
                'categoria_id' => $validated['categoria_id']
            ]);
        }
        return redirect()->back()->with('success', $oferta->descricao . ' cadastrado com sucesso!');
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

        Oferta::where('id', $request->id)->delete();

        return redirect()->to(route('ofertas'));

    }
}
