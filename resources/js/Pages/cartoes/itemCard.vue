
<script>
import inputIntNumber from '../utils/inputIntNumber.vue';
import inputFloatNumber from '../utils/inputFloatNumber.vue';
import inputFloatNumberDisable from '../utils/inputFloatNumberDisable.vue'

export default{
    name: "Item",
    props: {
        produto: Object
    },
    components:{
        inputIntNumber,
        inputFloatNumber,
        inputFloatNumberDisable
    },
    data(){
        return{
            descricao: this.produto.descricao,
            preco: this.produto.preco,
            quantidade: this.produto.quantidade,
            precoTotal: 0,
        }
    },
    created(){
        this.atualizaPrecoTotal()
    },
    methods:{
        atualizaPreco(args){
            this.preco = args
            this.atualizaPrecoTotal()
            this.$emit('update:preco',this.preco)
            this.$emit('modificacao',this.produto.id)
        },
        atualizaQuantidade(args){
            if(isNaN(this.quantidade) || !this.quantidade)
            {
                this.quantidade = 0
            }
            
            this.quantidade = args
            this.atualizaPrecoTotal()
            this.$emit('update:quantidade',this.quantidade)
            this.$emit('modificacao',this.produto.id)
           
        },
        atualizaPrecoTotal(){
            let resultado = (parseFloat(this.preco) * parseInt(this.quantidade)) + ''
            this.precoTotal = resultado
        },
    },
}
</script>   

<template>
    <div class="outside">
        <div class="fw-bold "></div>   
            <div class="d-flex justify-content-between">
            <div class="rounded border border-secondary padding" >
                Quantidade:
                <inputIntNumber :number="quantidade" @atualiza="(args)=>atualizaQuantidade(args)"></inputIntNumber>
            </div> 
            <div class="rounded border border-secondary padding" >
                Preço:
                <div>
                    R$  
                    <inputFloatNumber :number="preco" @atualiza="(args)=>atualizaPreco(args)"></inputFloatNumber>
                </div>
            </div>
            <div class="rounded border border-secondary padding" > 
                Total:
                <div>
                    <inputFloatNumberDisable :number="precoTotal" :key="precoTotal"></inputFloatNumberDisable>
                </div>
            </div>
        </div>
        
    </div>
    
</template>

<style scoped>
    .flex{
        padding: 2px;
        margin: 2px;
    }
    .padding{
        padding: 3px;
        margin: 3px;
        display: flex;
        flex-direction: column;
        border-radius: 10px;
        justify-content: center;
        align-items: center;
    }
    h5{
        text-align: justify;
    }
    .outside{
        display: flex;
        flex-direction: row;
    }
</style>