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
    public function salvar(array $data, array $tamanhos, ?int $id = null)
    {
        DB::beginTransaction();

        try {

            if ($id) {
                $produto = Produto::findOrFail($id);
                $produto->update($data);
            } else {
                $produto = Produto::create($data);
            }

            // 1️⃣ Remove tamanhos antigos
            DB::table('tamanhos')->where('produto_id', $produto->id)->delete();

            // 2️⃣ Recria tamanhos
            foreach ($tamanhos as $tamanho) {
                DB::table('tamanhos')->insert([
                    'produto_id' => $produto->id,
                    'tamanho' => $tamanho,
                ]);
            }

            DB::commit();

            return [
                'status' => 'success',
                'id' => $produto->id,
            ];

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
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

            foreach ($produto->tamanhos as $tamanho) {
                $tamanho->delete();
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
