<script>
    export default{
        props:{
            number: Number
        },
        data(){
            return{
                inputNumber: this.formataParaBrasil(this.number)
            }
        },
        methods:{
            formataParaBrasil(number){
                number  = parseFloat(number)
                let numeroFormatado =  new Intl
                    .NumberFormat(
                        'pt-BR',
                        {minimumFractionDigits: 2})
                    .format(number)           
                return numeroFormatado
            },

        }
     
    }

</script>

<template>
     <label>
        <input size="5" :placeholder="inputNumber" disabled>
    </label>
</template>

<style scoped></style>