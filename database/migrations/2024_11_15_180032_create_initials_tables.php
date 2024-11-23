<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cliente_fornecedor', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->integer('fornecedor');
            $table->char('sexo');
            $table->integer('idade');
            $table->string('cpf_cnpj',14);
            $table->timestamps();
        });

        Schema::create('marcas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->timestamps();
        });

        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->float('preco');
            $table->integer('id_fornecedor');
            $table->foreign('id_fornecedor')->references('id')->on('cliente_fornecedor');
            $table->integer('id_marca');
            $table->foreign('id_marca')->references('id')->on('marcas');
            $table->boolean('ativo');
            $table->timestamps();
        });

        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('cliente_fornecedor');
            $table->date('data_venda');
            $table->timestamps();
        });

        
        Schema::create('entrada_mercadorias', function (Blueprint $table) {
            $table->id();
            $table->integer('id_fornecedor');
            $table->foreign('id_fornecedor')->references('id')->on('cliente_fornecedor');
            $table->date('data_compra');
            $table->timestamps();
        });

        Schema::create('entrada_produtos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produto');
            $table->foreign('id_produto')->references('id')->on('produtos');
            $table->integer('id_entrada');
            $table->foreign('id_entrada')->references('id')->on('entrada_mercadorias');
            $table->integer('quantidade');
            $table->float('preco');
            $table->timestamps();
        });

        Schema::create('produtos_pedido', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pedido');
            $table->foreign('id_pedido')->references('id')->on('pedidos');
            $table->integer('id_produto');
            $table->foreign('id_produto')->references('id')->on('produtos');
            $table->integer('quantidade');
            $table->float('preco');
            $table->timestamps();
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marcas');
        Schema::dropIfExists('entrada_produtos');
        Schema::dropIfExists('produto_pedido');
        Schema::dropIfExists('pedido');
        Schema::dropIfExists('produtos');
        Schema::dropIfExists('cliente_fornecedor');
        Schema::dropIfExists('entrada_mercadorias');
    }
};
