<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


use App\Models\Produto;
use App\Models\Categoria;
use App\Models\SubCategoria;
use Illuminate\Support\Facades\DB;

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

        try {

            if ($request->id) {

                $subcategoria = SubCategoria::where('id', $request->id)->update([

                    'descricao' => ucfirst(trim($validated['desc'])),
                    'categoria_id' => $validated['categoria_id']

                ]);

                return redirect()->back()->with('success', 'Alteração salva!');

            } else {

                $subcategoria = SubCategoria::create([
                    'descricao' => ucfirst(trim($validated['desc'])),
                    'categoria_id' => $validated['categoria_id']
                ]);
            }
            return redirect()->back()->with('success', $subcategoria->descricao . ' cadastrado com sucesso!');

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
            $subcategoria = SubCategoria::find($request->id);

            Produto::where('sub_categoria_id', $subcategoria->id)->update([
                'sub_categoria_id' => 1
            ]);

            $subcategoria->delete();

            DB::commit();

            return redirect()->to(route('subcategorias'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Algo deu errado: ' . $e->getMessage());

        }

    }

    public function getByCategoria($categoria_id)
    {
        $subcategorias = SubCategoria::where('categoria_id', $categoria_id)->get();

        return response()->json($subcategorias);
    }


}
