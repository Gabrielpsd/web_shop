<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashBoardController extends Controller
{   
    public function index()
    {
        return to_route('pedidos');
    }

    public function vendasPorSexo()
    {
        $sql = <<< VENDASPORSEXO
            select 
                pedido.data
                case sexo 
                    when 'M' then 'Masculino'
                    when 'F' then 'Feminino'
                end as sexo
            from 
                pedidos
            join cliente_fornecedor on 
                cliente_fornecedor.id = pedidos.id_cliente
            where 
                cliente_fornecedor.fornecedor = false
            group by
                cliente_fornecedor.sexo
        VENDASPORSEXO;

        return response()->json(DB::select($sql));
    }

    public function vendasPorIdade()
    {
        $sql = <<< VENDASPORIDADE
            select 
                count(*) as quantidade,
                idade
            from 
                pedidos
            join cliente_fornecedor on 
                cliente_fornecedor.id = pedidos.id_cliente
            where 
                cliente_fornecedor.fornecedor = false
            group by
                cliente_fornecedor.idade
        VENDASPORIDADE;

        return response()->json(DB::select($sql));
    }

    public function pessoasPorIdade()
    {
        $sql = <<< PESSOASPORIDADE
            select 
                count(*) as quantidade,
                COALESCE(idade, 0) as idade
            from 
                cliente_fornecedor
            group by
                cliente_fornecedor.idade
        PESSOASPORIDADE;

        return response()->json(DB::select($sql));
    }

    public function produtosPorMarca()
    {
        $sql = <<< PRODUTOSPORMARCA
            select 
                count(*) as quantidade,
                marcas.descricao
            from 
                produtos
            join marcas on 
                marcas.id = produtos.id_marca
            group by 
                marcas.descricao
        PRODUTOSPORMARCA;

        return response()->json(DB::select($sql));
    }
}
