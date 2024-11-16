<?php

use App\Http\Controllers\DashBoard_controller;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Dashboard Area */
Route::get('/', [DashBoard_controller::class,'index']);

/* Produtos */ 
Route::get('/produtos', [ProdutoController::class,'index']);
Route::post('/api/produtos/editar/{id}', [ProdutoController::class,'editarProduto']);
Route::post('/api/produtos/inserir', [ProdutoController::class,'inserirProduto']);
Route::delete('/api/produtos/remover/{id}', [ProdutoController::class,'removerProduto']);

/* Marcas */ 
Route::get('/marcas', [ProdutoController::class, 'todasMarcas']);
Route::post('api/marcas/inserir', [ProdutoController::class, 'inserirMarca']);
Route::delete('api/marcas/remover/{id}', [ProdutoController::class, 'removerMarca']);
Route::post('api/marcas/editar/{id}', [ProdutoController::class, 'editarMarca']);

/* Clientes e fornecedores */ 
Route::get('/clientefornecedor', [PessoaController::class,'index']);
Route::post('/api/clientesfornecedores/editar/{id}', [PessoaController::class,'editarPessoa']);
Route::post('/api/clientesfornecedores/inserir', [PessoaController::class,'inserirPessoa']);
Route::delete('/api/clientesfornecedores/excluir/{id}', [PessoaController::class,'deletarClienteFornecedor']);


/* Pedidos */ 
Route::get('/pedidos', [PedidosController::class,'index']);
Route::post('/api/pedidos/criarpedido', [PedidosController::class,'inserirPedido']);
Route::post('/api/pedidos/editar/{id}', [PedidosController::class,'editarProduto']);

