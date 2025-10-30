<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Categoria;
use App\Models\SubCategoria;

class SubCategoriaController extends Controller
{
    public function cadastrar(Request $request)
    {
        $validated = $request->validate(
            [
                'desc' => [
                    'required',
                    Rule::unique('sub_categorias', 'descricao')->ignore($request->id),
                ],
                
                'categoria_id' => 'required'
            ],
            [
                'desc.required' => 'A descrição é obrigatória.',
                'categoria_id.required' => 'A categoria é obrigatória.',
                'desc.unique' => 'Já existe esse cadastro!',
            ]
        );

        if ($request->id) {

            $subcategoria = SubCategoria::where('id', $request->id)->update([

                'descricao' => ucfirst(trim($validated['desc'])),
                'categoria_id' => $validated['categoria_id']

            ]);

            return redirect()->back()->with('success',  'Alteração salva!');

        } else {

            $subcategoria = SubCategoria::create([
                'descricao' => ucfirst(trim($validated['desc'])),
                'categoria_id' => $validated['categoria_id']
            ]);
        }
        return redirect()->back()->with('success', $subcategoria->descricao . ' cadastrado com sucesso!');
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

        SubCategoria::where('id',$request->id)->delete();

        return redirect()->to(route('subcategorias'));

    }


}
