@extends('index')

@section('conteudo')

    <!-- Container Principal -->
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">

        <!-- Card Principal do Perfil -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto">
            
            <!-- Header do Perfil -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 sm:p-8 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row items-center sm:space-x-6">
                    <!-- Placeholder da Foto de Perfil -->
                    <div class="flex-shrink-0 mb-4 sm:mb-0">
                        <span class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-orange-100 ring-4 ring-white">
                            <!-- Ícone de Usuário (Heroicon) -->
                            <svg class="h-16 w-16 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A1.875 1.875 0 0 1 18.375 22.5H5.625a1.875 1.875 0 0 1-1.125-2.382Z" />
                            </svg>
                        </span>
                    </div>
                    <!-- Nome e E-mail -->
                    <div class="text-center sm:text-left">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->nome }}</h1>
                        <p class="text-md text-gray-600">{{ $user->email }}</p>
                    </div>
                    <!-- Botão de Editar (Opcional) -->
                    <div class="mt-4 sm:mt-0 sm:ms-auto">
                         <a href="#" class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg focus:ring-4 focus:outline-none focus:ring-orange-300 transition duration-150 ease-in-out">
                            <!-- Ícone de Lápis -->
                            <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            Editar Perfil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Corpo do Perfil (Grid de 2 colunas) -->
            <div class="p-6 sm:p-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Coluna 1: Informações Pessoais -->
                <div class="lg:col-span-1 space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                        Informações Pessoais
                    </h2>
                    
                    <!-- Item: Documento -->
                    <div class="flex items-start space-x-3">
                        <svg class="flex-shrink-0 w-6 h-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Documento</span>
                            <p class="text-md text-gray-900">{{ $user->documento }}</p>
                        </div>
                    </div>

                    <!-- Item: Telefone -->
                    <div class="flex items-start space-x-3">
                        <svg class="flex-shrink-0 w-6 h-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.836-1.42-5.13-3.714-6.55-6.55l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 6.75Z" />
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Telefone</span>
                            <p class="text-md text-gray-900">{{ $user->telefone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Coluna 2: Endereços -->
                <div class="lg:col-span-2 space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                        Endereços Cadastrados
                    </h2>

                    <!-- Verifica se existem endereços -->
                    @forelse ($user->enderecos as $endereco)
                        <!-- Card de Endereço -->
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-md font-semibold text-orange-700">Endereço Principal</h3>
                                <!-- Você pode adicionar lógica para "Endereço de Cobrança", "Entrega", etc. -->
                            </div>
                            
                            <div class="space-y-1 text-md text-gray-800">
                                <p class="font-medium">{{ $endereco->rua }}, {{ $endereco->numero }} @if($endereco->complemento) - {{ $endereco->complemento }} @endif</p>
                                <p>{{ $endereco->bairro }}</p>
                                <p>{{ $endereco->cidade }} - {{ $endereco->uf }}</p>
                                <p class="text-sm text-gray-600">CEP: {{ $endereco->cep }}</p>
                            </div>
                        </div>
                    @empty
                        <!-- Mensagem para quando não há endereços -->
                        <div class="flex items-center p-4 text-sm text-gray-800 rounded-lg bg-gray-50" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">Nenhum endereço cadastrado.</span>
                            </div>
                        </div>
                    @endforelse
                    
                    <!-- Botão de Adicionar Endereço (Opcional) -->
                     <button type="button" class="w-full text-orange-700 hover:text-white border border-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition duration-150 ease-in-out">
                         Adicionar Novo Endereço
                    </button>
                </div>
                
            </div>
        </div>

    </div>

@endsection