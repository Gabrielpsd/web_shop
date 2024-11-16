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
                select * from produtos
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

        $response = Produto::create(['descricao'=>$dados['descricao'],'preco'=>$dados['preco'],'id_fornecedor'=>$dados['id_fornecedor'],'id_marca'=>$dados['id_marca']]);

        return response()->json($response);
    }

    public function editarProduto(Request $request , string $id)
    {
        $pessoa = Produto::findOrFail($id);
        $pessoa->update($request->all());
    
        return response()->json($pessoa);
    }

    public function  todasMarcas(){
        $marcas  = Marca::all();

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
