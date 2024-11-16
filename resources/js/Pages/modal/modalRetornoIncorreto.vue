<script>
export default{
  props: {
    mensagem: Object
  },
  methods:{
    retorno(){
      this.$emit('fechaModal')
    }
  },

}
</script>

<template>
 <!-- Modal -->
<div class="modal fade show modal-dialog-centered " tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> {{ this.mensagem.titulo }}</h1>
      </div>
      <div class="modal-body">
        {{this.mensagem.mensagem}}
      </div>
      <div class="modal-footer">
        <button type="button" @click="retorno" class="btn btn-primary">Retornar</button>
      </div>
    </div>
  </div>
</div>
   
</template>