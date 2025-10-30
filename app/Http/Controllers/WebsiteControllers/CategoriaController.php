<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Categoria;
use App\Models\SubCategoria;

class CategoriaController extends Controller
{
    public function cadastrar(Request $request)
    {
        $validated = $request->validate(
            [
                'desc' => 'required|unique:categorias,descricao',
            ],
            [
                'desc.required' => 'A descrição é obrigatória.',
                'desc.unique' => 'Já existe esse cadastro!',
            ]
        );

        if ($request->id) {

            $categoria = Categoria::where('id', $request->id)->update([

                'descricao' => ucfirst(trim($validated['desc']))

            ]);

            return redirect()->back()->with('success',  'Alteração salva!');

        } else {

            $categoria = Categoria::create([
                'descricao' => ucfirst(trim($validated['desc'])),
            ]);
        }
        return redirect()->back()->with('success', $categoria->descricao . ' cadastrado com sucesso!');
    }

    public function deletar(Request $request) {

        $validated = $request->validate(
            [
                'inputCodigo' => 'required|same:codigo',
            ],
            [
                'inputCodigo.required' => 'A descrição é obrigatória.',
                'inputCodigo.same' => 'Código inválido!',
            ]
        );

        Categoria::where('id',$request->id)->delete();

        return redirect()->to(route('categorias'));

    }


}
