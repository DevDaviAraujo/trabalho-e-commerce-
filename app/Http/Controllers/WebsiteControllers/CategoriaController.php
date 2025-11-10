<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Produto;
use App\Models\Categoria;
use App\Models\SubCategoria;
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();

        try {
            if ($request->id) {

                $categoria = Categoria::where('id', $request->id)->update([

                    'descricao' => ucfirst(trim($validated['desc']))

                ]);

                return redirect()->back()->with('success', 'Alteração salva!');

            } else {

                $categoria = Categoria::create([
                    'descricao' => ucfirst(trim($validated['desc'])),
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', $categoria->descricao . ' cadastrado com sucesso!');

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

            $categoria = Categoria::find($request->id);
            $subcategorias = $categoria->subs;

            foreach ($subcategorias as $subcategoria) {

                Produto::where('sub_categoria_id', $subcategoria->id)->update([
                    'sub_categoria_id' => 1
                ]);

            }

            $categoria->delete();

            DB::commit();

            return redirect()->to(route('categorias'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Algo deu errado: ' . $e->getMessage());

        }
    }


}
