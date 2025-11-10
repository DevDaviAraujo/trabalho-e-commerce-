@extends('index')

@section('conteudo')

    {{-- CAROUSEL DE OFERTAS --}}
    <div id="carouselOfertas" class="relative w-full" data-carousel="slide">
        <div class="relative h-56 overflow-hidden rounded-lg md:h-[400px]">
            @foreach ($ofertas as $key => $oferta)
                @if ($oferta->media)
                    <div class="hidden duration-700 ease-in-out {{ $key == 0 ? 'block' : '' }}" data-carousel-item>
                        <a href="{{ route('ofertas', ['id' => $oferta->id]) }}">
                            <img src="{{ $oferta->media->getDir() ?? 'https://placehold.co/1200x400/000000/FFFFFF?text=Oferta' }}"
                                class="absolute block w-full h-full object-cover object-center" alt="{{ $oferta->descricao }}">
                        </a>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Slider controls -->
        <button type="button"
            class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-black/30 group-hover:bg-black/50">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-black/30 group-hover:bg-black/50">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        </button>
    </div>

    <div class="container mx-auto px-4 py-10 space-y-12">
        @foreach ($ofertas as $oferta)
            <div>
                {{-- Cabeçalho da oferta --}}
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ $oferta->descricao }}
                        @if($oferta->getDesconto() != 'Não há')
                        <span class="text-green-600 text-lg font-medium ml-2">
                            ({{ $oferta->getDesconto() }} de desconto)
                        </span>
                        @endif
                    </h2>
                    <a href="{{ route('ofertas', ['id' => $oferta->id]) }}" class="text-blue-600 hover:underline font-medium">
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
                            <div
                                class="min-w-[220px] bg-white rounded-lg shadow-sm flex-shrink-0 hover:shadow-md transition duration-200 snap-start">

                                {{-- Imagem responsiva e proporcional --}}
                                <div class="relative aspect-[4/5] w-full overflow-hidden bg-gray-100">
                                    <img src="{{ $produto->media->getDir() ?? 'https://placehold.co/300x400/CCCCCC/FFFFFF?text=Produto' }}"
                                        alt="{{ $produto->nome }}"
                                        class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-300 hover:scale-105">
                                </div>

                                {{-- Infos do produto --}}
                                <div class="p-3 flex flex-col">
                                    <h3 class="text-base font-semibold text-gray-800 truncate">{{ $produto->nome }}</h3>
                                    <p class="text-sm text-gray-500 truncate">{{ $produto->modelo ?? '' }}</p>

                                    <div class="mt-2">
                                        <span class="text-green-600 font-bold text-lg block">
                                            R$ {{ number_format($produto->preco / 12, 2, ',', '.') }} x12
                                        </span>
                                        <span class="text-gray-400 text-xs">
                                           R$ {{ number_format($produto->preco, 2, ',', '.') }} 
                                        </span>
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

@endsection