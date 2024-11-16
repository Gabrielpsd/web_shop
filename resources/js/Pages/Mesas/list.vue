<script>
import Layout from '../shared/Layout.vue'
import cartoesMesa from '../cartoes/cartoesMesas.vue'

export default {
    layout: Layout,
    props: {
        Mesas: Array
    },
    components:{
        cartoesMesa
    },
}
</script>

<template>
    <div >
        <div class="tables">
            <span class="busy_dot"></span>
            <p>Mesa Oucupada</p>
            <span class="free_dot"></span>
            <p>Mesa Livre</p>
        </div>
        <div class="grid">
            <cartoesMesa :mesa='mesa' class="mesas" v-for="mesa in Mesas" ></cartoesMesa>
        </div>
    </div>
</template>

<style scoped>
    .mesas{
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