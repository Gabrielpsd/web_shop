<script>
    export default{
        props:{
            number: Number,
            disable: Boolean
        },
        methods:{
            updateNumber(){
                this.$emit('atualiza',parseInt(this.inputNumber))
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
        },
        created(){
            if(this.number)
            {
                this.inputNumber = this.number
            }
            else 
                this.inputNumber = ''
        }
    }

</script>

<template>
     <label>
        <input data-slots="_" size="5" :placeholder="inputNumber" :value="inputNumber" @input="updateNumber" v-on:keydown="verificaDigito" :disabled="disable">
    </label>
</template>
