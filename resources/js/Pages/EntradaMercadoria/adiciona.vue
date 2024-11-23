<script>
import Layout from '../shared/Layout.vue'
import rotas, { PRODUTOS } from '../Assets/ConfigFiles/apiconfig'
import { router } from '@inertiajs/vue3'
import axios from 'axios';
export default{
    layout: Layout,
    props: {
        Fornecedores: Array,
        Produtos: Array
    },
    data(){
        return{
            fornecedor: 0,
            edicaoInativa: true,
            fornecedorInvalido: false,
            extensaoInvalida: false,
            dataOriginal: '',
            data_compra: new Date().toLocaleDateString('pt-BR', {timeZone: 'UTC'}),
          }
    },
    methods: {  
        salvaAlteracoes(){
            if(this.validacoes())
            {
                let obj = this
                const csrfToken = document.getElementsByName("_token")[0].value
                var request = new XMLHttpRequest()
                
                let pessoa = JSON.stringify({'id_fornecedor':this.fornecedor, 'data_compra': this.dataOriginal})
                request.open('POST',rotas.entradas.criar,true)
                request.setRequestHeader("Content-Type","application/json")
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
                
                request.onload = function(){
                    if(this.readyState == XMLHttpRequest.DONE)
                        if(this.status == 200)
                        {
                            let page = JSON.parse(this.responseText)
                        }
                } 

                request.send(pessoa)
                this.cancelaAdicao()
            } 

        },
        validacoes()
        {
            if(this.fornecedor == 0)
            {
                this.fornecedorInvalido = true
                return false
            }

            return true
        },
        cancelaAdicao(){
            this.fornecedor = 0
            this.edicaoInativa = true
        },
        formataData(arg){

            if(this.edicaoInativa)
                return

            this.dataOriginal = arg.originalTarget.value
            this.data_compra = new Date(arg.originalTarget.value).toLocaleDateString('pt-BR', {timeZone: 'UTC'})
        }
         
    }
}
</script>

<template>
   <div class="card border-dark mb-3" style="max-width: 18rem;" >
        <div class="card-header spacing">
            <button  class="btn btn-primary"  @click="edicaoInativa = false" v-if="edicaoInativa">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABXklEQVR4nNWVPS8EURSGR0REraCUELXoiMIvoNBoxMcvoKJSWZsgoaOVCJFI9BQKjUYv8bUi6CSswu57kkfu5hZjzIz9GMk6yc1N5pz3POe+kzsTBM0UQJ/gGej9E4Bg1AC31yK6FXwItoHWzAEGs4JdJzSYzgJgMCO4joofBPsZAY7iAIeCuywAgkfBXpS64MRAV4ygIFgLAwTr7nm0Fuj2ds9/S5RhyIvHYwAbXnQe3h0kpnbM5cowHCW3Cz4F+YRj533zyhJsJtStqNKfjh9JgwuDszhhGJLU3IXBicFlbFKwJSim3QegPyXXIngV7CTRJ92EJRgI6ogSDHoL55Im6PEWHBgs1riWBVeCN6AzcQrBS/hlWpVLYM77MoykHtPgWHAPtNVj068hmPBTnRos1WjTVFUQdwsFT3XYdBM0VQhW/b8i10hNGqDoj/7eSE0aIOcauO9LIzX/O74Aa1aRIpm8gtgAAAAASUVORK5CYII=" alt="buy">
                Novo Pedido
            </button>
            <button  class="btn btn-success" @click="salvaAlteracoes()" v-if="!edicaoInativa">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                    <path d="M11 2H9v3h2z"/>
                    <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                </svg>
                Salvar
            </button>
            <button  class="btn btn-danger" @click="cancelaAdicao()" v-if="!edicaoInativa">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
                Cancelar
            </button>
        </div>
        <div class="card-body text-dark" >
            <select v-model="fornecedor" :disabled="edicaoInativa">
                <option disabled value="0">Selecione um fornecedor</option>
                <option v-for="fornecedor in this.Fornecedores" :value="fornecedor.id">{{fornecedor.descricao}}</option>
            </select>
            <div>
                <input type="text" :value="this.data_compra" :disabled="true"/>
                <input type="date" class="date" @input="(arg)=>this.formataData(arg)">
            </div>
        </div>
        <ul>
            <li v-if="fornecedorInvalido">Selecione um fornecedor</li>
        </ul>
    </div>
</template>

<style scoped>
    ul{
        color: red;
    }
    .campoInvalido{
        border-color: red;
    }
    input{
        margin: 2px;
    }
    select{
        margin: 2px;
        max-width: 200px;
    }
    .date{
        height: 30px;
        width: 30px;
    }
</style>