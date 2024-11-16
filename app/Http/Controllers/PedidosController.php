<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
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
                (select COALESCE(sum(produtos_pedido.quantidade * produtos_pedido.preco),0) from produtos_pedido where produtos_pedido.id_pedido = pedidos.id) as valor_total
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

        return Inertia::render('Pedidos/list',
                ['Pedidos' => $pedidos,
                'Clientes' => $clientes]
        );
    
    }

    public function  inserirPedido(Request $request){
        $request = $request->all();
        dump($request);
        $marcas  = Pedidos::create(['id_cliente'=>$request['id_cliente']]);
        dump($marcas);

        return response()->json($marcas);
    }
}
