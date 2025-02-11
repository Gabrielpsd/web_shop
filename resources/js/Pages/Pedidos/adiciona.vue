<script>
import Layout from '../shared/Layout.vue'
import rotas from '../Assets/ConfigFiles/apiconfig'
import { router } from '@inertiajs/vue3'

export default{
    layout: Layout,
    props: {
        Clientes: Array
    },
    data(){
        return{
            cliente: 0,
            edicaoInativa: true,
            clienteInvalido: false,
            data_venda: new Date().toLocaleDateString('pt-BR', {timeZone: 'UTC'}),
            dataOriginal: ''
        }
    },
    methods: {
        salvaAlteracoes(){
            if(this.validacoes())
            {
                const csrfToken = document.getElementsByName("_token")[0].value
                var request = new XMLHttpRequest()
                
                let pessoa = JSON.stringify({'id_cliente':this.cliente,
                    'data_venda': this.data_venda
                })
                request.open('POST',rotas.pedidos.criar,true)
                request.setRequestHeader("Content-Type","application/json")
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
                
                request.onload = function(){
                    if(this.readyState == XMLHttpRequest.DONE)
                        if(this.status == 200)
                        {
                            let page = JSON.parse(this.responseText)
                            page = page.id
                            router.get(rotas.pedidos.detalhe(page))
                        }
                } 
                request.send(pessoa)
                this.cancelaAdicao()
            } 
        },
        validacoes()
        {
            if(this.cliente == 0)
            {
                this.clienteInvalido = true
                return false
            }

            return true
        },
        cancelaAdicao(){
            this.cliente = 0
            this.edicaoInativa = true
        }, 
        formataData(arg)
        {
            if(this.edicaoInativa)
                return

            let data = new Date(arg.originalTarget.value)
            this.data_venda = data.toLocaleDateString('pt-BR', {timeZone: 'UTC'});
            this.dataOriginal = arg.originalTarget.value
        }
    }
}
</script>

<template>
   <div class="card border-dark mb-3" style="max-width: 18rem;" >
        <div class="card-header spacing">
            <button  class="btn btn-primary"  @click="edicaoInativa = false" v-if="edicaoInativa">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAyElEQVR4nOWTMQ7CMAwA+y5UdsoD2OEHTHSifIE/8BN2HkFnBsRWWzoUqYNVlCYp7VCw5KGyc5c4aZb9fAisBWoFfOnqAsVQQd0HN5L7IIEaSAMLW2sgt/UxBHlHsBxVoIH8U4FM/YoECrc4BBdYZbMPhVLgJXCOad4o3AQaz2iutl/gZEb2DMGPKZcqBt5m2QevYuDSXmoX7r4HwQUu3f5U+C7lp9LPDfjh3wokBPcdOQL8UNhHwc1JDgZSJS1OkLhxbSeBzy7e9BUdiz19RJEAAAAASUVORK5CYII=" alt="sell">
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
            <select v-model="cliente" :disabled="edicaoInativa">
                <option disabled value="0">Selecione um cliente</option>
                <option v-for="cliente in this.Clientes" :value="cliente.id">{{cliente.descricao}}</option>
            </select>
            <div class="device-view"> 
                <input type="text" :value="this.data_venda" :disabled="true" size="10"/>
                <input type="date" class="date" @input="(arg)=>this.formataData(arg)">
            </div>
            <div class="computer-view">
                <input type="text" :value="this.data_venda" :disabled="true"/>
                <input type="date" class="date" @input="(arg)=>this.formataData(arg)">
            </div>
         </div>
        <ul v-if="clienteInvalido">
            <li v-if="clienteInvalido">Selecione um cliente</li>
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