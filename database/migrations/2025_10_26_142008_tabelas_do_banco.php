<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        /**
         * ENDEREÇOS
         */
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->string('rua');
            $table->string('bairro');
            $table->string('numero', 20);
            $table->string('complemento')->nullable();
            $table->string('cidade');
            $table->string('cep', 15);
            $table->string('uf', 2);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * CATEGORIA
         */
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('descricao')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sub_categorias', function (Blueprint $table) {
            $table->id();
            $table->string('descricao')->unique();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * PRODUTOS
         */
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('tamanho')->nullable();
            $table->string('modelo')->nullable();
            $table->string('codigo')->unique();
            $table->decimal('preco', 10, 2);
            $table->integer('estoque')->default(0);
            $table->foreignId('sub_categoria_id')->constrained('sub_categorias')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * CARRINHOS
         */
        Schema::create('carrinhos', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * CARRINHO_PRODUTOS (tabela pivô)
         */
        Schema::create('carrinho_produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrinho_id')->constrained('carrinhos')->onDelete('cascade');
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->integer('quantidade')->default(1);
            $table->decimal('preco_unitario', 10, 2);
            $table->timestamps();
        });

        /**
         * FALE CONOSCO
         */
        Schema::create('fale_conosco', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('mensagem');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('respondido')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * VENDAS
         */
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrinho_id')->constrained('carrinhos')->onDelete('cascade');
            $table->decimal('total', 10, 2);
            $table->decimal('desconto', 10, 2)->nullable();
            $table->enum('status', ['pendente', 'pago', 'cancelado'])->default('pendente');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * FORMA PAGAMENTO
         */
        Schema::create('forma_pagamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venda_id')->constrained('vendas')->onDelete('cascade');
            $table->decimal('total', 10, 2);
            $table->string('formapgto');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forma_pagamento');
        Schema::dropIfExists('vendas');
        Schema::dropIfExists('fale_conosco');
        Schema::dropIfExists('carrinho_produtos');
        Schema::dropIfExists('carrinhos');
        Schema::dropIfExists('produtos');
        Schema::dropIfExists('enderecos');
        Schema::dropIfExists('usuarios');
    }
};
