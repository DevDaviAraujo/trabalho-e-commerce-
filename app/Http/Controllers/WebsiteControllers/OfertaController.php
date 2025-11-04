<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Oferta;
use App\Http\Controllers\WebsiteControllers\MediaController; // Certifique-se de importar

class OfertaController extends Controller
{
    public function cadastrar(Request $request)
    {
        $validated = $request->validate(
            [
                'id' => 'sometimes|exists:ofertas,id',
                'descricao' => 'required|string|max:255',
                'tipo_desconto' => 'required|in:porcentagem,unitario',
                'valor_desconto' => 'nullable|numeric|min:0',
                'produto_id' => 'required|array|min:1',
                'produto_id.*' => 'required|integer|exists:produtos,id',
                'produtos_id*' => 'required|array', // Espera um array de produtos
                'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,webm|max:20000', // 'nullable' para edições
            ]
        );

        $oferta = Oferta::findOrNew($request->id);

        $oferta->fill([
            'descricao' => ucfirst(trim($validated['descricao'])), // Bug 'desc' corrigido
            'tipo_desconto' => $validated['tipo_desconto'],
            'valor_desconto' => $validated['valor_desconto'],
        ]);

        DB::beginTransaction();

        try {

            $oferta->save();

            // Sincroniza a tabela pivô (MUITO IMPORTANTE)
            // O método sync() cuida de adicionar e remover os produtos 
            // da tabela 'oferta_produtos' automaticamente.

            // Passe o array '$validated['produto_id']' inteiro de uma vez
            $oferta->produtos()->sync($validated['produto_id']);


            if ($request->hasFile('media')) {

                app(MediaController::class)->save_file(
                    $request->file('media'),
                    $oferta->id,
                    Oferta::class,
                    'oferta',
                    $request->id ? true : false

                );
            }

            DB::commit();

            $mensagem = $request->id ? 'Alteração salva!' : $oferta->descricao . ' cadastrado com sucesso!';
            return redirect()->back()->with('success', $mensagem);

        } catch (Exception $e) {
            DB::rollBack();

            // Loga o erro completo para análise
            \Log::error('Erro ao cadastrar oferta: ' . $e->getMessage());

            // Mostra uma mensagem amigável para o usuário
            return redirect()->back()->with('error', 'Ops! Algo deu errado ao salvar. Tente novamente.');

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

        $oferta = Oferta::where('id', $request->id)->firstOrFail();

        DB::beginTransaction();

        try {

            if ($oferta->media) {
                $media = $oferta->media;
                $media->deleteDir();
                $media->delete();
            }

            $oferta->delete();

            DB::commit();

            return redirect()->route('ofertas')->with('success', 'oferta e mídias deletados com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Algo deu errado: ' . $e->getMessage());
        }
    }
}
