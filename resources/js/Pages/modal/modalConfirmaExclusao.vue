<script>
export default{
  methods:{
    retornaModal(arg){
      this.$emit('respostaModal',arg)
    }
  }
}
</script>

<template>
 <!-- Modal -->
<div class="modal fade show modal-dialog-centered " tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Deletar o registro ?</h1>
      </div>
      <div class="modal-body">
        Deseja deletar o registro atual
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="retornaModal(false)">Cancelar deleção</button>
        <button type="button" class="btn btn-primary" @click="retornaModal(true)">Excluir registro</button>
      </div>
    </div>
  </div>
</div>
   
</template>