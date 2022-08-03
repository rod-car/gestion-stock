<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Nouveau catégorie d'article</h5>
            <router-link to="/article/categorie/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des catégories</router-link>
        </div>
        <div class="card-body">
            <CategorieFormComponent :nouveau="true" :type="3" />
        </div>
    </div>
</template>

<script lang="ts">
import CategorieFormComponent from '../../../components/categorie/CategorieFormComponent.vue';
import { defineComponent } from 'vue';

export default defineComponent({

    components: {
        CategorieFormComponent
    },

})

</script>
