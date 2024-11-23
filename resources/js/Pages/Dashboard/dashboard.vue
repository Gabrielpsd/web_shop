<script>
import Layout from '../shared/Layout.vue'
import rotas from '../Assets/ConfigFiles/apiconfig'
import barChart from './graficos/barChart.vue';
import piChart from './graficos/piChart.vue';

export default {
    layout: Layout,
    components:{
        barChart,
        piChart
    },
    data(){
        return{
            vendasPorSexo: {labels: [], data:[], carregado: false, colors: []},
            pessoasPorIdade: {labels: [], data:[], carregado: false, colors: []},
            produtosPorMarca: {labels: [], data:[], carregado: false, colors: []}
        }
    }, 
    methods:{
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
        listaVendasPorSexo(){
            const csrfToken = document.getElementsByName("_token")[0].value
            let obj = this
            var request = new XMLHttpRequest()
            request.open('GET',rotas.dashboard.vendasPorSexo,true)
            request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
            request.onload = function(){
                if(this.readyState == XMLHttpRequest.DONE)
                    if(this.status == 200)
                    {
                        let page = JSON.parse(this.responseText)
                        page.forEach(element => {
                            obj.vendasPorSexo.data.push(element.quantidade)
                            obj.vendasPorSexo.colors.push(obj.geraCor())
                            obj.vendasPorSexo.labels.push(element.sexo)
                        });
                        obj.vendasPorSexo.carregado = true
                    }
            } 

            request.send()
        },
        listaPessoasPorIdade(){
            const csrfToken = document.getElementsByName("_token")[0].value
            let obj = this
            var request = new XMLHttpRequest()
            request.open('GET',rotas.dashboard.pessoasPorIdade,true)
            request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
            request.onload = function(){
                if(this.readyState == XMLHttpRequest.DONE)
                    if(this.status == 200)
                    {
                        let page = JSON.parse(this.responseText)
                        page.forEach(element => {
                            obj.pessoasPorIdade.data.push(element.quantidade)
                            obj.pessoasPorIdade.labels.push(element.idade)
                            obj.pessoasPorIdade.colors.push(obj.geraCor())
                        });
                        obj.pessoasPorIdade.carregado = true
                    }
            } 

            request.send()
        },
        produtosPorMarcaFun(){
            const csrfToken = document.getElementsByName("_token")[0].value
            let obj = this
            var request = new XMLHttpRequest()
            request.open('GET',rotas.dashboard.produtospormarca,true)
            request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
            request.onload = function(){
                if(this.readyState == XMLHttpRequest.DONE)
                    if(this.status == 200)
                    {
                        let page = JSON.parse(this.responseText)
                        page.forEach(element => {
                            console.log(element)
                            obj.produtosPorMarca.data.push(element.quantidade)
                            obj.produtosPorMarca.labels.push(element.descricao)
                            obj.produtosPorMarca.colors.push(obj.geraCor())
                        });

                        obj.produtosPorMarca.carregado = true
                    }
            } 

            request.send()
        }
    },
    created(){
        this.listaVendasPorSexo()
        this.listaPessoasPorIdade()
        this.produtosPorMarcaFun()
    }
}

</script>

<template>
    <div class="grid">
        <div class="chart">
            <barChart 
                :Label="'Vendas por sexo'"
                :Colors="vendasPorSexo.colors" 
                :data="vendasPorSexo.data" 
                :labels="vendasPorSexo.labels" 
                v-if="vendasPorSexo.carregado">
            </barChart>
        </div>
        <div class="chart">
            <barChart 
                :Label="'Pessoas por idade'"
                :data="pessoasPorIdade.data" 
                :labels="pessoasPorIdade.labels" 
                :Colors="pessoasPorIdade.colors" 
                v-if="pessoasPorIdade.carregado">
            </barChart>
        </div>
        <div class="chart">
            <h6>Vendas por Cliente</h6>
            <div>
                <piChart 
                    :Label="'Produtos por marca'"
                    :data="produtosPorMarca.data" 
                    :labels="produtosPorMarca.labels" 
                    :Colors="produtosPorMarca.colors" 
                    v-if="produtosPorMarca.carregado">
                </piChart>
            </div>
        </div>
    </div>

</template>

<style scoped>
    .chart{
        width: 250;
        height: 250;
    }
    .grid{
        display: flex;
        justify-content: space-between;
    }
</style>