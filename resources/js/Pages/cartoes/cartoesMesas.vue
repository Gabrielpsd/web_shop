<script>
    import { Link } from '@inertiajs/vue3'
    export default{
        components:{
            Link
        },
        props: {
            mesa: Object
        },
        methods:{
            abreMesa(){
                this.$router
            }
        }
    }


</script>

<template>
    <div class="card border-dark mb-3" style="max-width: 18rem;" >
        <div class="card-header spacing">
            Mesa {{ mesa.id_mesa }}
           <!--  <Link type="button" class="btn btn-secondary btn-sm" :href="`/mesas/${mesa.id}`">Visualizar Mesa</Link>
            --> <span class="busy_dot" v-if=" !mesa.pedido_aberto"></span>
            <span class="free_dot" v-if=" mesa.pedido_aberto"></span>
        </div>
        <div class="card-body text-dark">
        <h5 class="card-title">Cliente: {{mesa.cliente}}</h5>
        <p class="card-text">Garçom: {{ mesa.garcom }}</p>
        <div class="total">
            <p class="card-text">Total: R${{ mesa.valorAtual }}</p>
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