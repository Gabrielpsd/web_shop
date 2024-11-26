<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequesAPI_controller extends Controller
{
    public function todosPedidos()
    {
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

        return response()->json($pedidos);
    }

    public function detalhePedido($id)
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

        $pedido['produtos'] = DB::select($sql,[$id]);

        return response()->json($pedido);
    }
}
