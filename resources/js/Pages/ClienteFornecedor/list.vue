<script>
import Layout from '../shared/Layout.vue'
import pessoaCard from '../cartoes/pessoaCard.vue'
import adicionar from '../ClienteFornecedor/adicionar.vue'
import piChart from '../Dashboard/graficos/piChart.vue';
import GraficoDonut from '../Dashboard/graficos/graficoDonut.vue';
import rotas from '../Assets/ConfigFiles/apiconfig'

export default {
    layout: Layout,
    props: {
        ClienteFornecedor: Array
    },
    components:{
        pessoaCard,
        adicionar,
        piChart,
        GraficoDonut
    },
    data(){
        return{
            pessoasData: this.ClienteFornecedor,
            fornecedor: '0',
            descricao: '',
            sexo: '0',
            cpf_cnpj: '',
            idade: 0,
            id_cliente: 0,
            id_lancamento: '',
            key: 1,
            listaFiltrada: [],
            dadosGraficoPessoasPorSexo: {labels: [], data:[], carregado: false, colors: [],key:0},
            dadosGraficoPessoasPorIdade: {labels: [], data:[], carregado: false, colors: [],key:0},
            
        }
    },
    methods:{
        adicionarPessoa(pessoa)
        {
            this.pessoasData.push(pessoa)

        },
        deletaPessoa(arg)
        {
            this.pessoasData = this.pessoasData.filter((pessoa)=>pessoa.id != arg)
        },
        geraGraficos(){

            this.dadosGraficoPessoasPorSexo={labels: [], data:[], carregado: false, colors: [],key:0}
            this.dadosGraficoPessoasPorIdade={labels: [], data:[], carregado: false, colors: [],key:0}
            
            let  filtroPorSexo  = {}
            let  filtroPorIdade  = {}

            this.listaFiltrada.forEach((element)=>{
                filtroPorSexo[element.sexo] = (filtroPorSexo[element.sexo] || 0) + 1
                filtroPorIdade[element.idade] = (filtroPorIdade[element.idade] || 0) + 1
            })

            for(let item of Object.entries(filtroPorSexo))
            {
                this.dadosGraficoPessoasPorSexo.data.push(item[1])
                this.dadosGraficoPessoasPorSexo.labels.push(item[0])
                this.dadosGraficoPessoasPorSexo.colors.push(rotas.geracor())
            }

            for(let item of Object.entries(filtroPorIdade))
            {
                this.dadosGraficoPessoasPorIdade.data.push(item[1])
                this.dadosGraficoPessoasPorIdade.labels.push(item[0])
                this.dadosGraficoPessoasPorIdade.colors.push(rotas.geracor())
            }

            this.dadosGraficoPessoasPorIdade.carregado = true
            this.dadosGraficoPessoasPorSexo.carregado = true
        }
    },
    computed:{
        filtraBusca: function(){
            let items =  this.pessoasData.filter((item)=>{
                return ((item.id+'').toLowerCase().indexOf(this.id_lancamento) > -1) 
            }).filter((item)=>{
                return ((item.descricao+'').toLowerCase().indexOf(this.descricao.toLowerCase()) > -1)     
            })
            .filter((item)=>{
                return ((item.cpf_cnpj+'').toLowerCase().indexOf(this.cpf_cnpj.toLowerCase().replace(/\D/g,'')) > -1)     
            }).filter((item)=>{
                if(this.fornecedor === '0' )
                    return true
                return (item.fornecedor == this.fornecedor)     
            }).filter((item)=>{
                if(this.sexo == '0')
                    return true
                return (item.sexo == this.sexo)
            })

            this.listaFiltrada = items 

           return items
        }
    }, 
    watch: {
        listaFiltrada()
        {
            this.geraGraficos()
        }
    }
}
</script>

<template>
    <div >
        <div class="filtros">
        <h3 class="device-view"> Clientes e fornecedores</h3>
        <h4>Filtros</h4>
            <input v-model="id_lancamento" placeholder="ID lancamento" />
            <input v-model="cpf_cnpj" v-mask="['###.###.###-##', '##.###.###/####-##']" placeholder="CPF ou CNPJ" />
            <input v-model="descricao" placeholder="Nome" />
            <select v-model="sexo">
                <option  :value="'0'">Sexo</option>
                <option  :value="'M'">Masculino</option>
                <option  :value="'F'">Feminino</option>
            </select>
            <select v-model="fornecedor">
                <option  value="0">Cliente / Fornecedor</option>
                <option  :value="false">Cliente</option>
                <option  :value="true">Fornecedor</option>
            </select>
        </div>
        <div class="chartArea">
            <div class="chart">
                <piChart 
                    :Label="'Total de pessoas por Idade'"
                    :data="dadosGraficoPessoasPorIdade.data" 
                    :labels="dadosGraficoPessoasPorIdade.labels" 
                    :Colors="dadosGraficoPessoasPorIdade.colors" 
                    v-if="dadosGraficoPessoasPorIdade.carregado"
                    :key="dadosGraficoPessoasPorIdade.key"
                    >
                </piChart>
            </div>
            <div class="chart">
                <GraficoDonut 
                    :Label="'Total de pessoas por sexo'"
                    :data="dadosGraficoPessoasPorSexo.data" 
                    :labels="dadosGraficoPessoasPorSexo.labels" 
                    :Colors="dadosGraficoPessoasPorSexo.colors" 
                    v-if="dadosGraficoPessoasPorSexo.carregado"
                    :key="dadosGraficoPessoasPorSexo.key">
                </GraficoDonut>
            </div>
        </div>
        <div class="grid">
            <adicionar @adicionar="(arg)=>adicionarPessoa(arg)"></adicionar>
            <pessoaCard :pessoa='pessoa' v-for="pessoa in filtraBusca" @deletaPessoa="(arg)=>deletaPessoa(arg)" :key="pessoa.id"></pessoaCard>
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

    .computer-view {
        display: none;
    }
}

</style>