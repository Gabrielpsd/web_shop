<script>
import { readonly } from 'vue';
import Layout from '../shared/Layout.vue'
import rotas from '../Assets/ConfigFiles/apiconfig'
import inputFloatNumber from '../utils/inputFloatNumber.vue';
import inputFloatNumberDisable from '../utils/inputFloatNumberDisable.vue';
import modalRetornoIncorreto from '../modal/modalRetornoIncorreto.vue';
import modalConfirmaExclusao from '../modal/modalConfirmaExclusao.vue';

export default{
    layout: Layout,
    props: {
        produto: Object,
        Fornecedores: Array,
        Marcas: Array
    },
    components:{
        inputFloatNumber,
        inputFloatNumberDisable,
        modalRetornoIncorreto,
        modalConfirmaExclusao
    },
    data(){
        return{
            descricao: this.produto.descricao,
            preco: this.produto.preco,
            edicaoInativa: true,
            modalAtivo: false,
            fornecedor: this.produto.id_fornecedor,
            marca: this.produto.id_marca,
            modalMensagem: {titulo: 'Erro ao processar registro', mensagem :'Não foi possível processar registro'},
            itemAtivo: this.produto.ativo,
            exclusaoAtiva: false
        }
    },
    methods: {
        salvaAlteracoes(){
            if(this.validacoes())
            {
                const csrfToken = document.getElementsByName("_token")[0].value
                var request = new XMLHttpRequest()
                var data = JSON.stringify(
                    {descricao:this.descricao, 
                        preco: this.preco, 
                        id_fornecedor: this.fornecedor, 
                        id_marca:this.marca,
                        ativo: this.itemAtivo})
                request.open('POST',rotas.produtos.editar(this.produto.id),true)
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
                request.setRequestHeader("Content-Type","application/json")
                
                request.send(data)

            } 

            this.edicaoInativa = true

        },
        cancelaEdicao(){
            this.descricao = this.produto.descricao
            this.preco = this.produto.preco
            this.edicaoInativa = true
            this.fornecedor = this.id_fornecedor
            this.marca = this.id_marca
        },
        excluiProduto(){
            const csrfToken = document.getElementsByName("_token")[0].value
                var request = new XMLHttpRequest()
                let obj = this

                request.open('DELETE',rotas.produtos.remover(this.produto.id),true)
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)

                this.exclusaoAtiva = false
                request.onload = function(){
                    if(this.readyState == XMLHttpRequest.DONE)
                        if(this.status == 209)
                        { 
                            obj.modalMensagem = {titulo: 'Produto não pode ser excluido', mensagem :'Produto consta em um pedido'}
                            obj.modalAtivo = true
                        }

                        if(this.status == 200)
                        {
                            obj.$emit('removerProduto',obj.produto.id)
                        }
                } 

                request.send()
        },
        validacoes(){
            let retorno = false
            if(this.produto.descricao != this.descricao)
                retorno = true
            if(this.produto.preco != this.preco)
                retorno = true
            if(this.fornecedor != this.produto.id_fornecedor)
                retorno = true
            if(this.marca != this.produto.id_marca)
                retorno = true
            if(this.itemAtivo != this.produto.ativo)
                retorno = true

            return retorno
        },
        excluiCadastro(arg){
            if(arg == false)
                this.exclusaoAtiva = false
            else
            {
                this.excluiProduto()
            }
        },
    }
}
</script>

<template>
    <modalConfirmaExclusao v-if="exclusaoAtiva" @respostaModal="(arg)=>excluiCadastro(arg)"></modalConfirmaExclusao>
    <modalRetornoIncorreto v-if="modalAtivo" @fechaModal="()=>this.modalAtivo = false" :mensagem="modalMensagem"></modalRetornoIncorreto>
    <div class="card border-dark mb-3" style="max-width: 18rem;" >
        <div class="card-header spacing">
            <div>
                Id Produto:  {{ produto.id }}
            </div>
            <div>
                <button  class="btn btn-secondary"  @click="edicaoInativa = false"v-if="edicaoInativa">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                    </svg>
                    Editar
                </button>
                <button  class="btn btn-success" @click="salvaAlteracoes()" v-if="!edicaoInativa">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2z"/>
                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                    </svg>
                    Salvar
                </button>
                <button  class="btn btn-danger" @click="cancelaEdicao()" v-if="!edicaoInativa">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                    Cancelar
                </button>
                <button  class="btn btn-outline-danger" @click="exclusaoAtiva = true" v-if="edicaoInativa">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                    </svg>
                    Excluir
                </button>
            </div>
        </div>
        <div class="card-body text-dark">
            <h5 class="card-title">Descricao<input type="text" v-bind:readonly="edicaoInativa" v-model="descricao"></h5>
            <div >
                <h6>Fornecedor</h6>
                <select v-model="fornecedor" :disabled="edicaoInativa">
                    <option disabled value="0">Selecione um fornecedor</option>
                    <option v-for="fornecedor in this.Fornecedores" :value="fornecedor.id">{{fornecedor.descricao}}</option>
                </select>
                <h6>Marca</h6>
                <select v-model="marca" :disabled="edicaoInativa">
                    <option disabled value="0">Selecione uma marca</option>
                    <option v-for="marca in this.Marcas" :value="marca.id">{{marca.descricao}}</option>
                </select>
                <div>       
                    <label for="checkbox" v-if="itemAtivo">Item ativo</label>
                    <label for="checkbox" v-if="!itemAtivo">Item inativo</label>
                    <input type="checkbox" id="checkbox" v-model="itemAtivo" :disabled="edicaoInativa"/>
                </div>
            </div>
            <div v-if="edicaoInativa">
                Preço R$: <inputFloatNumberDisable  :number="preco" v-model:number="preco" :key="preco"></inputFloatNumberDisable>
            </div>
            <div v-if="!edicaoInativa">
                Preço R$: <inputFloatNumber  :number="preco" v-model:number="preco"></inputFloatNumber>
            </div>
        </div>
    </div>
</template>

<style scoped>
     select{
        margin: 2px;
        max-width: 200px;
    }
    input{
        margin: 2px;
        max-width: 200px;
    }
</style>