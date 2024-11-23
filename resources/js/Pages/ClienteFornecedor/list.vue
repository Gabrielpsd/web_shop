<script>
import Layout from '../shared/Layout.vue'
import pessoaCard from '../cartoes/pessoaCard.vue'
import adicionar from '../ClienteFornecedor/adicionar.vue'
import CpfCNPJinput from '../utils/CpfCNPJinput.vue';
import { readUsedSize } from 'chart.js/helpers';
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
        CpfCNPJinput,
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
                return ((item.cpf_cnpj+'').toLowerCase().indexOf(this.cpf_cnpj.toLowerCase()) > -1)     
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
        <h4>Filtros</h4>
            <input v-model="id_lancamento" placeholder="ID lancamento" />
            <div>
                CPF_CNPJ
                <CpfCNPJinput @atualiza="(arg)=>this.cpf_cnpj = arg"></CpfCNPJinput>
            </div>
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
    pessoaCard {
        margin: 1px;
    }
    .grid{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        margin: 0 auto;
        padding: 10px;
        width: 80%;
    }
    .filtros{
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        margin: 10px;
    }
    .chart{
        height: 50vh;
        width: 15vw;
    }
    .chartArea{
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        margin: 20px;
    }

</style>