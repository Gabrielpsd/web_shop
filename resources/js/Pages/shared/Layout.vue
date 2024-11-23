
<script>
    import { Link } from '@inertiajs/vue3'
    export default{
        components: {
            Link
        },
        methods: {
            isUrl(urls) {
            /* let currentUrl = this.$page.url.substr(1)
            if (urls[0] === '') {
                return currentUrl === ''
            }
            return urls.filter((url) => currentUrl.startsWith(url)).length */
            },
        },
    }
</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
        <a class="navbar-brand" href="/"><img src="../Assets/logo.png" alt="logopage" width="100" height="100" style="border-radius: 30%;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse rounded" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item">
                <Link class="nav-link" :class="isUrl('produtos') ? 'active' : '' " href="/produtos">Produtos</Link>
            </li>
            <li class="nav-item">
                <Link class="nav-link" :class="isUrl('clientefornecedor') ? 'active' : '' " href="/clientefornecedor">Cliente/fornecedores</Link>
            </li>
            <li class="nav-item">
                <Link class="nav-link" :class="isUrl('marcas') ? 'active' : '' " href="/marcas">Marcas</Link>
            </li>
            <li class="nav-item">
                <Link class="nav-link" :class="isUrl('pedidos') ? 'active' : '' " href="/pedidos">Pedidos</Link>
            </li>
            <li class="nav-item">
                <Link class="nav-link" :class="isUrl('entradas') ? 'active' : '' " href="/entradas">+ Mercadoria</Link>
            </li>
            </ul>
        </div>
    </nav>
    <div class="px-4 py-8 md:flex-1 md:p-12 md:overflow-y-auto" scroll-region>
        <slot></slot>
    </div>
</template>

<style scoped>
    *{
        padding: 10px;
    }
    nav{
        border-radius: 30px;
        margin: 10px;
    }
    .rounded
    {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    img{
        border-radius: 10%;
    }
</style>
