<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Nouvelle étiquette</h5>
            <router-link to="/parametres/etiquette/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des
                étiquettes</router-link>
        </div>
        <div class="card-body">
            <FormEtiquetteComponent :nouveau="true" type="Article"></FormEtiquetteComponent>
        </div>
    </div>
</template>
<script lang="ts">
import FormEtiquetteComponent from "../../components/etiquette/FormEtiquetteComponent.vue"
export default {
    components: {
        FormEtiquetteComponent
    }
}
</script>
