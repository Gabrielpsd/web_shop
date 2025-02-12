<?php

use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\EntradaMercadoriaController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::get('/',  [AuthController::class, 'loginPage']);
Route::get('/login',  [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/user', [AuthController::class, 'user']); 
Route::post('/register', [AuthController::class, 'register']);


Route::middleware(['auth'])->group(function () {
/* Dashboard Area */
Route::get('/api/dashboard/vendasporsexo', [DashBoardController::class,'vendasPorSexo']);
Route::get('/api/dashboard/pessoasPorIdade', [DashBoardController::class,'pessoasPorIdade']);
Route::get('/api/dashboard/vendasPorIdade', [DashBoardController::class,'vendasPorIdade']);
Route::get('/api/dashboard/produtospormarca', [DashBoardController::class,'produtosPorMarca']);

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
Route::get('/pedidos/detalhe/{id}', [PedidosController::class,'editarPedido']);
Route::delete('/api/pedidos/excluir/{id}', [PedidosController::class,'excluirPedido']);
Route::post('/api/pedidos/inserirProdutos/{id}',[PedidosController::class,'inserirProdutos']);
Route::post('/api/pedidos/editarProdutoPedido/{id}',[PedidosController::class,'editarProdutoPedido']);
Route::post('/api/pedidos/removerProdutosPedido/{id}',[PedidosController::class,'removerProdutosPedido']);
/* Route::post('/api/pedidos/editar/{id}', [PedidosController::class,'editarProduto']); */

/* Entrada de mercadoria */ 
Route::get('/entradas', [EntradaMercadoriaController::class,'index']);
Route::post('/api/entradas/criarpedido', [EntradaMercadoriaController::class,'criarPedido']);
Route::delete('/api/entradas/excluir/{id}', [EntradaMercadoriaController::class,'deletarEntrada']);
Route::get('/entradas/detalhe/{id}', [EntradaMercadoriaController::class,'detalheEntrada']);
Route::post('/api/entradas/inserirProdutos/{id}',[EntradaMercadoriaController::class,'inserirProdutos']);
Route::post('/api/entradas/editarProdutos/{id}',[EntradaMercadoriaController::class,'editarProdutoPedido']);
Route::post('/api/entradas/removerProdutos/{id}',[EntradaMercadoriaController::class,'removerProdutosPedido']);

/* Upload a file */ 
Route::post('/api/upload', [EntradaMercadoriaController::class,'uploadFile']);

});