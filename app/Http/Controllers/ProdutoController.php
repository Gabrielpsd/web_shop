<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use \App\Models\Produto;
use Illuminate\Database\QueryException;

class ProdutoController extends Controller
{
    public function index(){
        $sql = <<< TODOSPRODUTOS
            select 
                produtos.*,
                cliente_fornecedor.descricao as fornecedor,
                marcas.descricao as marca,
                (select 
                    coalesce((select SUM(entrada_produtos.quantidade) from entrada_produtos where entrada_produtos.id_produto = produtos.id),0)
                    - 
                    coalesce((select SUM(produtos_pedido.quantidade) from produtos_pedido where produtos_pedido.id_produto = produtos.id),0)
                ) as saldo_item
            from 
                produtos
            join cliente_fornecedor on
                cliente_fornecedor.id = produtos.id_fornecedor
            join marcas on 
                marcas.id = produtos.id_marca
        TODOSPRODUTOS;

        $produtos = DB::select($sql);

        $sql = <<< FORNECEDORES
                select * from cliente_fornecedor
                where fornecedor = true
        FORNECEDORES;

        $fornecedores = DB::select($sql);

        $sql = <<< MARCAS
                select * from marcas
        MARCAS;

        $marcas = DB::select($sql);

        return Inertia::render('Produtos/list',
        [
            'Produtos' => $produtos,
            'Fornecedores'=> $fornecedores,
            'Marcas' => $marcas
        ]   
        );
    }

    public function inserirProduto(Request $request){
        $dados = $request->all();

        $response = Produto::create(
            ['descricao'=>$dados['descricao'],
            'preco'=>$dados['preco'],
            'id_fornecedor'=>$dados['id_fornecedor'],
            'id_marca'=>$dados['id_marca'],
            'ativo'=>$dados['ativo']
        ]);

        return response()->json($response);
    }

    public function editarProduto(Request $request , string $id)
    {
        $pessoa = Produto::findOrFail($id);
        $pessoa->update($request->all());
    
        return response()->json($pessoa);
    }

    public function  todasMarcas(Request $request){
        $marcas  = Marca::all();

        if($request->query('JSON') == true)
        {   
            return response()->json($marcas);
        }

        return Inertia::render('Marcas/list',[
            'Marcas'=>$marcas
        ]);
    }

    public function  removerProduto(int $id){
        $sql = <<< SQL
            delete from produtos 
            where produtos.id = ?
        SQL;

        try{
            $response = DB::delete($sql,[$id]);
        }catch(QueryException $ex){
            $code = $ex->getCode(); 
            $message = $ex->getMessage();

            /* exclusão de registro referenciado em outra tabela ( Foreign key violation: ) */ 
            if($code == "23503")
            {
                return response()->json(['message' => $message],209);
            }

            /* outros erros que não foram tratados */
            return response()->json(['message' => $message,'code'=>$code],513);
        }

        return response()->json($response);
    }

    public function  inserirMarca(Request $request){
        $request = $request->all();
        $marcas  = Marca::create(['descricao'=>$request['descricao']]);

        return response()->json($marcas);
    }

    public function  removerMarca(int $id){
        $sql = <<< SQL
            delete from marcas 
            where marcas.id = ?
        SQL;

        try{
            $response = DB::delete($sql,[$id]);
        }catch(QueryException $ex){
            $code = $ex->getCode(); 
            $message = $ex->getMessage();

            /* exclusão de registro referenciado em outra tabela ( Foreign key violation: ) */ 
            if($code == "23503")
            {
                return response()->json(['message' => $message],209);
            }

            /* outros erros que não foram tratados */
            return response()->json(['message' => $message,'code'=>$code],513);
        }

        return response()->json($response);
    }

    public function editarMarca(Request $request , string $id)
    {
        $marca = Marca::findOrFail($id);
        $marca->update($request->all());
    
        return response()->json($marca);
    }
}
