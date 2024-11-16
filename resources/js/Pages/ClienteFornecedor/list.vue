<script>
import Layout from '../shared/Layout.vue'
import pessoaCard from '../cartoes/pessoaCard.vue'
import adicionar from '../ClienteFornecedor/adicionar.vue'

export default {
    layout: Layout,
    props: {
        ClienteFornecedor: Array
    },
    components:{
        pessoaCard,
        adicionar
    },
    data(){
        return{
            pessoasData: this.ClienteFornecedor,
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
        }
    }
}
</script>

<template>
    <div >
        <div class="grid">
            <adicionar @adicionar="(arg)=>adicionarPessoa(arg)"></adicionar>
            <pessoaCard :pessoa='pessoa' v-for="pessoa in pessoasData" @deletaPessoa="(arg)=>deletaPessoa(arg)" ></pessoaCard>
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