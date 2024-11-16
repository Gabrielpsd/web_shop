<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PessoaController extends Controller
{
    public function index(){
        $sql = <<< TODOSPRODUTOS
                select * from cliente_fornecedor
        TODOSPRODUTOS;

        $response = DB::select($sql);
        return Inertia::render('ClienteFornecedor/list',
        [
            'ClienteFornecedor' => $response
        ]   
        );

    }

    public function inserirPessoa(Request $request)
    {
        $var = $request->all();
        $var = response()->json(Pessoa::create(['descricao'=> $var['descricao'],'fornecedor'=>$var['fornecedor']]));
        return $var;
    }

    public function deletarClienteFornecedor(int $id)
    {
        $sql = <<< SQL
            delete from cliente_fornecedor 
            where cliente_fornecedor.id = ?
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

    public function editarPessoa(Request $request , string $id)
    {
        $pessoa = Pessoa::findOrFail($id);
        $pessoa->update($request->all());
    
        return response()->json($pessoa);
    }
}
