<script>

export default{

}

</script>

<template>
    <button @click="voltar" class="btn-close"></button>
    <h2>Mesa {{NumeroMesa}}</h2>
    <div class="pedidos rounded border border-secondary ">
        <div class="dadosPedido">
            <h3>Cliente:</h3>
            <p>{{ cliente }}</p>
            <h3>Garcom</h3>
            <p>{{ garcom }}</p>
            <h3>TotalPedido</h3>
            <p> R$ - {{ precoPedidos(pedidos) }}</p>
        </div>
        <div class="ListaProdutos">
            <div class="rounded border border-secondary menu"> 
                Adicionar Item 
                <button type="button" class="btn btn-secondary btn-sm" @click=" modificacao = !modificacao">Adicionar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                    </svg>
                </button>
            </div>
            <ol class="list-group list-group-numbered">
                <li class="list-group-item d-flex justify-content-between align-items-start" v-for=" pedido in pedidos">
                    <div class="ms-2 me-auto">
                    <div class="fw-bold"> {{ pedido.item }}</div>
                    <div class="d-flex justify-content-between">
                            <div class="rounded border border-secondary" style="margin: 3px; padding: 3px;">
                                Quantidade = {{pedido.quantidade}}
                            </div> 
                            <div class="rounded border border-secondary" style="margin: 3px;padding: 3px;">
                                Preço Un: R$ {{pedido.preco}} 
                            </div>
                            <div class="rounded border border-secondary " style="margin: 3px;padding: 3px;"> 
                                Preco total = R${{ pedido.preco * pedido.quantidade }}
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm">Editar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" @click="removeItem(pedido.id)">Remover <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                    </button>
                </li>
            </ol>
            <div class="salvaAlteracoes">
                <button type="button" class="btn btn-secondary" v-if="modificacao" disabled>Salvar Alterações 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                    </svg>
                </button>
                <button type="button" class="btn btn-secondary" v-if="!modificacao">Salvar Alterações
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .pedidos{
        display: flex;
        justify-content: space-between;
        padding: 50px;
        margin: 10px;
    }
    h2{
        text-align: center;
        margin-top: 30PX;
        margin-bottom: 30PX;
    }
    .menu{
        margin: 3px;
        display: flex;
        justify-content: space-between;
        padding: 3px;
    }
    .salvaAlteracoes{
        padding: 5px;
        margin: 5px;
    }
</style>