<script>
import Layout from '../shared/Layout.vue'
import rotas from '../Assets/ConfigFiles/apiconfig'
import {Link} from '@inertiajs/vue3';
import modalConfirmaExclusao from '../modal/modalConfirmaExclusao.vue';

export default{
    layout: Layout,
    props: {
        entrada: Object
    },
    components:{
        Link,
        modalConfirmaExclusao
    },
    data(){
        return{
            exclusaoAtiva: false
        }
    },
    methods: {
        urlEdicao(){
            return rotas.entradas.detalhe(this.entrada.id)
        },
        excluiCadastro(arg){
            if(arg == false)
                this.exclusaoAtiva = false
            else
            {
                this.deletaApi()
            }
        },
        deletaApi()
        {
            const csrfToken = document.getElementsByName("_token")[0].value
            var request = new XMLHttpRequest()
            let obj = this
            request.open('DELETE',rotas.entradas.excluir(this.entrada.id),true)
            request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
            request.setRequestHeader("Content-Type","application/json")

            request.onload = function(){
                if(this.readyState == XMLHttpRequest.DONE)
                    if(this.status == 200)
                    {
                        obj.exclusaoAtiva = false
                        obj.$emit('exclui',obj.entrada.id)
                    }
            } 

            request.send()
        }

    }
}
</script>

<template>
    <modalConfirmaExclusao v-if="exclusaoAtiva" @respostaModal="(arg)=>excluiCadastro(arg)"></modalConfirmaExclusao>
    <div class="card border-dark mb-3" style="max-width: 18rem;" >
        <div class="card-header spacing">
            Pedido {{ entrada.id }}
            <Link type="button" class="btn btn-secondary btn-sm computer-view" :href="urlEdicao()">Visualizar Pedidos</Link>
            <Link type="button" class="btn btn-secondary btn-sm device-view" :href="urlEdicao()">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABVUlEQVR4nO2UMUsDQRCFU6TzMJrWk4ABD/9ECP4VtfIXWER/S8qEQBqJIAhibCy0sLCJYpFWRRPU8guDL3AOq3exCBZ5sHDMe/P2ZnZ2C4UF/jWAMrAPHAND4FNrqJhx5b8YF4EDYEw2xtIW85rHwFXK4BTYARJgSStRzLgpLCfOMq8AD0q4B2o5fqgGDJRjuZWfhBFwJ+EFsJLi1oEOMNLqWhUpvgScK9c8otAGTQlu0gK+zJ8DvX8xzv2g5Rqa3rwu4gOoOq4jzqZmTWfUU6zttFV5GOppoq/gYaCykbjYVWV4C+gb4vqhDRozbvAa0B+FNpi26B3YcAldcT21x8xPFGs57aYu4vcWuUO+tllPxRMdqMeTq2oZuA0ecmBMbeRKriVt67lWy5mvApe/jmngog1yXrRt4DHzomU8FbvAlqqM9L0HnM30VMzlsZvLc73AXDEBG+8c+C3rAPAAAAAASUVORK5CYII=" alt="visible--v1">
            </Link>
            <button  class="btn btn-outline-danger" @click="this.exclusaoAtiva = true" width="10px" height="10px">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                </svg>
            </button>
        </div>
        <div class="card-body text-dark">
        <h5 class="card-title">Fornecedor:{{entrada.fornecedor}}</h5>
        <div class="total">
            <p class="card-text">Total: R${{ parseFloat(entrada.valor_total).toFixed(2) }}</p>
        </div>
        <div>
            <label for="Data">Data Compra</label>
            <input id="Data" type="text" :value="new Date(entrada.data_compra).toLocaleDateString('pt-BR', {timeZone: 'UTC'})" disabled/>
        </div>
        </div>
    </div>
</template>

<style scoped>
    .spacing{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .total{
        display: flex;
        justify-content: space-between;
    }
    input{
    width: 100%;
}
.computer-view{
    display: inline;
}

.device-view{
    display: none;
}

@media (max-width: 768px) {

    .computer-view{
        display: none;
    }

    .device-view{
        display: inline;
    }
}
</style>