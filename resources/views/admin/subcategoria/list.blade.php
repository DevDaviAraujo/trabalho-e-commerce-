@extends('admin.index')

@section('conteudo')

    <div class="container my-5">

        <!-- Usamos um "card" para agrupar o conteúdo da tabela -->
        <div class="card shadow-sm border-0 rounded-4">

            <!-- Cabeçalho do Card -->
            <div class="card-header bg-white py-3 px-4 border-0 rounded-top-4">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Título -->
                    <h2 class="h5 mb-0 text-dark">
                        <i class="bi bi-diagram-3 me-1"></i>
                        Sub-Categorias Cadastradas
                    </h2>

                    <!-- Botão de Adicionar Novo -->
                    <a href="{{ Route('subcategoria_cadastro') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                        <i class="bi bi-plus-lg me-1"></i>
                        Adicionar Sub-Categoria
                    </a>
                </div>
            </div>

            <!-- Corpo do Card (onde a tabela fica) -->
            <div class="card-body p-0">

                <!-- Wrapper responsivo para a tabela -->
                <div class="table-responsive">

                    <table class="table table-striped table-hover mb-0 align-middle">

                        <!-- Cabeçalho da Tabela -->
                        <thead class="table-light">
                            <tr>
                                <!-- Baseado nos campos 'id', 'codigo', 'nome', 'preco', 'estoque', 'created_at' -->
                                <th scope="col" class="px-4 py-3">ID</th>
                                <th scope="col" class="py-3">Descrição</th>
                                <th scope="col" class="py-3">Pertence</th>
                                <th scope="col" class="py-3">Data Cadastro</th>
                                <th scope="col" class="py-3">Última Alteração</th>
                                <th scope="col" class="text-end px-4 py-3">Ações</th>
                            </tr>
                        </thead>

                        <!-- Corpo da Tabela (com dados de exemplo) -->
                        <tbody>
                            @foreach($subcategorias as $subcategoria)
                                <tr>
                                    <td>
                                        {{ $subcategoria->id }}
                                    </td>
                                    <td>
                                        {{ $subcategoria->descricao }}
                                    </td>
                                    <td>
                                        {{ $subcategoria->categoria->descricao }}
                                    </td>
                                    <td>
                                        {{ $subcategoria->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        {{ $subcategoria->updated_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="text-end px-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            
                                             <a href="{{ route('subcategoria_edicao', ['id' => $subcategoria->id]) }}"
                                                class="btn btn-warning rounded-circle d-inline-flex align-items-center justify-content-center"
                                                style="width: 38px; height: 38px;" title="Editar">
                                                <i class="bi bi-pencil-square text-white"></i>
                                            </a>

                                            <a href="{{ route('subcategoria_deletar', ['id' => $subcategoria->id]) }}"
                                                class="btn btn-danger rounded-circle d-inline-flex align-items-center justify-content-center"
                                                style="width: 38px; height: 38px;" title="Excluir">
                                                <i class="bi bi-trash text-white"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- fim .table-responsive -->

            </div> <!-- fim .card-body -->


            <div class="card-footer bg-white py-3 px-4 border-0 rounded-bottom-4">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted small">
                        Exibindo {{ $subcategorias->count() }} de {{ $subcategorias->total() }} subcategorias
                    </span>
                    {{ $subcategorias->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div> <!-- fim .card -->
    </div> <!-- fim .container -->

@endsection