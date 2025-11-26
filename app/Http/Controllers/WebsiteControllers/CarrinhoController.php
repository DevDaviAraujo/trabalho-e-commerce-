<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Carrinho;
use Illuminate\Support\Str;

class CarrinhoController extends Controller
{
    public function carrinho()
    {
        $token = session('carrinho_token');

        $carrinho = Carrinho::with(['itens'])
            ->where('token', $token)
            ->first();

        return view('carrinho', [
            'carrinho' => $carrinho
        ]);
    }

    public function adicionar(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'tamanho_id' => 'required|exists:tamanhos,id',
            'quantidade' => 'nullable|integer|min:1'
        ]);

        $produto = Produto::findOrFail($request->produto_id);

        // preço com desconto ou normal
        $preco = $produto->preco();

        // pegar ou criar token
        if (auth()->check()) {
            $carrinho = Carrinho::firstOrCreate(
                ['user_id' => auth()->id()],
                ['token' => Str::uuid()]
            );
        } else {
            $token = session('carrinho_token');

            if (!$token) {
                $token = Str::uuid()->toString();
                session(['carrinho_token' => $token]);
            }

            $carrinho = Carrinho::firstOrCreate(['token' => $token]);
        }

        // quantidade enviada ou 1
        $quantidade = $request->quantidade ?? 1;

        // verificar se o item já existe com mesmo tamanho
        $itemExistente = $carrinho->itens()
            ->wherePivot('tamanho_id', $request->tamanho_id)
            ->where('produto_id', $produto->id)
            ->first();

        if ($itemExistente) {
            // só aumenta a quantidade
            $carrinho->itens()->updateExistingPivot($produto->id, [
                'quantidade' => $itemExistente->pivot->quantidade + $quantidade
            ]);
        } else {
            // add item novo
            $carrinho->itens()->attach($produto->id, [
                'tamanho_id' => $request->tamanho_id,
                'quantidade' => $quantidade,
                'preco_unitario' => $preco,
            ]);
        }

        return back()->with('success', 'Produto adicionado ao carrinho!');
    }
}
