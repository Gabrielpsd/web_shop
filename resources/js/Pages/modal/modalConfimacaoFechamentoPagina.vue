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
        <h1 class="modal-title fs-5" id="exampleModalLabel">Sair sem salvar  ? </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Existem alterções para serem salvas. Todo o progresso será perdido.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="retornaModal(0)">Continuar editando pedido</button>
        <button type="button" class="btn btn-primary" @click="retornaModal(1)">Sair sem salvar</button>
      </div>
    </div>
  </div>
</div>
   
</template>