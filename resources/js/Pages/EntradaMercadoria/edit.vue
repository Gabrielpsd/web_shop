<script>
import Layout from '../shared/Layout.vue';
import itemCard from '../cartoes/itemCard.vue';
import adicionarItemCarrinho from '../cartoes/adicionarItemCarrinho.vue';
import modalConfimacaoFechamentoPagina from '../modal/modalConfimacaoFechamentoPagina.vue';
import rotas from '../Assets/ConfigFiles/apiconfig'
import { router } from '@inertiajs/vue3';
import modalBloqueio from '../modal/modalBloqueio.vue';

export default {
    layout:Layout,
    props: {
        Entrada: Object,
        ProdutosBD: Array,
        ProdutosCadastrados: Array
    },
    components:{
        itemCard,
        adicionarItemCarrinho,
        modalConfimacaoFechamentoPagina,
        modalBloqueio
    },
    data(){
        return{
            Pedido:this.Entrada[0],
            Produtos: this.ProdutosBD,
            listaDelecoes: [],
            listaInsercoes: [],
            listaAlteracoes: [],
            modoInsercaoLigado: false,
            modalAberto: false,
            telaDesbloqueada:true
        }
    },
    methods:{
        valorTotal(){
            let valorTotal = 0.00 
            this.Produtos.forEach(element => {
                valorTotal += parseFloat(element.preco) * parseInt(element.quantidade)
            });

            return valorTotal
        },
        deletarItem(id)
        {   
            /* salva item para ser removido */ 
            this.listaDelecoes.push(this.Produtos.find(produto=>produto.id == id))
            /* remove item da lista*/ 
            this.Produtos = this.Produtos.filter(produto=>produto.id != id)
        },
        itemsModificados(idItem)
        {   
            /*procuto os id's para diminuir recursoes */ 
            let posicaoItemAlterado= this.listaAlteracoes.findIndex((element)=>element.id == idItem)
            let posicaoVetorPedidos = this.Produtos.findIndex((item)=>item.id == idItem)

            /* item não existe na lista de insercoes*/ 
            if(posicaoItemAlterado == -1)
            {
                this.listaAlteracoes.push(this.Produtos[posicaoVetorPedidos])
                return
            }
        
            /* caso exista removemos e adicionamos o mais recém modificado */ 
            this.listaAlteracoes[posicaoItemAlterado] = this.Produtos[posicaoVetorPedidos]
        },
        insereObjeto(objeto){
            this.listaInsercoes.push(objeto)
            this.Produtos.push(objeto)
        },
        voltar(){
            if(!(this.listaAlteracoes.length == 0 && this.listaDelecoes.length == 0 && this.listaInsercoes.length==0))
            {
                this.modalAberto = true
                return
           }

           this.situacaoModal(1)

        },
        salvaAlteracoes(){

            const csrfToken = document.getElementsByName("_token")[0].value
            this.telaDesbloqueada = false

            let request = new XMLHttpRequest()
            
            /* adiciona produtos */ 
            if(this.listaInsercoes.length > 0)
            {
                request.open('POST',rotas.entradas.adicionar(this.Entrada[0].id),false)
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
                request.setRequestHeader("Content-Type","application/json")
                request.send(JSON.stringify(this.listaInsercoes))    
                
            }
            
            if(this.listaDelecoes.length > 0)
            {
                request.open('POST',rotas.entradas.remover(this.Entrada[0].id),false)
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
                request.setRequestHeader("Content-Type","application/json")
                request.send(JSON.stringify(this.listaDelecoes))
                
            }
            
            if(this.listaAlteracoes.length > 0)
            {
                request.open('POST',rotas.entradas.editar(this.Entrada[0].id),false)
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
                request.setRequestHeader("Content-Type","application/json")
                request.send(JSON.stringify(this.listaAlteracoes))
            }

            router.visit(rotas.entradas.lista, {
                                                    method: 'get',
                                                    data: {},
                                                    })
        },

        /* 0 = fechar modal e continuar na página de edicao; 1 = retornar para a pagina de edição e perder as alterações  */ 
        situacaoModal(int){
            if(int == 1 )
            {
                router.visit(rotas.entradas.lista, {
                                                    method: 'get',
                                                    data: {},
                                                    })
            }
            if(int == 0)
            {
                this.modalAberto = false
            }
        }
    }
}
</script>

<template>
    <button @click="voltar" class="btn-close"></button>
    <modalConfimacaoFechamentoPagina v-if="modalAberto" @respostaModal="(arg)=>situacaoModal(arg)"></modalConfimacaoFechamentoPagina>
    <div class="salvaAlteracoes">
    <h2>Pedido {{Pedido.id}}</h2> 
        <button type="button" class="btn btn-secondary" v-if="(listaAlteracoes.length == 0 && listaDelecoes.length == 0 && listaInsercoes.length==0 ) && !salvando" disabled>Salvar Alterações 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
            </svg>
        </button>
        <button type="button" class="btn btn-secondary"  @click="salvaAlteracoes"v-if="!(listaAlteracoes.length == 0 && listaDelecoes.length == 0 && listaInsercoes.length==0 ) && !salvando">Salvar Alterações
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
            </svg>
        </button>
        <button type="button" class="btn btn-secondary"  v-if="salvando">
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Loading...</span>
        </button>
    </div>
    <div class="pedidos rounded border border-secondary " :class="{bloqueado : !telaDesbloqueada}">
        <div class="dadosPedido">
            <h3>Fornecedor:</h3>
            <p>{{ Pedido.fornecedor }}</p>
            <h3>TotalPedido</h3>
            <p> R$ : {{valorTotal().toFixed(2)}}</p>
        </div>
        <div class="ListaProdutos">
            <ul class="list-group">
                <li class="list-group-item" v-for="produto in Produtos" :key="index">
                <div class="flex">
                    <h5>{{ produto.descricao }}</h5>
                    <button type="button" class="btn btn-secondary btn-sm" @click="deletarItem(produto.id)">Remover 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                        </svg>
                    </button>
                </div>
                    <div class="inline">
                        <itemCard :produto="produto" v-model:preco="produto.preco" v-model:quantidade="produto.quantidade" @modificacao="(parametro)=>itemsModificados(parametro)"></itemCard>
                    </div>
                </li>
            </ul>
        </div>
        <div class="rounded border"> 
            <adicionarItemCarrinho :Produtos="ProdutosCadastrados" @insereObjeto="(item=>insereObjeto(item))"></adicionarItemCarrinho>
        </div>
    </div>
</template>

<style scoped>
@media (min-width: 769px)
{
    .pedidos{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        max-width: 80vw;
        margin-left: 10vw;
        margin-right: 10vw  ;
        align-self: center;
        padding: 10px;
    }
}
    p{
        border-color: gray;
        margin: 4px;
    }
    li{
        margin: 2px;
    }
    .flex{
        display: flex;
        justify-content: space-between;
    }
    .salvaAlteracoes{
        display: flex;
        justify-content: space-evenly;
        padding: 10px;
    }
    .bloqueado{
        cursor: not-allowed; /* Change cursor to indicate unavailability */
        pointer-events: none; /* Disable all mouse events */
    }


    @media (max-width: 768px) {
*{
    font-size: small;
}
}
</style>