<script>
    export default{
        props:{
            number: Number
        },
        methods:{
            updateNumber(){
                this.$emit('update:number',parseInt(this.inputNumber))
                this.$emit('atualiza')
            },
            verificaDigito(key) {
                if(key.code == "Tab")
                    return

                if(key.code == "Backspace" ||  !isNaN(parseInt(key.key)))
                {
                    if(key.code=="Backspace")
                    {
                        this.inputNumber = parseInt(this.inputNumber/10)
                    }
                    else
                    {
                        this.inputNumber = parseInt((this.inputNumber*10)+parseInt(key.key))
                    }
                    this.updateNumber()
                }

                if([37,38,39,40].indexOf(key.key) != -1)
                {
                    return
                }

                key.preventDefault()
                key.stopPropagation()
            },
        },
        data(){
            return{
                inputNumber: this.number
            }
        }
    }

</script>

<template>
     <label>
        <input data-slots="_" size="5" :placeholder="inputNumber" :value="inputNumber" @input="updateNumber" v-on:keydown="verificaDigito">
    </label>
</template>

<style scoped></style>