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
        <h3 class="device-view">Marcas </h3>
        <div class="grid">
            <adicionar @adicionar="(arg)=>adicionarMarca(arg)"></adicionar>
            <marcaCard :marca='marca' v-for="marca in marcas" @deletaMarca="(arg)=>deletaMarca(arg)" :key="marca.id"></marcaCard>
        </div>
    </div>
</template>

<style scoped>
   .grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
    margin: 0 auto;
    width: 90%;
    padding: 20px;
    gap: 10px;
}

.filtros {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
}

.filtros select {
    width: 100%;
    max-width: 250px;
}

.chartArea {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
}

.chart {
    width: 100%;
    max-width: 400px;
}

.device-view {
    display: none;
}

.date{
    width: 30px;
    height: 30px;
}

@media (max-width: 768px) {
    h4{
        width: 100%;
        text-align: center;
    }
    .grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .chart {
        max-width: 300px;
    }

    .device-view {
    display: inline;
    }

    h3 {
        color: #2c3e50;
        font-size: 1.8rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        padding-bottom: 8px;
        border-bottom: 2px solid #3498db;
        text-transform: capitalize;
        margin: 1.5rem 0;
        position: relative;
        }
}

@media (max-width: 480px) {
    h3 {
        color: #2c3e50;
        font-size: 1.8rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        padding-bottom: 8px;
        border-bottom: 2px solid #3498db;
        text-transform: capitalize;
        margin: 1.5rem 0;
        position: relative;
    }
    
    h4{
        width: 100%;
        text-align: center;
    }
    .grid {
        grid-template-columns: 1fr;
    }

    .chart {
        max-width: 100%;
    }

    .device-view {
    display: inline;
    }

}

</style>