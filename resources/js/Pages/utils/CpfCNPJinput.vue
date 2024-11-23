<script>
    export default{
        props:{
            disable: Boolean,
            number: Number
        },  
        data(){
            return{
                inputNumber: this.formataParaBrasil(this.number)
            }
        },
        methods:{
            formataParaBrasil(number){
                if(number == undefined)
                    return ''
                number  = number + ''
                number  = number.replace('.','').replace('-','').replace('/','')
                
                let numeroFormatado = ''
                this.$emit('atualiza',number)
                
                if(number.length <= 3)
                {
                    numeroFormatado = number.replace(/^([0-9]{3})/,'$1')
                    return numeroFormatado
                }

                if(number.length <= 6)
                {
                    numeroFormatado = number.replace(/^([0-9]{3})([0-9]{3})$/,'$1.$2')
                    return numeroFormatado
                }

                if(number.length <= 9)
                {
                    numeroFormatado = number.replace(/^([0-9]{3})([0-9]{3})([0-9]{3})/,'$1.$2.$3')
                    return numeroFormatado
                }

                if(number.length <= 11)
                {
                    numeroFormatado = number.replace(/^([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})$/,'$1.$2.$3-$4')
                    return numeroFormatado
                }

                if(number.length <= 14)
                {
                    numeroFormatado = number.replace(/^([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{2})$/,'$1.$2.$3/$4-$5')
                    return numeroFormatado
                }
            },

            verificaDigito(key) { 

                if(key.code == "Tab")
                    return

                if(parseInt(key.key) >= 0 && parseInt(key.key) <= 9)
                {   
                    let numbers = (this.inputNumber+'').replace('.','').replace('-','').replace('/','')
                    if(numbers.length < 14)
                    {   
                        numbers = numbers + key.key
                        this.inputNumber = this.formataParaBrasil(numbers)
                    }
                }

                if(key.code == 'Backspace')
                {
                    let numbers = (this.inputNumber+'').replace('.','').replace('-','').replace('/','')
                    numbers = numbers.slice(0,-1)
                    this.inputNumber = this.formataParaBrasil(numbers)
                }

                if([37,38,39,40].indexOf(key.key) != -1)
                {
                    return
                }

                key.preventDefault()
                key.stopPropagation()
            },
        }
     
    }

</script>

<template>
     <label>
        <input size="15" :placeholder="inputNumber" :value="inputNumber" v-on:keydown="verificaDigito" :disabled="disable">
    </label>
</template>
