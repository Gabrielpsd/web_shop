
<script>
    export default {
        props: {
            produto: Object
        }
    }
</script>

<template>
    <div class="card border-dark mb-3" style="max-width: 18rem;" >
        <div class="card-header spacing">
            Produto {{ produto.id }}
            <button  class="btn btn-secondary"  @click="liberaEdicao()"v-if="edicaoInativa">Editar Produto</button>
            <button  class="btn btn-primary" @click="salvaAlteracoes()" v-if="!edicaoInativa">Salvar</button>
        </div>
        <div class="card-body text-dark">
            <h5 class="card-title">Descricao<input type="text" class="form-control"  v-bind:readonly="edicaoInativa" v-model="descricao"></h5>
            <p class="card-text">Preço: <input type="number" min="1" step="any" class="form-control" v-bind:readonly="edicaoInativa" v-model="preco"></p>
        </div>
    </div>
</template>