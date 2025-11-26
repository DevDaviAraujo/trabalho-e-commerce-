@extends('index')

@section('conteudo')


    <div class="my-4 sm:px-3">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Produtos em {{ $sub->descricao }}</h2>

        {{-- GRUPO DE CARDS COM RESPONSIVIDADE E ESPAÇAMENTO --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">

            @forelse ($produtos as $produto)
                {{-- CARD DO PRODUTO --}}
                <div
                    class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 flex flex-col">

                    {{-- Imagem responsiva e proporcional --}}
                    <a href="" class="block">
                        <div class="relative aspect-[4/5] w-full overflow-hidden bg-gray-50 rounded-t-xl">
                            <img src="{{ $produto->media->getDir()}}" alt="{{ $produto->nome }}"
                                class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-500 hover:scale-110">
                        </div>
                    </a>

                    {{-- Infos do produto --}}
                    <div class="p-4 flex flex-col flex-grow">

                        <div class="flex-grow">
                            <a href="" class="hover:text-blue-600 transition-colors duration-200">
                                <h3 class="text-sm font-semibold text-gray-900 line-clamp-2" title="{{ $produto->nome }}">
                                    {{ $produto->nome }}
                                </h3>
                            </a>
                            <p class="text-xs text-gray-500 line-clamp-1 mb-3">{{ $produto->modelo ?? 'Modelo Indisponível' }}
                            </p>
                        </div>

                        {{-- Preço e Pagamento --}}
                        <div class="mt-2">
                            @php
                                $preco_parcelado = $produto->preco() / 12;
                            @endphp
                            <span class="text-green-600 font-extrabold text-lg block">
                                R$ {{ number_format($preco_parcelado, 2, ',', '.') }} x12
                            </span>
                            <span class="text-gray-600 text-sm block">
                                ou **R$ {{ number_format($produto->preco(), 2, ',', '.') }}** à vista
                            </span>
                        </div>

                        {{-- Botão de Ação (NOVO) --}}
                        <div class="mt-4">
                            <div type="button" role="button"
                                class="block w-full text-center bg-blue-600 text-white font-medium py-2 px-3 rounded-lg text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                                Adicionar ao Carrinho
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center col-span-full">Nenhum produto encontrado nesta sub-categoria.</p>
            @endforelse

        </div>

        {{-- PAGINAÇÃO LARAVEL --}}
        @if ($produtos->lastPage() > 1)
            <div class="mt-10">
                {{ $produtos->links() }}
            </div>
        @endif
    </div>

@endsection