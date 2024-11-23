<script>
import Layout from '../shared/Layout.vue'
import rotas from '../Assets/ConfigFiles/apiconfig'
import inputFloatNumber from '../utils/inputFloatNumber.vue';
import axios from 'axios';

export default{
    layout: Layout,
    components:{
        inputFloatNumber,
    },
    props:{
        Fornecedores: Array,
        Marcas: Array
    },
    data(){
        return{
            descricao: '',
            preco:0,
            fornecedor: 0,
            marca: 0,
            edicaoInativa: true,
            tamanhoDescricaoInvalida: false,
            precoMinimoInvalido: false,
            marcaInvalida: false,
            fornecedorInvalido: false,
        }
    },
    methods: {
        insereObjeto(){
            const csrfToken = document.getElementsByName("_token")[0].value
                let obj = this
                var request = new XMLHttpRequest()  
                let produto = JSON.stringify({
                    descricao:this.descricao, 
                    preco: this.preco, 
                    id_fornecedor: this.fornecedor, 
                    id_marca:this.marca,
                    ativo: true})
                request.open('POST',rotas.produtos.inserir)
                request.setRequestHeader("Content-Type","application/json")
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
                request.onload= function()
                {

                    if(this.readyState == XMLHttpRequest.DONE)
                        if(this.status == 200)
                            obj.$emit('adicionar',JSON.parse(this.responseText))
                    
                }

                request.send(produto)

                this.cancelaAdicao()
        },
        salvaAlteracoes(){
            if(this.realizaValidacoes())
                this.insereObjeto()
        },
        realizaValidacoes()
        {
            let retorno = true
            this.tamanhoDescricaoInvalida = false
            this.precoMinimoInvalido = false
            this.fornecedorInvalido = false  
            this.marcaInvalida = false 

            if(this.descricao.length <3 )
            {
                this.tamanhoDescricaoInvalida = true
                retorno = false
            }

            if(this.preco <= 0 )
            {
                this.precoMinimoInvalido = true
                retorno = false
            }

            if(this.marca == 0 )
            {
                this.marcaInvalida = true 
                retorno = false
            }

            if(this.fornecedor == 0 )
            {
                this.fornecedorInvalido = true 
                retorno = false
            }

            return retorno
        },
        cancelaAdicao(){
            this.descricao = ''
            this.preco = 0
            this.edicaoInativa = true
            this.tamanhoDescricaoInvalida = false
            this.precoMinimoInvalido = false
            this.fornecedor = 0 
            this.marca = 0
            this.marcaInvalida = false
            this.fornecedorInvalido = false
        },
        carregaArquivo()
        {
            this.extensaoInvalida = false 
            let extension = this.$refs.file.files[0].name.substring(this.$refs.file.files[0].name.lastIndexOf('.')+1).toLowerCase()
            if(!rotas.EXTENCOESVALIDAS.includes(extension))
            {
                this.extensaoInvalida = true;
                return 
            }
            const csrfToken = document.getElementsByName("_token")[0].value


            let data = new FormData()

            data.append('file',this.$refs.file.files[0])

            axios.post(rotas.ROTAARQUIVOS,data).then((response)=>{
                this.cadastraProdutos(response)})
        },

        cadastraProdutos(data){

            let fornecedor = this.Fornecedores.find((item)=>item.cpf_cnpj == data.data.Fornecedor.CPF_CNPJ[0])

            if(fornecedor)
            {
                let i = 1

                let marca = this.marca
                
                while(data.data.produtos[i])
                {
                    if(marca == 0 )
                    {
                        this.marcaInvalida = true
                        return  
                    }
                    
                    this.descricao = data.data.produtos[i].descricao[0]
                    this.preco = data.data.produtos[i].preco[0]
                    this.fornecedor = fornecedor.id
                    this.marca = marca
                    this.insereObjeto()
                    i = i + 1 
                }
            }

        }  
    }
}
</script>

<template>
    <div class="card border-dark mb-3" style="max-width: 18rem;" >
        <div class="card-header spacing">
            <button  class="btn btn-primary"  @click="edicaoInativa = false"v-if="edicaoInativa">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAACFElEQVR4nO2Xy04VQRCGJ8YVaAIhKCHuSFiwZYkLMISF0YTg3gfwCTCwAH0Cd7rlBTQeX8CDlxUI7HgCTVhwiVxyqshnylNjOmPP7VwSFqeSTmZ6qqv+/uvSPUkykB4KMKqwrnAgcCHwW2FX4DUwnvRTBB4LnCoQG/ZNYKVfzpcFxJ19FJgHhm0ILCg0HMR1VyCAIYUXAoc27Bl4IPDLnb9MdRW+KmwH72sO4qR2OIB7ApsCRxFqNd15uCb9nplLmdis6nha4J3AZeD0u8AzG/YcAJkvAyDwyOd3Cx234KHCB4tZGjt7t/msrsC56QB3nPZoElo4gLtu7yy221uRXV0aA8ZEHlgvtRTAdgGAZgDg/D9DCs3A8ZHAK4t9IVXtdT98zUKNEOzFDNEJANPzdY0yAAqffH61CMC3OiEA7gsc+5q1wJ6Foxm8r7vNY2AkF0DSTsI5hfdVktATdj/YQMOotpyw4bT/3blAS2ApuhONUOZl+LZiGRpbZwWt+KfAkzwmkxiAio3oX74AE3bwGCOW6WmJepWM5TovA5BtxQEAa8VD3dqtp9gvXR0AYBACbkYSao9KK1uyVQA0qx5GHTStz6UAaN8Hnip8CYBcCWwBM2UAgCmBN2H3U9hReA7cTupIC2bNcXrf88PIDpnFLIAy3a6EnDthp0d3N0DGBTZyDqMTox6Y7Lnjiv8FhRUzkKRE/gAHfk5yC+KeWAAAAABJRU5ErkJggg==" alt="external-add-product-supply-chain-management-outline-outline-black-m-oki-orlando">
                Inserir Produto
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
            </div>
            <div v-if="edicaoInativa">
                Preço R$: <input placeholder="0,00" size="5">
            </div>
            <div v-if="!edicaoInativa">
                Preço R$: <inputFloatNumber  :number="preco" @atualiza="(args)=>this.preco = args" ></inputFloatNumber>
            </div>
            <div class="input-group " v-if="!edicaoInativa">
            <div class="custom-file">
                    <label class="custom-file-label" for="inputGroupFile01">Importar de um XML?</label>
                    <input type="file" ref="file" class="custom-file-input" v-on:change="carregaArquivo()" accept=".xml,.XML,.Xml">
                </div>
            </div>
            <ul>
                <li v-if="tamanhoDescricaoInvalida"> Descricao deve conter no minimo 3 caracteres</li>
                <li v-if="precoMinimoInvalido">Preco deve ser maior que zero</li>
                <li v-if="marcaInvalida">Selecione uma marca</li>
                <li v-if="fornecedorInvalido">Selecione um fornecedor</li>
                <li v-if="extensaoInvalida">Extensão inválida</li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
    ul{
        color: red
    }
    select{
        margin: 2px;
        max-width: 200px;
    }
    input{
        margin: 2px;
        max-width: 200px;
    }

</style>