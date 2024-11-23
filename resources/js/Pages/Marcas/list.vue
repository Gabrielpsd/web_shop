<script>
import Layout from '../shared/Layout.vue'
import marcaCard from '../cartoes/marcaCard.vue'
import adicionar from './adicionar.vue'

export default {
    layout: Layout,
    props: {
        Marcas: Array
    },
    components:{
        marcaCard,
        adicionar
    },
    data(){
        return{
            marcas: this.Marcas,
        }
    },
    methods:{
        adicionarMarca(marca)
        {
            this.marcas.push(marca)

        },
        deletaMarca(arg)
        {
            this.marcas = this.marcas.filter((pessoa)=>pessoa.id != arg)
        }
    }
}
</script>

<template>
    <div >
        <div class="grid">
            <adicionar @adicionar="(arg)=>adicionarMarca(arg)"></adicionar>
            <marcaCard :marca='marca' v-for="marca in marcas" @deletaMarca="(arg)=>deletaMarca(arg)" :key="marca.id"></marcaCard>
        </div>
    </div>
</template>

<style scoped>
    pessoaCard {
        margin: 1px;
    }
    .grid{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        margin: 0 auto;
        width: 80%;
    }
    h2{
      text-align: center;
      margin-top: 50px;
      margin-bottom: 50px;  
    }
    .busy_dot{
        height: 20px;
        width: 20px;
        background-color: red;
        border-radius: 50%;
        padding: 10px;

    }
    .free_dot{
        height: 20px;
        width: 20px;
        background-color: green;
        border-radius: 50%;
        padding: 10px;

    }
    .tables{
        display: flex;
        align-items: baseline;
        margin-left: 200px;
        padding: 5px;
    }
    .tables>p{
        padding-right: 20px;
        padding-left: 5px;
    }
</style>