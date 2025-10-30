@extends('admin.index')

@section('conteudo')

    <div class="container my-5">

        <!-- Usamos um "card" para agrupar o formulário -->
        <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 900px;">

            <!-- Cabeçalho do Card -->
            <div class="card-header bg-white py-3 px-4 border-0 rounded-top-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0 text-dark">
                        <i class="bi bi-plus-circle me-2"></i>
                        Cadastrar Novo Produto
                    </h2>

                    <!-- Botão de Voltar (para a lista) -->
                    <a href="produtos.html" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>
                        Voltar para Lista
                    </a>
                </div>
            </div>

            <!-- Corpo do Card (onde o formulário fica) -->
            <div class="card-body p-4 p-md-5">

                <!-- O 'action' e 'method' você ajustará no Laravel -->
                <form action="#" method="POST">

                    <!-- (No Laravel, você adicionaria o @csrf aqui) -->

                    <div class="row g-3">

                        <!-- Coluna 1 -->
                        <div class="col-md-8">
                            <label for="nome" class="form-label">Nome do Produto</label>
                            <input type="text" class="form-control rounded-3" id="nome" name="nome" required>
                        </div>

                        <div class="col-md-4">
                            <label for="sub_categoria_id" class="form-label">Categoria</label>
                            <select class="form-select rounded-3" id="sub_categoria_id" name="sub_categoria_id" required>
                               
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label for="sub_categoria_id" class="form-label">Sub-Categoria</label>
                            <select class="form-select rounded-3" id="sub_categoria_id" name="sub_categoria_id" required>
                                
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control rounded-3" id="descricao" name="descricao" rows="4"></textarea>
                        </div>

                        <!-- Coluna 2 -->
                        <div class="col-md-4">
                            <label for="codigo" class="form-label">Código (SKU)</label>
                            <input type="text" class="form-control rounded-3" id="codigo" name="codigo">
                        </div>

                        <div class="col-md-4">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control rounded-3" id="modelo" name="modelo">
                        </div>

                        <div class="col-md-4">
                            <label for="tamanho" class="form-label">Tamanho</label>
                            <input type="text" class="form-control rounded-3" id="tamanho" name="tamanho"
                                placeholder="Ex: P, M, 42...">
                        </div>

                        <!-- Coluna 3 -->
                        <div class="col-md-6">
                            <label for="preco" class="form-label">Preço (R$)</label>
                            <input type="number" class="form-control rounded-3" id="preco" name="preco" step="0.01" min="0"
                                placeholder="0,00">
                        </div>

                        <div class="col-md-6">
                            <label for="estoque" class="form-label">Estoque (Unidades)</label>
                            <input type="number" class="form-control rounded-3" id="estoque" name="estoque" step="1" min="0"
                                placeholder="0">
                        </div>

                    </div> <!-- fim .row -->

                    <!-- Botão de Salvar -->
                    <hr class="my-4">
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">
                            <i class="bi bi-check-circle me-1"></i>
                            Salvar Produto
                        </button>
                    </div>

                </form>

            </div> <!-- fim .card-body -->

        </div> <!-- fim .card -->
    </div>

@endsection