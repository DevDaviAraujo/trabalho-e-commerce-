<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Produto;
use Illuminate\Validation\Rule;
class ProdutoController extends Controller
{


    public function cadastrar(Request $request)
    {
        $validated = $request->validate(
            [
                'sub_categoria_id' => 'required',
                'nome' => [
                    'required',
                    Rule::unique('produtos', 'nome')->ignore($request->id),
                ],
                'descricao' => 'required',
                'tamanho' => 'required',
                'modelo' => 'required',
                'codigo' => 'required',
                'preco' => 'required|numeric|min:0',
            ],
            [
                'sub_categoria_id.required' => 'A produto é obrigatória.',
                'nome.required' => 'O nome do produto é obrigatório.',
                'nome.unique' => 'Já existe um produto com esse nome.',
                'descricao.required' => 'A descrição é obrigatória.',
                'tamanho.required' => 'O tamanho é obrigatório.',
                'modelo.required' => 'O modelo é obrigatório.',
                'codigo.required' => 'O código é obrigatório.',
                'preco.required' => 'O preço é obrigatório.',
                'preco.numeric' => 'O preço deve ser numérico.',
                'preco.min' => 'O preço não pode ser negativo.',
            ]
        );

        $data = [
            'sub_categoria_id' => $validated['sub_categoria_id'],
            'nome' => $validated['nome'],
            'descricao' => $validated['descricao'],
            'tamanho' => $validated['tamanho'],
            'modelo' => $validated['modelo'],
            'codigo' => $validated['codigo'],
            'preco' => $validated['preco'],
            'estoque' => $validated['estoque'],
        ];

        if ($request->id) {
            Produto::where('id', $request->id)->update($data);
            return redirect()->back()->with('success', 'Alteração salva!');
        } else {
            $produto = Produto::create($data);
            return redirect()->back()->with('success', $produto->descricao . ' cadastrado com sucesso!');
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

        Produto::where('id', $request->id)->delete();

        return redirect()->to(route('produtos'));

    }
}
