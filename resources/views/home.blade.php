@extends('index')

@section('conteudo')

    {{-- CAROUSEL DE OFERTAS --}}
    <div id="carouselOfertas" class="relative w-full" data-carousel="slide">
        <div class="relative h-56 overflow-hidden rounded-lg md:h-[400px]">
            @foreach ($ofertas as $key => $oferta)
                @if ($oferta->media)
                    <div class="hidden duration-700 ease-in-out {{ $key == 0 ? 'block' : '' }}" data-carousel-item>
                        <a href="{{ route('ofertas', ['id' => $oferta->id]) }}">
                            <img src="{{ $oferta->media->getDir()}}"
                                class="absolute block w-full h-full object-cover object-center" alt="{{ $oferta->descricao }}">
                        </a>
                    </div>
                @endif
            @endforeach
        </div>

        <button type="button"
            class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-black/30 group-hover:bg-black/50 group-focus:ring-2 group-focus:ring-white">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-black/30 group-hover:bg-black/50 group-focus:ring-2 group-focus:ring-white">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        </button>
    </div>

    {{-- Adicionado bg-gray-50 para destacar os cards brancos --}}
    <div class="bg-gray-50">
        <div class="container mx-auto px-4 py-12 md:py-16 space-y-14">
            @foreach ($ofertas as $oferta)
                <div>
                    {{-- Cabeçalho da oferta --}}
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-3xl font-bold text-gray-900">
                            {{ $oferta->descricao }}
                            @if ($oferta->getDesconto() != 'Não há')
                                <span class="text-green-600 text-xl font-medium ml-2">
                                    ({{ $oferta->getDesconto() }} de desconto)
                                </span>
                            @endif
                        </h2>
                        <a href="{{ route('ofertas', ['id' => $oferta->id]) }}"
                            class="text-blue-700 hover:text-blue-800 font-semibold transition-colors duration-200">
                            Ver todos
                        </a>
                    </div>

                    {{-- Produtos desta oferta --}}
                    @php
                        $produtos = $oferta->produtos->take(10);
                    @endphp

                    @if ($produtos->count() > 0)
                        <div
                            class="flex gap-5 overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent snap-x snap-mandatory">
                            @foreach ($produtos as $produto)
                                
                                {{-- CARD DO PRODUTO ATUALIZADO --}}
                                <div
                                    class="w-56 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 border border-gray-100 flex flex-col snap-start">

                                    {{-- Imagem responsiva e proporcional --}}
                                    <div class="relative aspect-[4/5] w-full overflow-hidden bg-gray-100 rounded-t-lg">
                                        <img src="{{ $produto->media->getDir()}}"
                                            alt="{{ $produto->nome }}"
                                            class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-300 hover:scale-105">
                                    </div>

                                    {{-- Infos do produto (com flex-grow para alinhar) --}}
                                    <div class="p-4 flex flex-col flex-grow">
                                        
                                        {{-- Wrapper para empurrar o preço e botão para baixo --}}
                                        <div class="flex-grow">
                                            <h3 class="text-base font-semibold text-gray-900 truncate" title="{{ $produto->nome }}">
                                                {{ $produto->nome }}
                                            </h3>
                                            <p class="text-sm text-gray-500 truncate mb-3">{{ $produto->modelo ?? '' }}</p>
                                        </div>

                                        {{-- Preço (com melhor legibilidade) --}}
                                        <div class="mt-2">
                                            <span class="text-green-600 font-bold text-lg block">
                                                R$ {{ number_format($produto->preco / 12, 2, ',', '.') }} x12
                                            </span>
                                            <span class="text-gray-600 text-sm">
                                                ou R$ {{ number_format($produto->preco, 2, ',', '.') }} à vista
                                            </span>
                                        </div>

                                        {{-- Botão de Ação (NOVO) --}}
                                        <div class="mt-4">
                                            <a href="#"
                                                class="block w-full text-center bg-blue-600 text-white font-medium py-2 px-3 rounded-lg text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                                                Adicionar ao Carrinho
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm italic">Nenhum produto nesta oferta.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

@endsection