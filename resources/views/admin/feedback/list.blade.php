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
                       <i class="bi bi-chat-square-quote"></i>
                        Visualizar FeedBacks
                    </h2>
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
                                <th scope="col" class="py-3">E-mail</th>
                                <th scope="col" class="py-3">Assunto</th>
                                <th scope="col" class="py-3">Mensagem</th>
                                <th scope="col" class="py-3">Data Cadastro</th>
                                <th scope="col" class="text-end px-4 py-3">Ações</th>
                            </tr>
                        </thead>

                        <!-- Corpo da Tabela (com dados de exemplo) -->
                        <tbody>
                            @foreach($feedbacks as $feedback)
                                <tr>
                                    <td>
                                        {{ $feedback->id }}
                                    </td>
                                    <td>
                                        {{ $feedback->email }}
                                    </td>
                                    <td>
                                        {{ $feedback->assunto }}
                                    </td>
                                    <td>
                                        {{ $feedback->mensagem }}
                                    </td>
                                    <td>
                                        {{ $feedback->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4">
                                        <div class="d-flex justify-content-end gap-2">

                                            <form action="{{ route('deletar_feedback') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $feedback->id }}">
                                                <button type="submit"
                                                    class="btn btn-danger rounded-circle d-inline-flex align-items-center justify-content-center"
                                                    style="width: 38px; height: 38px;" title="Excluir">
                                                    <i class="bi bi-trash text-white"></i>
                                                </button>
                                            </form>

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
                        Exibindo {{ $feedbacks->count() }} de {{ $feedbacks->total() }} feedbacks
                    </span>
                    {{ $feedbacks->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div> <!-- fim .card -->
    </div> <!-- fim .container -->

@endsection