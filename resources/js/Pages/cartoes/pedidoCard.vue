<script>
import Layout from '../shared/Layout.vue'
import rotas from '../Assets/ConfigFiles/apiconfig'
import {router} from '@inertiajs/vue3';
import {Link} from '@inertiajs/vue3';

export default{
    layout: Layout,
    props: {
        pedido: Object
    },
    components:{
        Link
    },
    methods: {
        urlEdicao(){

            return rotas.pedidos.detalhe(this.pedido.id)
        }
    }
}
</script>

<template>
    <div class="card border-dark mb-3" style="max-width: 18rem;" >
        <div class="card-header spacing">
            Pedido {{ pedido.id }}
            <Link type="button" class="btn btn-secondary btn-sm" :href="urlEdicao()">Visualizar Pedidos</Link>
        </div>
        <div class="card-body text-dark">
        <h5 class="card-title">Cliente: {{pedido.cliente}}</h5>
        <div class="total">
            <p class="card-text">Total: R${{ parseFloat(pedido.valor_total).toFixed(2) }}</p>
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