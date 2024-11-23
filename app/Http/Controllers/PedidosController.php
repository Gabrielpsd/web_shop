<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PedidosController extends Controller
{
    public function index(){
        $sql = <<< sql
            select
                pedidos.id,
                pedidos.id_cliente,
                cliente.descricao as cliente,
                cliente.sexo,
                (select COALESCE(sum(produtos_pedido.quantidade * produtos_pedido.preco),0) from produtos_pedido where produtos_pedido.id_pedido = pedidos.id) as valor_total,
                data_venda
                from pedidos
            join cliente_fornecedor cliente on 
                pedidos.id_cliente = cliente.id
        sql;

        $pedidos = DB::select($sql);

        $sql = <<< CLIENTES
            select 
                * 
            from 
                cliente_fornecedor
            where 
                fornecedor = false
        CLIENTES;

        $clientes = DB::select($sql);

        $sql = <<< VENDASAGRUPADASPORANO
            select
                pedidos.id,
                pedidos.id_cliente,
                cliente.descricao as cliente,
                (select COALESCE(sum(produtos_pedido.quantidade * produtos_pedido.preco),0) from produtos_pedido where produtos_pedido.id_pedido = pedidos.id) as valor_total,
                data_venda
                from pedidos
            join cliente_fornecedor cliente on 
                pedidos.id_cliente = cliente.id 
        VENDASAGRUPADASPORANO;
        return Inertia::render('Pedidos/list',
                ['Pedidos' => $pedidos,
                'Clientes' => $clientes]
        );
    
    }

    public function  inserirPedido(Request $request){
        $request = $request->all();
        dump($request);
        $marcas  = Pedidos::create([
            'id_cliente'=>$request['id_cliente'],
            'data_venda'=>$request['data_venda']]);
        dump($marcas);

        return response()->json($marcas);
    }

    public function editarPedido(string $id)
    {
        $sql = <<<SQL
             select
                pedidos.id,
                pedidos.id_cliente,
                cliente.descricao as cliente
            from pedidos
            join cliente_fornecedor cliente on 
                pedidos.id_cliente = cliente.id
            where 
                pedidos.id = ?
        SQL;

        $pedido = DB::select($sql,[$id]);

        $sql = <<<SQL
            select 
                produtos_pedido.id,
                produtos_pedido.id_pedido,
                produtos.descricao,
                produtos_pedido.id_produto,
                produtos_pedido.quantidade,
                produtos_pedido.preco, 
                produtos.descricao
            from 
                produtos_pedido 
            join produtos on 
                produtos.id = produtos_pedido.id_produto
            where 
            produtos_pedido.id_pedido = ?
        SQL;

        $Produtos = DB::select($sql,[$id]);
        $produtosCadastrados = Produto::all();

        return Inertia::render('Pedidos/edit',
        [
            'PedidoBD'=>$pedido,
            'ProdutosBD'=>$Produtos,
            'ProdutosCadastrados'=> $produtosCadastrados
        ]);
    }

    public function inserirProdutos(Request $request , string $id)
    {
        $sql = <<< SQL
            insert into 
                produtos_pedido (id_produto,id_pedido,quantidade,preco) 
            values 
                (?,$id,?,?);
        SQL;

        foreach($request->request as $pedido)
        {
            DB::select($sql,[$pedido['id'],$pedido['quantidade'],$pedido['preco']]);
        }

        return response()->json('Sucesso nas inserções');
    }

    public function editarProdutoPedido(Request $request , string $id)
    {
        $sql = <<< SQL
            update 
                produtos_pedido 
            set
                quantidade = ? ,
                preco = ?
            where 
                id = ? and id_pedido = ?
        SQL;

        foreach($request->request as $pedido)
        {
            if(isset($pedido['id']))
                DB::update($sql,[$pedido['quantidade'],$pedido['preco'],$pedido['id'],$id]);
        }

        return response()->json('Sucesso nas alterações');
    }

    public function removerProdutosPedido(Request $request , string $id)
    {
        $sql = <<< SQL
            delete from 
                produtos_pedido 
            where 
                id = ? and id_pedido = ?
        SQL;
	
        foreach($request->request as $pedido)
        {
            if(isset($pedido['id']))
                DB::update($sql,[$pedido['id'],$id]);
        }

        return response()->json('Sucesso nas remoções');
    }

    public function excluirPedido(string $id)
    {
        $sql = <<< SQL
            delete from 
                produtos_pedido 
            where 
                id_pedido = ?
        SQL;

        $response = DB::delete($sql,[$id]);

        $sql = <<< SQL
            delete from pedidos 
            where pedidos.id = ?
        SQL;

        $response = DB::delete($sql,[$id]);
    
        return response()->json($response);
    }
}
