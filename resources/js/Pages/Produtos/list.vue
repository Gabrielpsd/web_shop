<script>
import Layout from '../shared/Layout.vue'
import produtoCard from '../cartoes/produtoCard.vue'
import adiciona from './adiciona.vue'
import { readUsedSize } from 'chart.js/helpers';
import GraficoDonut from '../Dashboard/graficos/graficoDonut.vue';
import rotas from '../Assets/ConfigFiles/apiconfig'

export default {
    layout: Layout,
    props: {
        Produtos: Array,
        Fornecedores: Array,
        Marcas: Array
    },
    components:{
        produtoCard,
        adiciona,
        GraficoDonut
    },
    data(){
        return{
            produtos: this.Produtos,
            fornecedor:0,
            marca:0,
            id_lancamento:'',
            descricao:'',
            status: '0',
            key: 1,
            itemsFiltrados: [],
            dadosGraficoProdutosPorMarca: {labels: [], data:[], carregado: false, colors: [],key:0},
            dadosGraficoProdutosPorFornecedores: {labels: [], data:[], carregado: false, colors: [],key:0},
            dadosGraficoVendasInativosEAtivos: {labels: [], data:[], carregado: false, colors: [],key:0}
            
        }
    },
    computed:{
        filtraBusca: function(){
            let items =  this.produtos.filter((item)=>{
                return ((item.id+'').toLowerCase().indexOf(this.id_lancamento) > -1) 
            }).filter((item)=>{
                return ((item.descricao+'').toLowerCase().indexOf(this.descricao.toLowerCase()) > -1)     
            }).filter((item)=>{
                if(this.marca == '' || this.marca==0 )
                    return true

                return (item.id_marca == this.marca)     
            }).filter((item)=>{
                if(this.fornecedor == '' || this.fornecedor==0 )
                    return true

                return (item.id_fornecedor == this.fornecedor)     
            }).filter((item)=>{
                if(this.status === 0 || this.status === '0')
                    return true
                return(item.ativo == this.status)
            })

            this.itemsFiltrados = items
            
            return items
        }
    },  
    methods:{
        inserirProduto(produto){
            this.produtos.push(produto)
        },
        removerProduto(idProduto){
            this.produtos = this.produtos.filter((item)=>item.id != idProduto)
        },
        montaGrafico(){

            this.dadosGraficoProdutosPorMarca = {labels: [], data:[], colors: [], carregado: false, key: this.dadosGraficoProdutosPorMarca.key + 1}
            this.dadosGraficoProdutosPorFornecedores = {labels: [], data:[], colors: [],carregado: false, key: this.dadosGraficoProdutosPorFornecedores.key + 1}
            this.dadosGraficoVendasInativosEAtivos = {labels: [], data:[], colors: [],carregado: false, key: this.dadosGraficoVendasInativosEAtivos.key + 1}
            
            let totalPorMarca = {}
            let totalPorFornecedor = {}
            let totalAtivoEInativo = {}

            this.itemsFiltrados.forEach((element)=>{
                totalPorMarca[element.marca] = (totalPorMarca[element.marca] || 0) + 1
                totalPorFornecedor[element.fornecedor] = (totalPorFornecedor[element.fornecedor] || 0) + 1
                totalAtivoEInativo[element.ativo] = (totalAtivoEInativo[element.ativo] || 0) + 1
            })

            for(let item of Object.entries(totalPorMarca))
            {
                this.dadosGraficoProdutosPorMarca.data.push(item[1])
                this.dadosGraficoProdutosPorMarca.labels.push(item[0])
                this.dadosGraficoProdutosPorMarca.colors.push(rotas.geracor())
            }

            for(let item of Object.entries(totalPorFornecedor))
            {
                this.dadosGraficoProdutosPorFornecedores.data.push(item[1])
                this.dadosGraficoProdutosPorFornecedores.labels.push(item[0])
                this.dadosGraficoProdutosPorFornecedores.colors.push(rotas.geracor())
            }

            for(let item of Object.entries(totalAtivoEInativo))
            {
                this.dadosGraficoVendasInativosEAtivos.data.push(item[1])
                this.dadosGraficoVendasInativosEAtivos.labels.push(item[0])
                this.dadosGraficoVendasInativosEAtivos.colors.push(rotas.geracor())
            }

            this.dadosGraficoProdutosPorFornecedores.carregado = true
            this.dadosGraficoProdutosPorMarca.carregado = true
            this.dadosGraficoVendasInativosEAtivos.carregado = true
        }
    },
    watch:{
        itemsFiltrados()
        {
            this.montaGrafico() 
        }    
    }

}
</script>

<template>
    <div>
        <div class="filtros">
            <h3 class="device-view"> Produtos </h3>
            <h4>Filtros</h4>
            <input v-model="id_lancamento" placeholder="ID lancamento" />
            <input v-model="descricao" placeholder="Descricao" />
                <select v-model="fornecedor">
                    <option  value="0">Fornecedor</option>
                    <option v-for="fornecedor in this.Fornecedores" :value="fornecedor.id">{{fornecedor.descricao}}</option>
                </select>
                <select v-model="marca">
                    <option  value="0">Marca</option>
                    <option v-for="marca in this.Marcas" :value="marca.id">{{marca.descricao}}</option>
                </select>
                <select v-model="status">
                    <option  value="0">Status</option>
                    <option  :value="false">Inativos</option>
                    <option  :value="true">Ativos</option>
                </select>
        </div>
        <div class="chartArea">
            <div class="chart">
                <GraficoDonut 
                    :Label="'Produtos Inativos VS ativos'"
                    :data="dadosGraficoVendasInativosEAtivos.data" 
                    :labels="dadosGraficoVendasInativosEAtivos.labels" 
                    :Colors="dadosGraficoVendasInativosEAtivos.colors" 
                    v-if="dadosGraficoVendasInativosEAtivos.carregado"
                    :key="dadosGraficoVendasInativosEAtivos.key">
                </GraficoDonut>
            </div>
            <div class="chart">
                <GraficoDonut 
                    :Label="'Quantidade por fornecedor'"
                    :data="dadosGraficoProdutosPorFornecedores.data" 
                    :labels="dadosGraficoProdutosPorFornecedores.labels" 
                    :Colors="dadosGraficoProdutosPorFornecedores.colors" 
                    v-if="dadosGraficoProdutosPorFornecedores.carregado"
                    :key="dadosGraficoProdutosPorFornecedores.key">
                </GraficoDonut>
            </div>
            <div class="chart">
                <GraficoDonut 
                    :Label="'Quantidade por marca'"
                    :data="dadosGraficoProdutosPorMarca.data" 
                    :labels="dadosGraficoProdutosPorMarca.labels" 
                    :Colors="dadosGraficoProdutosPorMarca.colors" 
                    v-if="dadosGraficoProdutosPorMarca.carregado"
                    :key="dadosGraficoProdutosPorMarca.key">
                </GraficoDonut>
            </div>
        </div>
        <div class="grid">
            <adiciona :Fornecedores="Fornecedores" :Marcas="Marcas" @adicionar="(produto)=>inserirProduto(produto)" ></adiciona>
            <produtoCard  :Fornecedores="Fornecedores" :Marcas="Marcas" :produto='produto' v-for="produto in filtraBusca" @removerProduto="(idProduto)=>removerProduto(idProduto)" :key="produto.id"></produtoCard>
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

.computer-view {
    display: inline;
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

    .computer-view {
        display: none;
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

    .computer-view {
        display: none;
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

</style>