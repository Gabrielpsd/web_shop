<script>
import Layout from '../shared/Layout.vue'
import entradaCard from '../cartoes/itemEntradaCard.vue'
import adiciona from './adiciona.vue'
import barChart from '../Dashboard/graficos/barChart.vue';
import piChart from '../Dashboard/graficos/piChart.vue';
import GraficoDonut from '../Dashboard/graficos/graficoDonut.vue';
import config from '../Assets/ConfigFiles/apiconfig'

export default {
    layout: Layout,
    props: {
        Entradas: Array,
        Fornecedores: Array,
        Produtos: Array
    },
    components:{
        entradaCard,
        adiciona,
        barChart,
        piChart,
        GraficoDonut
    },
    data(){
        return{
        entradas : this.Entradas,
        fornecedor: '',
        id_lancamento: '',
        id_fornecedor:'',
        data_inicial: new Date('01/01/1900').toLocaleDateString('pt-BR', {timeZone: 'UTC'}),
        data_final: new Date('12/31/2100').toLocaleDateString('pt-BR', {timeZone: 'UTC'}),
        itemsFiltrados: [],
        dadosGraficoComprasPorData: {labels: [], data:[], carregado: false, colors: [],key:0},
        dadosGraficoTotalComprasPorFornecedor: {labels: [], data:[], carregado: false, colors: [],key:0},
        dadosGraficoTotalQuantidadeComprasPorFornecedor: {labels: [], data:[], carregado: false, colors: [],key:0},
            
        }
    },
    methods: {
        excluiRegistro(id){
            this.entradas = this.entradas.filter((item)=>item.id != id)
        }
    },
    watch:{
        itemsFiltrados()
        {
            this.dadosGraficoComprasPorData= {labels: [], data:[], carregado: false, colors: [],key:this.dadosGraficoComprasPorData.key + 1 }
            this.dadosGraficoTotalComprasPorFornecedor= {labels: [], data:[], carregado: false, colors: [],key:this.dadosGraficoTotalComprasPorFornecedor.key + 1 }
            this.dadosGraficoTotalQuantidadeComprasPorFornecedor= {labels: [], data:[], carregado: false, colors: [],key:this.dadosGraficoTotalQuantidadeComprasPorFornecedor.key + 1 }

            let comprasPorData = {}
            let comprasPorFornecedor = {}
            let comprasQuantidadePorFornecedor = {}
            
            this.itemsFiltrados.forEach((element) => {
                comprasPorData[element.data_compra] = (comprasPorData[element.data_compra] || 0) + parseFloat(element.valor_total)
                comprasPorFornecedor[element.fornecedor] = (comprasPorFornecedor[element.fornecedor] || 0) + parseFloat(element.valor_total)
                comprasQuantidadePorFornecedor[element.fornecedor] = (comprasQuantidadePorFornecedor[element.fornecedor] || 0) + 1
            });

            for(let item of Object.entries(comprasPorData))
            {
                this.dadosGraficoComprasPorData.data.push(item[1])
                this.dadosGraficoComprasPorData.labels.push(item[0])
            }
            this.dadosGraficoComprasPorData.colors.push(config.geracor())

            for(let item of Object.entries(comprasPorFornecedor))
            {
                this.dadosGraficoTotalComprasPorFornecedor.data.push(item[1])
                this.dadosGraficoTotalComprasPorFornecedor.labels.push(item[0])
                this.dadosGraficoTotalComprasPorFornecedor.colors.push(config.geracor())
            }

            for(let item of Object.entries(comprasQuantidadePorFornecedor))
            {
                this.dadosGraficoTotalQuantidadeComprasPorFornecedor.data.push(item[1])
                this.dadosGraficoTotalQuantidadeComprasPorFornecedor.labels.push(item[0])
                this.dadosGraficoTotalQuantidadeComprasPorFornecedor.colors.push(config.geracor())
            }

            this.dadosGraficoTotalQuantidadeComprasPorFornecedor.carregado = true
            this.dadosGraficoTotalComprasPorFornecedor.carregado = true
            this.dadosGraficoComprasPorData.carregado = true
        }
    },
    computed:{
        filtraBusca: function(){
            let items =  this.Entradas.filter((item)=>{
                console.log(item)
                return ((item.id+'').toLowerCase().indexOf(this.id_lancamento) > -1) 
            })
            .filter((item)=>{
                return ((item.id_fornecedor+'').toLowerCase().indexOf(this.id_fornecedor.toLowerCase()) > -1)     
            })
            .filter((item)=>{
                return ((item.fornecedor+'').toLowerCase().indexOf(this.fornecedor.toLowerCase()) > -1)     
            })
            .filter((item)=>{
                let data = new Date(item.data_compra).toLocaleDateString('pt-BR', {timeZone: 'UTC'})
                return (data <= this.data_final)
            })
            .filter((item)=>{
                let data = new Date(item.data_compra).toLocaleDateString('pt-BR', {timeZone: 'UTC'})
                return ( data >= this.data_inicial)
            })

            this.itemsFiltrados = items

            return items
        }
    }, 
}
</script>

