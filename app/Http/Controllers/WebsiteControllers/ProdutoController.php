<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\WebsiteControllers\MediaController;

use App\Models\Produto;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
class ProdutoController extends Controller
{
    public function cadastrar(Request $request)
    {
        $rules = [
            'sub_categoria_id' => 'required',
            'nome' => [
                'required',
                Rule::unique('produtos', 'nome')->ignore($request->id, 'id'),
            ],
            'descricao' => 'required',
            'tamanho' => 'required',
            'modelo' => 'required',
            'codigo' => 'required',
            'preco' => 'required|numeric|min:0',
            'estoque' => 'required|numeric|min:0',
        ];

        if (!$request->id) {
            $rules['imagens'] = 'required|array';
        } else {
            $rules['imagens'] = 'nullable|array';
        }

        $rules['imagens.*'] = 'file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,webm|max:20000';

        $messages = [
            'sub_categoria_id.required' => 'A subcategoria é obrigatória.',
            'imagens.required' => 'Envie pelo menos uma imagem.',
            'imagens.*.mimes' => 'Os arquivos devem ser imagens ou vídeos válidos.',
            'imagens.*.max' => 'Cada arquivo deve ter no máximo 20MB.',
            'nome.required' => 'O nome do produto é obrigatório.',
            'nome.unique' => 'Já existe um produto com esse nome.',
            'descricao.required' => 'A descrição é obrigatória.',
            'tamanho.required' => 'O tamanho é obrigatório.',
            'modelo.required' => 'O modelo é obrigatório.',
            'codigo.required' => 'O código é obrigatório.',
            'preco.required' => 'O preço é obrigatório.',
            'preco.numeric' => 'O preço deve ser numérico.',
            'preco.min' => 'O preço não pode ser negativo.',
            'estoque.required' => 'O estoque é obrigatório.',
            'estoque.numeric' => 'O estoque deve ser numérico.',
            'estoque.min' => 'O estoque não pode ser negativo.',
        ];

        $validated = $request->validate($rules, $messages);

        DB::beginTransaction();

        try {
            
            if ($request->id) {
                $produto = Produto::findOrFail($request->id);
                $produto->update($validated);
                $message = 'Alteração salva!';
            } else {
                $produto = Produto::create($validated);
                $message = $produto->nome . ' cadastrado com sucesso!';
            }

            if ($request->hasFile('imagens')) {
                foreach ($request->file('imagens') as $imagem) {
                    app(MediaController::class)->save_file(
                        $imagem,
                        $produto->id,
                        Produto::class,
                        'produto'
                    );
                }
            }

            DB::commit();

            return redirect()->back()->with('success', $message);

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
                'inputCodigo.required' => 'O código é obrigatório.',
                'inputCodigo.same' => 'Código inválido!',
            ]
        );

        $produto = Produto::where('id', $request->id)->firstOrFail();

        DB::beginTransaction();

        try {

            foreach ($produto->medias as $media) {
                $media->deleteDir();
                $media->delete();
            }

            $produto->delete();

            DB::commit();

            return redirect()->route('produtos')->with('success', 'Produto e mídias deletados com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Algo deu errado: ' . $e->getMessage());
        }
    }

}
