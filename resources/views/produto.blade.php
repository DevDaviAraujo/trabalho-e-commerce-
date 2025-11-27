@extends('index')

@section('conteudo')

<div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

    {{-- Card principal --}}
    <div class="bg-white border rounded-xl shadow-2xl p-6 grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 ">

        {{-- CARROSSEL DE IMAGENS --}}
        <div id="default-carousel" class="relative w-full " data-carousel="slide">

            {{-- Slides --}}
            <div class="relative h-96 overflow-hidden rounded-xl">
                @foreach($produto->medias as $index => $media)
                <div class="duration-700 ease-in-out {{ $index === 0 ? 'block' : 'hidden' }}"
                    data-carousel-item>

                    <div class="relative w-full h-full flex items-center justify-center">
                        <img src="{{ $media->getDir() }}"
                            class="absolute w-full h-full object-cover object-center">
                    </div>

                </div>
                @endforeach


                @if($produto->medias->count() === 0)
                <div class="duration-700 ease-in-out block" data-carousel-item>
                    <img src="/img/sem-imagem.png" class="absolute block w-full h-full object-cover">
                </div>
                @endif
            </div>

            {{-- Indicadores (Pontos) --}}
            <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                @foreach($produto->medias as $index => $media)
                <button type="button" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white"
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"
                    data-carousel-slide-to="{{ $index }}"></button>
                @endforeach
                @if($produto->medias->count() === 0)
                <button type="button" class="w-3 h-3 rounded-full bg-white hover:bg-white" aria-current="true"
                    aria-label="Slide 1" data-carousel-slide-to="0"></button>
                @endif
            </div>

            {{-- Botão anterior --}}
            <button type="button"
                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/70 group-hover:bg-white shadow transition">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
            </button>

            {{-- Botão próximo --}}
            <button type="button"
                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/70 group-hover:bg-white shadow transition">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </button>
        </div>


        {{-- INFOS DO PRODUTO --}}
        <div class="flex flex-col">
            <h1 class="text-4xl font-extrabold mb-4 text-gray-900">{{ $produto->nome }}</h1>

            {{-- Categoria --}}
            <p class="text-sm text-gray-500 mb-4">
                Categoria: <span class="font-semibold text-blue-600">{{ $produto->categoria() }}</span>
            </p>

            {{-- PREÇO --}}
            <div class="my-6">
                @if($produto->ofertas()->first())
                <div class="flex items-end space-x-3">
                    <span class="text-4xl font-extrabold text-red-600">
                        R$ {{ number_format($produto->preco(), 2, ',', '.') }}
                    </span>

                    <span class="line-through text-gray-500 text-lg">
                        R$ {{ number_format($produto->preco, 2, ',', '.') }}
                    </span>

                    <span
                        class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-semibold tracking-wider shadow-md">
                        🔥 {{$produto->ofertas()->first()->descricao}}
                    </span>
                </div>
                @else
                <span class="text-4xl font-extrabold text-gray-800">
                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                </span>
                @endif
            </div>

            {{-- Descrição do Produto (com Prose se estiver disponível) --}}
            <div class="text-gray-700 mb-6 prose max-h-72 overflow-y-scroll">
                {!! $produto->descricao !!}
            </div>


            {{-- FORM ADICIONAR AO CARRINHO (agora englobando tudo) --}}
            <form action="{{ route('adicionar_carrinho') }}" method="POST" class="space-y-6 mt-auto">
                @csrf
                <input type="hidden" name="produto_id" value="{{ $produto->id }}">

                {{-- TAMANHOS --}}
                @if($produto->tamanhos->count() > 0)
                <div class="mb-6">
                    <label class="block font-semibold mb-3 text-gray-800">Selecione o Tamanho:</label>

                    <div class="flex flex-wrap gap-3">
                        @foreach($produto->tamanhos as $t)
                        <label class="cursor-pointer">
                            <input type="radio" name="tamanho_id" value="{{ $t->id }}" class="hidden peer" required>

                            <div class="
                                                                    px-4 py-2 
                                                                    border-2 border-gray-300 rounded-xl 
                                                                    text-gray-700 font-medium 
                                                                    transition duration-200 
                                                                    hover:border-blue-500 
                                                                    peer-checked:bg-blue-600 
                                                                    peer-checked:text-white 
                                                                    peer-checked:border-blue-600 
                                                                    shadow-sm
                                                                ">
                                <span>{{ $t->tamanho }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Quantidade --}}
                <div class="flex items-center space-x-4">
                    <label for="quantidade" class="font-semibold text-gray-800">Quantidade:</label>
                    <input type="number" name="quantidade" id="quantidade" min="1" value="1"
                        class="w-24 border border-gray-300 rounded-lg px-3 py-2 text-center focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl text-xl font-bold shadow-lg 
                                    transition duration-300 ease-in-out transform hover:scale-[1.01]">
                    Adicionar ao Carrinho
                </button>
            </form>

        </div>

    </div>
</div>

@endsection