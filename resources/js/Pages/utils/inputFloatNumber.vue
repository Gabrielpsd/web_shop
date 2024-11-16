<script>
    export default{
        props:{
            number: {
                required: true
            }
        },
        data(){
            return{
                inputNumber: new Intl
                    .NumberFormat(
                        'pt-BR',
                        {minimumFractionDigits: 2})
                    .format(this.number)
            }
        },
        methods:{
            updateNumber(number){
                this.$emit('update:number',number)
                this.$emit('atualiza')
            },
        
            formataParaBrasil(number){
                number  = number + ''
                number  = parseFloat(number.replace('.','').replace(',','.'))

                this.updateNumber(number)
                /*formata o numero para o padrão brasileiro */ 
                let numeroFormatado =  new Intl
                    .NumberFormat(
                        'pt-BR',
                        {minimumFractionDigits: 2})
                    .format(number)

                return numeroFormatado
            },

            verificaDigito(key) { 

                if(key.code == "Tab")
                    return

                if(parseInt(key.key) >= 0 && parseInt(key.key) <= 9)
                {   
                    let numbers = (this.inputNumber+'').split(',')
                    numbers = numbers[0]+numbers[1].charAt(0) + ',' + numbers[1].charAt(1) + key.key
                    this.inputNumber = this.formataParaBrasil(numbers)
                }

                if(key.code == 'Backspace')
                {
                    key.preventDefault()

                    if(parseFloat((this.inputNumber).replace(/[\.,]/,'')) <= 0.00)
                    {
                        return
                    } 

                    /* divide a strin entre parte inteira e centavos depois remonta a string */ 
                    let number = (this.inputNumber + '').split(',')
                    if(number[0].length <= 1)
                        number = '0' + ',' + number[0].slice(-1) + number[1].charAt(0)
                    else
                        number = number[0].slice(0,-1) + ',' + number[0].slice(-1) + number[1].charAt(0)
                    
                    this.inputNumber = this.formataParaBrasil(number)
                    return
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
        <input size="5" :placeholder="inputNumber" :value="inputNumber" @input="updateNumber" v-on:keydown="verificaDigito">
    </label>
</template>
