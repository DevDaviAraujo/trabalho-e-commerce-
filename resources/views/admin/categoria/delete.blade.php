@extends('admin.index')

@section('conteudo')

    <div class="container my-5">

        <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 900px;">

            <div class="card-header bg-white py-3 px-4 border-0 rounded-top-4">
                <div class="d-flex justify-content-between align-items-center">
                    
                    <h2 class="h5 mb-0 text-dark">
                        <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                        Confirmar Exclusão de Subcategoria
                    </h2>

                    <a href="{{ route('categorias') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>
                        Cancelar
                    </a>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">

                <div class="alert alert-danger" role="alert">
                    <h5 class="alert-heading">Atenção!</h5>
                    <p>Você está prestes a excluir permanentemente o registro listado abaixo. Esta ação não pode ser desfeita.</p>
                </div>

                <div class="table-responsive rounded-3 border">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="px-4 py-3">ID</th>
                                <th scope="col" class="py-3">Descrição</th>
                                
                                <th scope="col" class="py-3">Data Cadastro</th>
                                <th scope="col" class="py-3">Última Alteração</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4">{{ $categoria->id }}</td>
                                <td>{{ $categoria->descricao }}</td>
                                
                                <td>{{ $categoria->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4">{{ $categoria->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> <div class="card-footer bg-white p-4 p-md-5 border-0 rounded-bottom-4">
                <form method="POST" action="{{ route('deletar_categoria') }}">
                    @csrf
                    
                    <input type="hidden" name="codigo" value="{{ $codigo }}">
                    <input type="hidden" name="id" value="{{ $categoria->id }}">

                    <div class="row g-3 justify-content-center">
                        <div class="col-auto">
                            <label for="inputCodigo" class="col-form-label fs-5">
                                Digite <strong class="text-danger mx-1">{{ $codigo }}</strong> para confirmar:
                            </label>
                        </div>
                        <div class="col-auto">
                            <input type="text" 
                                   name="inputCodigo" 
                                   id="inputCodigo"
                                   class="form-control form-control-lg rounded-3 @error('inputCodigo') is-invalid @enderror"
                                   style="width: 150px; text-align: center;" 
                                   placeholder="{{ $codigo }}" 
                                   autocomplete="off" 
                                   maxlength="5" 
                                   autofocus 
                                   required>
                        </div>
                        
                        @error('inputCodigo')
                            <div class="w-100 invalid-feedback d-block text-center mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="text-end">
                        <button type="submit" class="btn btn-danger btn-lg rounded-pill px-5">
                            <i class="bi bi-trash-fill me-2"></i>
                            Excluir
                        </button>
                    </div>
                </form>
            </div> </div> </div> @endsection