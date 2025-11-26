<div class="container mx-auto p-4 max-w-7xl">

    <h1
        class="text-4xl font-extrabold mb-8 text-center text-gray-800 border-b-4 border-blue-500 pb-3 flex items-center justify-center gap-3">

        {{-- Ícone Shopping Bag (Flowbite) --}}
        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M5.5 8h13l-.8 11.2a2 2 0 01-2 1.8H8.3a2 2 0 01-2-1.8L5.5 8z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 8a4 4 0 00-8 0" />
        </svg>

        Seu Carrinho de Compras
    </h1>


    @if(!$carrinho || $carrinho->itens->isEmpty())

        {{-- Carrinho vazio --}}
        <div class="bg-white border-4 border-dashed border-gray-300 rounded-xl p-16 text-center shadow-lg">

            <p class="text-2xl font-semibold text-gray-700 mb-4">
                Seu carrinho está vazio
            </p>

            <a href="{{ route('produtos') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-lg font-bold shadow-md">
                Ver Produtos
            </a>
        </div>

    @else

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Lista de Itens --}}
            <div class="lg:w-3/4 space-y-6">

                @foreach($carrinho->itens as $produto)

                    @php
                        $precoOriginal = $produto->preco; // preço sem desconto
                        $precoAtual = $produto->pivot->preco_unitario;
                        $subtotal = $precoAtual * $produto->pivot->quantidade;
                    @endphp

                    <div
                        class="flex flex-col sm:flex-row items-center justify-between bg-white shadow-xl rounded-xl p-4 sm:p-6">

                        {{-- Imagem + Dados --}}
                        <div class="flex items-start w-full sm:w-2/5 mb-4 sm:mb-0">
                            <img src="{{ $produto->media->getDir() }}" class="w-24 h-24 object-cover rounded-lg shadow-md mr-4">

                            <div>
                                <h2 class="text-lg font-bold">{{ $produto->nome }}</h2>

                                <p class="text-sm text-gray-500">
                                    Tamanho:
                                    <span class="font-semibold text-gray-800">
                                        {{ $produto->pivot->tamanho->tamanho }}
                                    </span>
                                </p>


                                {{-- Se houver desconto, exibir preços --}}
                                @if($precoAtual < $precoOriginal)
                                    <p class="text-sm line-through text-gray-400">
                                        R$ {{ number_format($precoOriginal, 2, ',', '.') }}
                                    </p>
                                    <p class="text-sm font-semibold text-green-600">
                                        Economize:
                                        R$ {{ number_format($precoOriginal - $precoAtual, 2, ',', '.') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Quantidade --}}
                        <div class="flex items-center space-x-2">

                            {{-- - --}}
                            <button
                                wire:click="atualizarQuantidade({{ $produto->id }}, {{ $produto->pivot->tamanho_id }}, {{ $produto->pivot->quantidade - 1 }})"
                                class="p-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                </svg>
                            </button>

                            {{-- input --}}
                            <input type="number" min="1"
                                class="w-16 text-center border rounded-lg py-2 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                wire:change="atualizarQuantidade({{ $produto->id }}, {{ $produto->pivot->tamanho_id }}, $event.target.value)"
                                value="{{ $produto->pivot->quantidade }}">

                            {{-- + --}}
                            <button
                                wire:click="atualizarQuantidade({{ $produto->id }}, {{ $produto->pivot->tamanho_id }}, {{ $produto->pivot->quantidade + 1 }})"
                                class="p-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>

                        </div>

                        {{-- Subtotal --}}
                        <div class="text-right">
                            <p class="text-xl font-bold text-blue-600">
                                R$ {{ number_format($subtotal, 2, ',', '.') }}
                            </p>
                        </div>

                        {{-- Remover item --}}
                        <button wire:click="removerItem({{ $produto->id }}, {{ $produto->pivot->tamanho_id }})"
                            class="text-gray-400 hover:text-red-600 hover:scale-125 transition">

                            {{-- Trash Icon Flowbite --}}
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>

                        </button>

                    </div>

                @endforeach

            </div>

            {{-- Resumo --}}
            <div class="lg:w-1/4">

                <div class="bg-white p-6 rounded-xl shadow-xl">

                    <h2 class="text-2xl font-bold mb-4">Resumo</h2>

                    <p class="flex justify-between text-gray-700 mb-2">
                        <span>Itens:</span>
                        <span>{{ $carrinho->itens->sum('pivot.quantidade') }}</span>
                    </p>

                    <p class="flex justify-between text-gray-700 text-xl font-bold">
                        <span>Total:</span>
                        <span class="text-blue-600">R$ {{ number_format($total, 2, ',', '.') }}</span>
                    </p>

                    <button
                        class="mt-6 w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl text-lg font-bold shadow">
                        Finalizar Compra
                    </button>

                </div>

            </div>

        </div>

    @endif

</div>