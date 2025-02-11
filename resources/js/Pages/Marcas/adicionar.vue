<script>
import Layout from '../shared/Layout.vue'
import rotas from '../Assets/ConfigFiles/apiconfig'

export default{
    layout: Layout,
    data(){
        return{
            descricao: '',
            edicaoInativa: true,
            tamanhoNomeInvalido: false,
          }
    },
    methods: {
        salvaAlteracoes(){

            if(this.validacoes())
            {
                let obj = this
                const csrfToken = document.getElementsByName("_token")[0].value
                var request = new XMLHttpRequest()
                
                let pessoa = {'descricao':this.descricao}
                request.open('POST',rotas.marcas.adicionar,true)
                request.setRequestHeader("Content-Type","application/json")
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
                
                request.onload = function(){
                    if(this.readyState == XMLHttpRequest.DONE)
                        if(this.status == 200)
                            obj.$emit('adicionar',JSON.parse(this.responseText))
                } 

                request.send(JSON.stringify(pessoa))

                this.cancelaAdicao()
            } 

        },
        validacoes()
        {
            if(this.descricao.length < 3)
            {
                this.tamanhoNomeInvalido = true
                return false
            }

            return true
        },
        cancelaAdicao(){
            this.descricao = ''
            this.edicaoInativa = true,
            this.tamanhoNomeInvalido = false
        },
    }
}
</script>

<template>
   <div class="card border-dark mb-3" style="max-width: 18rem;" >
        <div class="card-header spacing">
            <button  class="btn btn-primary"  @click="edicaoInativa = false"v-if="edicaoInativa">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                </svg>
                Inserir Cadastro
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
            <h5 class="card-title">Descricao<input type="text" class="form-control" v-bind:readonly="edicaoInativa" v-model="descricao" :class="{campoInvalido: tamanhoNomeInvalido}"></h5>
            
        </div>
        <ul v-if="tamanhoNomeInvalido">
            <li v-if="tamanhoNomeInvalido">Nome deve conter no minimo 3 caracteres</li>
        </ul>
    </div>
</template>

<style scoped>
select {
    width: 100%;
    max-width: 250px;
    margin-bottom: 10px;
}
    ul{
        color: red;
    }
    .campoInvalido{
        border-color: red;
    }
    .date{
        height: 30px;
        width: 30px;
    }

    .computer-view {
        display: inline;
    }
    .device-view {
        display: none;
    }
    @media (max-width: 768px) {
        .computer-view {
            display: none;
        }
        .device-view {
            display: inline;
        }
    }

    @media (max-width: 480px) {
        .computer-view {
            display: none;
        }
        .device-view {
            display: inline;
        }
    }
</style>