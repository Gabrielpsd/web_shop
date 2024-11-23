export const BASE_URL = 'https://799b-170-0-169-88.ngrok-free.app'
export const PRODUTOS = `${BASE_URL}/produtos`
export const PRODUTOSAPI = `${BASE_URL}/api/produtos`
export const PEDIDOS = `${BASE_URL}/pedidos`
export const PEDIDOSAPI = `${BASE_URL}/api/pedidos`
export const FORNECEDORES = `${BASE_URL}/fornecedores`
export const PESSOAS = `${BASE_URL}/clientesfornecedores`
export const PESSOASAPI = `${BASE_URL}/api/clientesfornecedores`
export const MARCAS = `${BASE_URL}/marcas`
export const MARCASAPI = `${BASE_URL}/api/marcas`
export const ENTRADAS = `${BASE_URL}/entradas`
export const ENTRADASAPI = `${BASE_URL}/api/entradas`
export const DASHBOARD = `${BASE_URL}/api/dashboard`

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
        excluir:(pedido)=>`${PEDIDOSAPI}/excluir/${pedido}`,
        detalhe: (pedido) => `${PEDIDOS}/detalhe/${pedido}`,
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
    entradas:{
        lista: ENTRADAS,
        excluir: (pedido) => `${ENTRADASAPI}/excluir/${pedido}`,
        criar:`${ENTRADASAPI}/criarpedido`,
        detalhe: (pedido) => `${ENTRADAS}/detalhe/${pedido}`,
        remover: (pedido) => `${ENTRADASAPI}/removerProdutos/${pedido}`,
        adicionar: (pedido) => `${ENTRADASAPI}/inserirProdutos/${pedido}`,
        editar: (pedido) => `${ENTRADASAPI}/editarProdutos/${pedido}`,
    },
    dashboard:{
        vendasPorSexo: `${DASHBOARD}/vendasporsexo`,
        pessoasPorIdade: `${DASHBOARD}/pessoasPorIdade`,
        vendasPorIdade: `${DASHBOARD}/vendasPorIdade`,
        produtospormarca: `${DASHBOARD}/produtospormarca`,
    },
    EXTENCOESVALIDAS: ['XML', 'xml', 'Xml'],
    ROTAARQUIVOS: `${BASE_URL}/api/upload`
    ,
    geracor(){
        // Storing all letter and digit combinations 
            // for html color code 
            let letters = "0123456789ABCDEF"; 
            
            // HTML color code starts with # 
            let color = '#'; 
                
            // Generating 6 times as HTML color code  
            // consist of 6 letter or digits 
            for (let i = 0; i < 6; i++) 
                color += letters[(Math.floor(Math.random() * 16))]; 

            return color
    }
}
