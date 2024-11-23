<script>
import Layout from '../shared/Layout.vue'
import pedidoCard from '../cartoes/pedidoCard.vue'
import adiciona from './adiciona.vue'
import barChart from '../Dashboard/graficos/barChart.vue';
import piChart from '../Dashboard/graficos/piChart.vue';
import GraficoDonut from '../Dashboard/graficos/graficoDonut.vue';

export default {
    layout: Layout,
    props: {
        Pedidos: Array,
        Clientes: Array
    },
    components:{
        pedidoCard,
        adiciona,
        barChart,
        piChart,
        GraficoDonut
    },
    
    computed:{
        filtraBusca: function(){
            let items =  this.pedidos.filter((item)=>{
                return ((item.id+'').toLowerCase().indexOf(this.id_lancamento) > -1) 
            })
            .filter((item)=>{
                return ((item.id_cliente+'').toLowerCase().indexOf(this.id_cliente.toLowerCase()) > -1)     
            })
            .filter((item)=>{
                return ((item.cliente+'').toLowerCase().indexOf(this.cliente.toLowerCase()) > -1)     
            })
            .filter((item)=>{
                let data = new Date(item.data_venda).toLocaleDateString('pt-BR', {timeZone: 'UTC'})
                return ( data >= this.data_inicial)
            })
            .filter((item)=>{
                let data = new Date(item.data_venda).toLocaleDateString('pt-BR', {timeZone: 'UTC'})
                return (data <= this.data_final)
            })
            .filter((item)=>{
                if(this.sexo == '0')
                    return true
                return (item.sexo == this.sexo)
            })

            this.dadosGrafico = items

            return items
        }

    },  
    data(){
        return{
            pedidos: this.Pedidos,
            id_cliente: '',
            cliente: '',
            id_lancamento: '',
            data_inicial: new Date('01/01/1900').toLocaleDateString('pt-BR', {timeZone: 'UTC'}),
            data_final: new Date('12/31/2100').toLocaleDateString('pt-BR', {timeZone: 'UTC'}),
            dadosGrafico: '',
            dadosGraficoVenda: {labels: [], data:[], carregado: false, colors: [],key:0},
            dadosGraficoVendasPorData: {labels: [], data:[], carregado: false, colors: [],key:0},
            dadosGraficoVendasPorSexo: {labels: [], data:[], carregado: false, colors: [],key:0},
            sexo: 0
        }
    },
    watch:{
        dadosGrafico()
        {
            this.carregaGraficos()
        }
    },
    mounted(){
        this.carregaGraficos()
    },
    methods:{
        excluiRegistro(id){
            console.log("Vou excluir")
            this.pedidos = this.pedidos.filter((data)=>data.id != id)
        },
        geraCor(){
            // Storing all letter and digit combinations 
            // for html color code 
            let letters = "0123456789ABCDEF"; 
            
            // HTML color code starts with # 
            let color = '#'; 
                
            // Generating 6 times as HTML color code  
            // consist of 6 letter or digits 
            for (let i = 0; i < 6; i++) 
                color += letters[(Math.floor(Math.random() * 16))]; 

            return color
        },
        carregaGraficos()  {
            
            
            this.dadosGraficoVenda = {labels: [], data:[], colors: [], carregado: false, key: this.dadosGraficoVenda.key + 1}
            this.dadosGraficoVendasPorData = {labels: [], data:[], colors: [],carregado: false, key: this.dadosGraficoVendasPorData.key + 1}
            this.dadosGraficoVendasPorSexo = {labels: [], data:[], colors: [],carregado: false, key: this.dadosGraficoVendasPorData.key + 1}
            
            if(this.dadosGrafico.length == 0 )
                return 
            
            let totalPorData = {}
            let totalPorCliente = {}
            let totalPorSexo = {}

            /* cria um objeto agrupado onde a chave do objeto tornase a data */ 
            /* no segundo cria um objeto agrupado onde a chave do objeto tornase o cliente */ 
            this.dadosGrafico.forEach((element)=>{
                totalPorData[element.data_venda] = (totalPorData[element.data_venda] || 0) + parseFloat(element.valor_total)
                totalPorCliente[element.cliente] = (totalPorCliente[element.cliente] || 0) + parseFloat(element.valor_total)
                totalPorSexo[element.sexo] = (totalPorSexo[element.sexo] || 0) + parseFloat(element.valor_total)
            })

            /* transformamos esse objeto em um array onde cada elemento é um cojunto valor entre a chave do objeto 
            e o valor somado */ 

            for(let item of Object.entries(totalPorData))
            {
                this.dadosGraficoVendasPorData.data.push(item[1])
                this.dadosGraficoVendasPorData.labels.push(item[0])
            }
            this.dadosGraficoVendasPorData.colors.push(this.geraCor())

            for(let item of Object.entries(totalPorCliente))
            {
                this.dadosGraficoVenda.data.push(item[1])
                this.dadosGraficoVenda.labels.push(item[0])
                this.dadosGraficoVenda.colors.push(this.geraCor())
            }

            for(let item of Object.entries(totalPorSexo))
            {
                this.dadosGraficoVendasPorSexo.data.push(item[1])
                this.dadosGraficoVendasPorSexo.labels.push(item[0])
                this.dadosGraficoVendasPorSexo.colors.push(this.geraCor())
            }

            this.dadosGraficoVenda.carregado = true
            this.dadosGraficoVendasPorData.carregado = true
            this.dadosGraficoVendasPorSexo.carregado = true
        }
    },
}
</script>

<template>
    <div >
        <div class="filtros">
            <input v-model="id_lancamento" placeholder="ID lancamento" />
            <input v-model="id_cliente" placeholder="ID cliente" />
            <input v-model="cliente" placeholder="Cliente" />
            <select v-model="sexo">
                <option  :value="'0'">Sexo</option>
                <option  :value="'M'">Masculino</option>
                <option  :value="'F'">Feminino</option>
            </select>
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
                    :Label="'Vendas por Pessoa'"
                    :data="dadosGraficoVenda.data" 
                    :labels="dadosGraficoVenda.labels" 
                    :Colors="dadosGraficoVenda.colors" 
                    v-if="dadosGraficoVenda.carregado"
                    :key="dadosGraficoVenda.key"
                    >
                </piChart>
            </div>
            <div class="chart">
                <barChart 
                    :Label="'Total por data'"
                    :data="dadosGraficoVendasPorData.data" 
                    :labels="dadosGraficoVendasPorData.labels" 
                    :Colors="dadosGraficoVendasPorData.colors" 
                    v-if="dadosGraficoVendasPorData.carregado"
                    :key="dadosGraficoVendasPorData.key">
                </barChart>
            </div>
            <div class="chart">
                <GraficoDonut 
                    :Label="'Total por sexo'"
                    :data="dadosGraficoVendasPorSexo.data" 
                    :labels="dadosGraficoVendasPorSexo.labels" 
                    :Colors="dadosGraficoVendasPorSexo.colors" 
                    v-if="dadosGraficoVendasPorSexo.carregado"
                    :key="dadosGraficoVendasPorSexo.key">
                </GraficoDonut>
            </div>
        </div>
        <div class="grid">
            <adiciona :Clientes="Clientes"></adiciona>
            <pedidoCard :pedido='pedido' v-for="pedido in filtraBusca"  @exclui="(data)=>excluiRegistro(data)" :key="pedido.id"></pedidoCard>
        </div>
    </div>
</template>

<style scoped>
    pedidoCard{
        margin: 1px;
    }
    .grid{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        margin: 0 auto;
        width: 80%;
        padding: 20px;
    }
    .filtros{
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        max-height: 40px;
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