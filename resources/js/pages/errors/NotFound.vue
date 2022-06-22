<template>
    <div class="d-flex justify-content-center align-items-center h-full">
        <div>
            <h1 class="text-uppercase status-code text-muted">404</h1>
            <h3 class="text-uppercase text-muted text-center status-text mb-4">Page introuvable</h3>
            <span class="text-center text-muted">La page que vous voulez acceder n'existe pas, <router-link to="/" class="link">Revenir a l'accueil</router-link></span>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>

.status-code {
    font-size: 200px;
}

.status-text {
    font-size: 30px;
}

</style>
