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
                        Meus Produtos
                    </h2>
                    
                    <!-- Botão de Adicionar Novo -->
                    <a href="{{ Route('produto_cadastro') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                        <i class="bi bi-plus-lg me-1"></i>
                        Adicionar Produto
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
                                <th scope="col" class="py-3">Código</th>
                                <th scope="col" class="py-3">Nome</th>
                                <th scope="col" class="py-3">Preço</th>
                                <th scope="col" class="py-3">Estoque</th>
                                <th scope="col" class="py-3">Data Cadastro</th>
                                <th scope="col" class="text-end px-4 py-3">Ações</th>
                            </tr>
                        </thead>
                        
                        <!-- Corpo da Tabela (com dados de exemplo) -->
                        <tbody>
                            <!-- Exemplo de Linha 3 (Estoque baixo) -->
                            <tr>
                                <td class="px-4 fw-bold">3</td>
                                <td>SKU-003</td>
                                <td>Tênis de Corrida</td>
                                <td>R$ 299,00</td>
                                <td>
                                    <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">10</span>
                                </td>
                                <td>27/10/2025</td>
                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="#" class="btn btn-info btn-sm rounded-circle" style="width: 38px; height: 38px;" title="Editar">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="#" class="btn btn-warning btn-sm rounded-circle" style="width: 38px; height: 38px;" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm rounded-circle" style="width: 38px; height: 38px;" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div> <!-- fim .table-responsive -->
                
            </div> <!-- fim .card-body -->

            <!-- Rodapé do Card (para paginação, se necessário) -->
            <div class="card-footer bg-white py-3 px-4 border-0 rounded-bottom-4">
                <nav aria-label="Paginação">
                    <!-- (Aqui você pode adicionar a paginação do Laravel) -->
                    <span class_="text-muted small">Exibindo 3 de 3 produtos</span>
                </nav>
            </div>
            
        </div> <!-- fim .card -->
    </div> <!-- fim .container -->

@endsection