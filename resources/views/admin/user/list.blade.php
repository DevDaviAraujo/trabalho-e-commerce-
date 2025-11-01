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
                    <i class="bi bi-box-seam me-2"></i>
                    Usuários Cadastrados
                </h2>

                <!-- Botão de Adicionar Novo -->
                <a href="{{ Route('user_cadastro') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                    <i class="bi bi-plus-lg me-1"></i>
                    Adicionar Usuário
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
                            <th scope="col" class="px-4 py-3">ID</th>
                            <th scope="col" class="py-3">Nome</th>
                            <th scope="col" class="py-3">E-mail</th>
                            <th scope="col" class="py-3">Documento</th>
                            <th scope="col" class="py-3">Data Cadastro</th>
                            <th scope="col" class="py-3">Última Alteração</th>
                            <th scope="col" class="text-end px-4 py-3">Ações</th>
                        </tr>
                    </thead>

                    <!-- Corpo da Tabela (com dados de exemplo) -->
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                {{ $user->id }}
                            </td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                {{ $user->documento }}
                            </td>
                            <td>
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                {{ $user->updated_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4">
                                <div class="d-flex justify-content-end gap-2">

                                    @if($user->id == Auth()->user()->id)
                                    <a href="{{ route('user_edicao', ['id' => $user->id]) }}"
                                        class="btn btn-warning rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width: 38px; height: 38px;" title="Editar">
                                        <i class="bi bi-pencil-square text-white"></i>
                                    </a>@endif

                                    @if($user->id != Auth()->user()->id)
                                    <a href="{{ route('user_deletar', ['id' => $user->id]) }}"
                                        class="btn btn-danger rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width: 38px; height: 38px;" title="Excluir">
                                        <i class="bi bi-trash text-white"></i>
                                    </a>
                                    @endif

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
                    Exibindo {{ $users->count() }} de {{ $users->total() }} users
                </span>
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div> <!-- fim .card -->
</div> <!-- fim .container -->

@endsection