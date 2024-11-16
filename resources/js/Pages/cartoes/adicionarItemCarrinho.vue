
<script>
import inputIntNumber from '../utils/inputIntNumber.vue';
import inputFloatNumber from '../utils/inputFloatNumber.vue';
import inputFloatNumberDisable from '../utils/inputFloatNumberDisable.vue'

export default{
    name: "Item",
    components:{
        inputIntNumber,
        inputFloatNumber,
        inputFloatNumberDisable,
    },
    props:{
        Produtos: Array
    },
    data(){
        return{
            preco:0,
            quantidade: 0,
            precoTotal: 0,
            itemSelecionado: '0',
            itemInvalido: false
        }
    },
    created(){
        this.atualizaPrecoTotal()
    },

    methods:{
        updateQuantidade(){
            if(isNaN(this.quantidade) || !this.quantidade)
            {
                this.quantidade = 0
            }

            this.atualizaPrecoTotal()
           
        },
        atualizaPrecoTotal(){
            
            let resultado = (parseFloat(this.preco) * parseInt(this.quantidade)) + ''
            this.precoTotal = resultado
        },
        atualizaInformacaoSelecao(){
           let indexItemSelecionado = this.Produtos.findIndex((item)=>item.id == this.itemSelecionado)
           this.preco = this.Produtos[indexItemSelecionado].preco
           this.quantidade = 1
           this.atualizaPrecoTotal()
        },
        salvar(){
            if(this.itemSelecionado == 0)
            {
                this.itemInvalido = true
                return
            }

            this.itemInvalido = false
            let objetoInserir = this.Produtos.find(item=>item.id ==this.itemSelecionado)
            objetoInserir.preco = this.preco
            objetoInserir.quantidade = this.quantidade
            this.preco=0
            this.quantidade=0
            this.precoTotal=0
            this.itemSelecionado= '0'
            /*this.$emit("update:itemInserir",objetoInserir) */

            this.$emit("insereObjeto",objetoInserir)
        }
    },
}
</script>

<template>
    <div class="d-flex justify-content-between margin">
            <h5>Adicionar Item</h5>
            <button type="button" class="btn btn-secondary btn-sm" @click="salvar" >Adicionar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
            </svg>
        </button>
    </div>
    <p v-if="itemInvalido" style="color: red;">Selecione um item valido</p>
    <select class="form-select margin" v-model="itemSelecionado" v-on:change="atualizaInformacaoSelecao" aria-label="Default select example">
        <option value="0">Selecione um item</option>
        <option v-for="produto in Produtos" :value="produto.id">{{produto.descricao}}</option>
    </select>
    <div class="outside ">
        <div class="fw-bold "></div>   
            <div class="d-flex justify-content-between">
            <div class="rounded border border-secondary padding" >
                Quantidade:
                <inputIntNumber :number="quantidade" v-model:number="quantidade" @atualiza="updateQuantidade" :key="quantidade"></inputIntNumber>
            </div> 
            <div class="rounded border border-secondary padding" >
                Preço:
                <div>
                    R$
                    <inputFloatNumber :number="preco" v-model:number="preco" :key="preco"></inputFloatNumber>
                </div>
            </div>
            <div class="rounded border border-secondary padding" > 
                Total:
                <div>
                    <inputFloatNumberDisable :number="this.precoTotal" :key="precoTotal"></inputFloatNumberDisable>
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
    .margin{
        margin: 1%;
    }
</style>