<template>
    <div >
        <div class="filtros">
            <h4>Filtros</h4>
            <input v-model="id_lancamento" placeholder="ID lancamento" />
            <input v-model="id_fornecedor" placeholder="ID fornecedor" />
            <input v-model="fornecedor" placeholder="Fornecedor" />
            <div>
                <label for="">Data inicial</label>
                <input type="text" :value="this.data_inicial" :disabled="true"/>
                <input type="date" class="date" @input="(arg)=>this.data_inicial = new Date(arg.explicitOriginalTarget.value).toLocaleDateString('pt-BR', {timeZone: 'UTC'})">
            </div>
            <div>
                <label for="">Data final</label>
                <input type="text" :value="this.data_final" :disabled="true"/>
                <input type="date" class="date" @input="(arg)=>this.data_final = new Date(arg.explicitOriginalTarget.value).toLocaleDateString('pt-BR', {timeZone: 'UTC'})">
            </div>
        </div>
        <div class="chartArea">
            <div class="chart">
                <piChart 
                    :Label="'Total por fornecedor'"
                    :data="dadosGraficoTotalComprasPorFornecedor.data" 
                    :labels="dadosGraficoTotalComprasPorFornecedor.labels" 
                    :Colors="dadosGraficoTotalComprasPorFornecedor.colors" 
                    v-if="dadosGraficoTotalComprasPorFornecedor.carregado"
                    :key="dadosGraficoTotalComprasPorFornecedor.key"
                    >
                </piChart>
            </div>
            <div class="chart">
                <barChart 
                    :Label="'Compras por data'"
                    :data="dadosGraficoComprasPorData.data" 
                    :labels="dadosGraficoComprasPorData.labels" 
                    :Colors="dadosGraficoComprasPorData.colors" 
                    v-if="dadosGraficoComprasPorData.carregado"
                    :key="dadosGraficoComprasPorData.key">
                </barChart>
            </div>
            <div class="chart">
                <GraficoDonut 
                    :Label="'Quantidade por fornecedor'"
                    :data="dadosGraficoTotalQuantidadeComprasPorFornecedor.data" 
                    :labels="dadosGraficoTotalQuantidadeComprasPorFornecedor.labels" 
                    :Colors="dadosGraficoTotalQuantidadeComprasPorFornecedor.colors" 
                    v-if="dadosGraficoTotalQuantidadeComprasPorFornecedor.carregado"
                    :key="dadosGraficoTotalQuantidadeComprasPorFornecedor.key">
                </GraficoDonut>
            </div>
        </div>
        <div class="grid">
            <adiciona :Fornecedores="Fornecedores"></adiciona>
            <entradaCard :entrada='entrada' v-for="entrada in filtraBusca" @exclui="(data)=>excluiRegistro(data)" :key="entrada.id"></entradaCard>
        </div>
    </div>
</template>

<style scoped>
    .grid{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        margin: 0 auto;
        width: 80%;
    }
    .filtros{
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        margin: 10px;
    }
    .date{
        height: 30px;
        width: 30px;
    }
    .chart{
        height: 200px;
        width: 25%;
    }
    .chartArea{
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        margin: 20px;
        max-width: 100%;
    }
</style>