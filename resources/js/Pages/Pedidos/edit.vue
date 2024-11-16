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
        PedidoBD: Object,
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
            Pedido:this.PedidoBD[0],
            Produtos: this.ProdutosBD,
            listaDelecoes: [],
            listaInsercoes: [],
            listaAlteracoes: [],
            modoInsercaoLigado: false,
            modalAberto: false,
            telaDesbloqueada:this.PedidoBD[0].pedido_aberto
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
                request.open('POST',rotas.pedidos.adicionar(this.PedidoBD[0].id),false)
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
                request.setRequestHeader("Content-Type","application/json")
                request.send(JSON.stringify(this.listaInsercoes))    
                
            }
            
            if(this.listaDelecoes.length > 0)
            {
                request.open('POST',rotas.pedidos.remover(this.PedidoBD[0].id),false)
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
                request.setRequestHeader("Content-Type","application/json")
                request.send(JSON.stringify(this.listaDelecoes))
                
            }
            
            if(this.listaAlteracoes.length > 0)
            {
                request.open('POST',rotas.pedidos.editar(this.PedidoBD[0].id),false)
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
                request.setRequestHeader("Content-Type","application/json")
                request.send(JSON.stringify(this.listaAlteracoes))
            }

            router.visit(rotas.pedidos.lista, {
                                                    method: 'get',
                                                    data: {},
                                                    })
        },
        /* 0 = fechar modal e continuar na página de edicao; 1 = retornar para a pagina de edição e perder as alterações  */ 
        situacaoModal(int){
            if(int == 1 )
            {
                router.visit(rotas.pedidos.lista, {
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
            <h3>Cliente:</h3>
            <p>{{ Pedido.cliente }}</p>
            <h3>Garçom</h3>
            <p>{{ Pedido.garcom }}</p>
            <h3>TotalPedido</h3>
            <p> R$ - {{valorTotal().toFixed(2)}}</p>
            
            <div v-if="Pedido.pedido_aberto">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAABmElEQVR4nO2YS07DQAxApyfhdwAqWKJmJnABfrGrHobfvZJxBRU3oIUTAOoGyqarIqcgKsGiP7uh8pNGiiaTSE8ztsZ2zjAMwzAMY/05bMOej3AdCGIg6HqCDx78zHP8jte4SjJyNR+b556wFwhH04xybQFn/K2rAo12thUI76cV+CUUoeMjbq5UIhRw4CO8zCsxsTv9hCBdiUTahsRHHC4q8bMzOOR/qkrwUQgRX5clMbkzaY47OhYjV1skJqaJGaeRADxhJiURvkZKeCqfZmdIsXOPCA+iHmmR7YtL0PcRy+piIoHgRk8EryRFop4I5HIiEZ7URAh7ciKEAy2RQDiQE4n4rni03sREfIRHvR2BrphIiFisRbD7smBSi5ELMRGu7LRE0hx2xUTW5orCcHmqEB/HTqc+h46YBOGd0yLNWxvLKHH/kOgf3ba21USkSt2EsOFW1nwgeP7XzYfJdtAiMcMxwUfVVYKRq3F5ymlzlhSbUPPEVRUfs3oguOQrxrhNWt6YB2X7dDx3KVr9GYZhGIZhuMrwCdHxzUPjqtlvAAAAAElFTkSuQmCC" alt="full-stop">
                Pedido aberto
            </div>
            <div v-if="!Pedido.pedido_aberto" >
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAABh0lEQVR4nO2YS04CQRCG25P4OoAEl0YSTzD9/8h1VLyXspF4A0FPoMaNYmSqXYwpMjFIXPDqZpjUl1QyYQLJR1d1qso5wzAMwzCM+iNAU4CuAL0ADAT41Cife+W7pqsihXM7OXAegGEgi7kCGOZkW7/rqsC409kX8n5ugZkQoD/Osr2NSgTyRMiXZSV+Zci3b/JsUxItAWRViamT0d9qJZXQVBDgdV0S0ycz9v4wiYQW5yo1MU/NFCkuAAE6sSRCGbn3jCqh/9RCV+zy8RBVJHh/nECimKRYljWiiQh5nUwEuIonom1HKhHyJppIAJ5SiQRgGE1EgFHC1BrFEyE/Eoq8RxMJ5GPC1BpEExHgthbFLkA32YmQFzFFmglr5CiaSG1aFEXH09giOeldkjYe6EdMqTuXii9ydx0j7r+DFXngtn7UbbdPk0rMLB+et3r58GcdtELNaE1oqrrKLOi8p16bi1yxOQBXVSTLGoG81BajXJOOJl2zPutn+i7m9GcYhmEYhuEqww8oxoC/bR5UBQAAAABJRU5ErkJggg==" alt="full-stop"> Pedido fechado 
            </div>
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
    .busy_dot{
        height: 15px;
        width: 15px;
        background-color: red;
        border-radius: 50%;

    }
    .free_dot{
        height: 15px;
        width: 15px;
        background-color: green;
        border-radius: 50%;
    }
</style>