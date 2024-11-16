export const BASE_URL = 'http://localhost:8000'
export const PRODUTOS = `${BASE_URL}/produtos`
export const PRODUTOSAPI = `${BASE_URL}/api/produtos`
export const PEDIDOS = `${BASE_URL}/pedidos`
export const PEDIDOSAPI = `${BASE_URL}/api/pedidos`
export const FORNECEDORES = `${BASE_URL}/fornecedores`
export const PESSOAS = `${BASE_URL}/clientesfornecedores`
export const PESSOASAPI = `${BASE_URL}/api/clientesfornecedores`
export const MARCAS = `${BASE_URL}/marcas`
export const MARCASAPI = `${BASE_URL}/api/marcas`

export default { 
    produtos: {
        lista: PRODUTOS,
        detalhe: (idProduto) => `${PRODUTOS}/${idProduto}`,
        inserir: `${PRODUTOSAPI}/inserir`,
        editar: (idProduto) => `${PRODUTOSAPI}/editar/${idProduto}`,
        remover:(idProduto) => `${PRODUTOSAPI}/remover/${idProduto}`
    },
    pedidos: {
        lista: PEDIDOS,
        criar:`${PEDIDOSAPI}/criarpedido`,
        detalhe: (pedido) => `${PEDIDOS}/editar/${pedido}`,
        remover: (pedido) => `${PEDIDOSAPI}/removerProdutosPedido/${pedido}`,
        adicionar: (pedido) => `${PEDIDOSAPI}/inserirProdutos/${pedido}`,
        editar: (pedido) => `${PEDIDOSAPI}/editarProdutoPedido/${pedido}`,
    },
    marcas: {
        lista: MARCAS,
        detalhe: (idMarca) => `${MARCAS}/editar/${idMarca}`,
        remover: (idMarca) => `${MARCASAPI}/remover/${idMarca}`,
        adicionar: `${MARCASAPI}/inserir`,
        editar: (idMarca) => `${MARCASAPI}/editar/${idMarca}`,
    },
    fornecedores: {
        lista: FORNECEDORES
    },
    pessoas:{
        lista: PESSOAS,
        editaPessoa:(idPessoa)=> `${PESSOASAPI}/editar/${idPessoa}`,
        inserirPessoa: `${PESSOASAPI}/inserir`,
        excluir: (idPessoa)=> `${PESSOASAPI}/excluir/${idPessoa}` 
    },
   BASE_URL
}
