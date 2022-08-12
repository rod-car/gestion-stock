<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Modifier la catégorie de fournisseur</h5>
            <router-link to="/fournisseur/categorie/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des catégories</router-link>
        </div>
        <div class="card-body">
            <CategorieFormLoadingComponent v-if="loading" />
            <CategorieFormComponent v-else :nouveau="false" :categorie="entity" :type="2" />
        </div>
    </div>
</template>

<script lang="ts">

import router from '../../../router/router';
import { onBeforeMount } from 'vue';
import useCRUD from '../../../services/CRUDServices';
import CategorieFormComponent from '../../../components/categorie/CategorieFormComponent.vue';
import CategorieFormLoadingComponent from '../../../components/categorie/CategorieFormLoadingComponent.vue';

const { find, loading, entity } = useCRUD('/categorie');

export default {
    setup() {
        onBeforeMount(async (): Promise<any> => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id);
        })

        return {
            loading, find, entity,
        }
    },

    components: {
        CategorieFormComponent, CategorieFormLoadingComponent,
    },

}
</script>
