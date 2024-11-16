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
            clienteInvalido: false
          }
    },
    methods: {
        salvaAlteracoes(){
            if(this.validacoes())
            {
                let obj = this
                const csrfToken = document.getElementsByName("_token")[0].value
                var request = new XMLHttpRequest()
                
                let pessoa = JSON.stringify({'id_cliente':this.cliente})
                request.open('POST',rotas.pedidos.criar,true)
                request.setRequestHeader("Content-Type","application/json")
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
                
                request.onload = function(){
                    if(this.readyState == XMLHttpRequest.DONE)
                        if(this.status == 200)
                        {
                            let page = JSON.parse(this.responseText)
                            page = page.id
                            router.get(rotas.pedidos.editar(page))
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
            <select v-model="cliente" :disabled="edicaoInativa">
                <option disabled value="0">Selecione um cliente</option>
                <option v-for="cliente in this.Clientes" :value="cliente.id">{{cliente.descricao}}</option>
            </select>
        </div>
        <ul v-if="clienteInvalido">
            <li v-if="clienteInvalido">Selecione um cliente</li>
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
</style>