<script>
import Layout from '../shared/Layout.vue'
import rotas from '../Assets/ConfigFiles/apiconfig'
import CpfCNPJinput from '../utils/CpfCNPJinput.vue';
import inputIntNumber from '../utils/inputIntNumber.vue'

export default{
    layout: Layout,
    data(){
        return{
            nome: '',
            fornecedor: false,
            edicaoInativa: true,
            tamanhoNomeInvalido: false,
            cpf_cnpj: '',
            cpfInvalido: false,
            sexo: 0,
            dataNascimento: new Date('01/01/1900').toLocaleDateString('pt-BR', {timeZone: 'UTC'}),
          }
    },
    components:{
        CpfCNPJinput,
        inputIntNumber
    },
    methods: {
        salvaAlteracoes(){
            if(this.validacoes())
            {

                /* let obj = this
                const csrfToken = document.getElementsByName("_token")[0].value
                var request = new XMLHttpRequest()
                
                let pessoa = JSON.stringify({'descricao':this.nome, 
                                            'fornecedor': this.fornecedor,
                                            'cpf_cnpj': this.cpf_cnpj,
                                            'data_nascimento': this.dataNascimento,
                                            'sexo': this.sexo})
                request.open('POST',rotas.pessoas.inserirPessoa,true)
                request.setRequestHeader("Content-Type","application/json")
                request.setRequestHeader('X-CSRF-TOKEN',csrfToken)
                
                request.onload = function(){
                    if(this.readyState == XMLHttpRequest.DONE)
                        if(this.status == 200)
                        {
                            obj.$emit('adicionar',JSON.parse(this.responseText))
                        }
                } 

                request.send(pessoa)

                this.cancelaAdicao()
 */             

            } 

        },
        validacoes()
        {   
            console.log("IDade", this.dataNascimento)
            let retorno = true
            this.cpfInvalido = false
            this.tamanhoNomeInvalido = false

            if(this.nome.length <= 3)
            {
                this.tamanhoNomeInvalido = true
                retorno = false
            }

            if(isNaN(parseInt(this.idade)))
            {
                this.idadeInvalida = true
                retorno =  false
            }

            if(this.sexo === '0')
            {
                this.sexoInvalido = true
                retorno =  false
            }
            
            if(this.cpf_cnpj.length != 14 && this.cpf_cnpj.length != 11)
            {
                this.cpfInvalido = true
                retorno = false
            }

            return retorno 
        },

        cancelaAdicao(){
            this.nome = ''
            this.fornecedor = false
            this.edicaoInativa = true,
            this.tamanhoNomeInvalido = false
            this.cpf_cnpj = ''
        },
        atualizaCPFCNPJ(valor)
        {
            this.cpf_cnpj = valor
        },
        ChangeDate()
        {
            let aux = this.dataNascimento.split('-')
            this.dataNascimento = `${aux[2]}-${aux[1]}-${aux[0]}`
            console.log(`${aux[2]}-${aux[1]}-${aux[0]}`)
            console.log(this.dataNascimento)
        }
    },
}
</script>

<template>
   <div class="card border-dark mb-3" style="max-width: 18rem;" >
        <div class="card-header spacing">
            <button  class="btn btn-primary"  @click="edicaoInativa = false"v-if="edicaoInativa">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                </svg>
                Inserir Cadastro
            </button>
            <button  class="btn btn-success" @click="salvaAlteracoes()" v-if="!edicaoInativa">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                    <path d="M11 2H9v3h2z"/>
                    <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                </svg>
                Salvar
            </button>
            <button  class="btn btn-danger" @click="cancelaAdicao()" v-if="!edicaoInativa">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
                Cancelar
            </button>
        </div>
        <div class="card-body text-dark" >
            <h5 class="card-title"><input type="checkbox" v-bind:disabled="edicaoInativa" v-model="fornecedor">Fornecedor</h5>
            <h5 class="card-title">Nome<input type="text" class="form-control" v-bind:readonly="edicaoInativa" v-model="nome" :class="{campoInvalido: tamanhoNomeInvalido}"></h5>
            <div>
                <h6>Sexo</h6>
                <select v-model="sexo" :disabled="edicaoInativa">
                    <option disabled value="0">Selecione um sexo</option>
                    <option :value="'M'">Masculino</option>
                    <option :value="'F'">Feminino</option>
                </select>
                <h5>CPF/CNPJ</h5>
                <CpfCNPJinput :disable="edicaoInativa" :number="this.cpf" @atualiza="(arg)=>this.cpf_cnpj = arg"></CpfCNPJinput>
                    <label for="">Data nascimento</label>
                    <input class="input-model" type="date"  @input="ChangeDate" v-model="dataNascimento">
                </div> 
        </div>
        <ul v-if="tamanhoNomeInvalido">
            <li v-if="tamanhoNomeInvalido">Nome deve conter no minimo 3 caracteres</li>
            <li v-if="cpfInvalido">CFP/CNPJ incompleto</li>
            <li v-if="idadeInvalida">Idade inválida</li>
            <li v-if="sexoInvalido">Selecione o sexo do cliente</li>
        </ul>
    </div>
</template>

<style scoped>
    ul{
        color: red;
    }
    .campoInvalido{
        border-color: red;
    }
    .input-model{
        width: 100%;
    }
</style>