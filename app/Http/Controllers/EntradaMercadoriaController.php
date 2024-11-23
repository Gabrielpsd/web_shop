<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EntradaMercadoriaController extends Controller
{
    public function index(){
        $sql = <<< sql
            select
                entrada_mercadorias.id,
                entrada_mercadorias.id_fornecedor,
                fornecedor.descricao as fornecedor,
                entrada_mercadorias.data_compra, 
                (select COALESCE(sum(entrada_produtos.quantidade * entrada_produtos.preco),0) from entrada_produtos where entrada_produtos.id_entrada = entrada_mercadorias.id) as valor_total
            from entrada_mercadorias
            join cliente_fornecedor fornecedor on 
                entrada_mercadorias.id_fornecedor = fornecedor.id
        sql;

        $entradas = DB::select($sql);

        $sql = <<< FORNECEDORES
            select 
                * 
            from 
                cliente_fornecedor
            where 
                fornecedor = true
        FORNECEDORES;
        
        $fornecedores = DB::select($sql);
        
        $sql = <<< PRODUTOS
        select * from produtos
        PRODUTOS;
        
        $produtos = DB::select($sql);

        return Inertia::render('EntradaMercadoria/list',
                ['Entradas' => $entradas,
                'Fornecedores' => $fornecedores,
                'Produtos'=>$produtos]
        );
    
    }

    public function criarPedido(Request $request)
    {   
        $data = $request->all();
        $response = DB::table('entrada_mercadorias')->insertGetId(
            ['id_fornecedor' => $data['id_fornecedor'], 
            'data_compra'=>$data['data_compra']]
        );

        return response()->json($response);
    }

    public function detalheEntrada(string $id)
    {
        $sql = <<<SQL
             select
                entrada_mercadorias.id,
                entrada_mercadorias.id_fornecedor,
                fornecedor.descricao as fornecedor
            from entrada_mercadorias
            join cliente_fornecedor fornecedor on 
                entrada_mercadorias.id_fornecedor = fornecedor.id
            where 
                entrada_mercadorias.id = ?
        SQL;

        $entrada = DB::select($sql,[$id]);

        $sql = <<<SQL
            select 
                entrada_produtos.id,
                produtos.descricao,
                entrada_produtos.id_produto,
                entrada_produtos.quantidade,
                entrada_produtos.preco, 
                produtos.descricao
            from 
                entrada_produtos 
            join produtos on 
                produtos.id = entrada_produtos.id_produto
            where 
            entrada_produtos.id_entrada = ?
        SQL;

        $Produtos = DB::select($sql,[$id]);

        $produtosCadastrados = Produto::all();

        return Inertia::render('EntradaMercadoria/edit',
        [
            'Entrada'=>$entrada,
            'ProdutosBD'=>$Produtos,
            'ProdutosCadastrados'=> $produtosCadastrados
        ]);
    }
    public function inserirProdutos(Request $request , string $id)
    {
        $sql = <<< SQL
            insert into 
                entrada_produtos (id_produto,id_entrada,quantidade,preco) 
            values 
                (?,$id,?,?);    
        SQL;

        foreach($request->request as $entrada)
        {
            DB::select($sql,[$entrada['id'],$entrada['quantidade'],$entrada['preco']]);
        }

        return response()->json('Sucesso nas inserções');
    }

    public function editarProdutoPedido(Request $request , string $id)
    {
        $sql = <<< SQL
            update 
                entrada_produtos 
            set
                quantidade = ? ,
                preco = ?
            where 
                id = ? and id_entrada = ?
        SQL;

        foreach($request->request as $entrada)
        {
            if(isset($entrada['id']))
                DB::update($sql,[$entrada['quantidade'],$entrada['preco'],$entrada['id'],$id]);
        }

        return response()->json('Sucesso nas alterações');
    }

    public function removerProdutosPedido(Request $request , string $id)
    {
        $sql = <<< SQL
            delete from 
                entrada_produtos 
            where 
                id = ? and id_entrada = ?
        SQL;
	
        foreach($request->request as $entrada)
        {
            if(isset($entrada['id']))
                DB::update($sql,[$entrada['id'],$id]);
        }

        return response()->json('Sucesso nas remoções');
    }

    public function uploadFile(Request $request)
    {
        $destination = '..\public\files';
        /* dump($request);
        $file = $request->all()['file'];
        dump($file); */
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if($file->move($destination,$file))
            {
                $xmlString = file_get_contents(storage_path($destination).'\\'. $file->getClientOriginalName());
                $xmlObject = simplexml_load_string($xmlString);
                
                /*Dados fornecedor*/
                $nfe = $xmlObject->NFe;
                $infNfe = $nfe->infNFe;
                $emit = $infNfe->emit;
                
                $response['Fornecedor']['CPF_CNPJ'] = $emit->CNPJ;
                $response['Fornecedor']['descricao'] = $emit->xNome;
                
                $nfe = $xmlObject->NFe;
                $infNfe = $nfe->infNFe;

                $i = 0;
                while($infNfe->det[$i])
                {
                    $item = $infNfe->det[$i];
                    $item = $item->prod;
                    $i = $i + 1;
                    $response['produtos'][$i] = ['descricao' => $item->xProd,'preco'=>$item->vUnCom,'quantidade'=>$item->qCom];
                    /* $response['produtos'][$i]['descricao'] = $item->xProd;
                    $response['produtos'][$i]['preco'] = $item->vUnCom;
                    $response['produtos'][$i]['quantidade'] = $item->qCom; */
                }

                return response()->json($response);
            }
        }
            
    }

    public function deletarEntrada(int $id) {

        $sql = <<< SQL
            delete from 
                entrada_produtos 
            where 
                id_entrada = ?
        SQL;

        $response = DB::delete($sql,[$id]);

        $sql = <<< SQL
            delete from entrada_mercadorias 
            where entrada_mercadorias.id = ?
        SQL;

        $response = DB::delete($sql,[$id]);

        return response()->json($response);
    }
}
