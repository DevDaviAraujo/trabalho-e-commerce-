<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Carrinho;
use App\Models\Produto;
use Illuminate\Support\Str;

class CarrinhoCompra extends Component
{
    public $carrinho;
    public $total = 0;

    public function mount()
    {
        $this->carrinho = $this->getCarrinho();
        $this->calcularTotal();
    }

    private function getCarrinho()
    {
        // usuário logado
        if (auth()->check()) {
            return Carrinho::firstOrCreate(
                ['user_id' => auth()->id()],
                ['token' => Str::uuid()]
            );
        }

        // visitante
        $token = session('carrinho_token');

        if (!$token) {
            $token = Str::uuid();
            session(['carrinho_token' => $token]);
        }

        return Carrinho::firstOrCreate(['token' => $token]);
    }

    public function atualizarQuantidade($produtoId, $tamanhoId, $novaQuantidade)
    {
        if ($novaQuantidade < 1) return;

        $this->carrinho->itens()
            ->wherePivot('tamanho_id', $tamanhoId)
            ->updateExistingPivot($produtoId, [
                'quantidade' => $novaQuantidade
            ]);

        $this->refreshCarrinho();
    }

    public function removerItem($produtoId, $tamanhoId)
    {
        $this->carrinho->itens()
            ->wherePivot('tamanho_id', $tamanhoId)
            ->detach($produtoId);

        $this->refreshCarrinho();
    }

    private function refreshCarrinho()
    {
        $this->carrinho->refresh();
        $this->calcularTotal();
    }

    private function calcularTotal()
    {
        $this->total = $this->carrinho->itens->sum(function ($item) {
            return $item->pivot->quantidade * $item->pivot->preco_unitario;
        });
    }

    public function render()
    {
        return view('livewire.carrinho');
    }
}
