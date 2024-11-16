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
            $table->timestamps();
        });

        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('cliente_fornecedor');
            $table->timestamps();
        });

        Schema::create('entrada_produtos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produto');
            $table->foreign('id_produto')->references('id')->on('produtos');
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
    }
};
