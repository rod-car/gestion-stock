<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Modifier la catégorie de article</h5>
            <router-link to="/article/categorie/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des catégories</router-link>
        </div>
        <div class="card-body">
            <CategorieFormLoadingComponent v-if="loading" :hasSub="true" />
            <CategorieFormComponent v-else :nouveau="false" :type="3" :categorie="entity" />
        </div>
    </div>
</template>

<script lang="ts">
import useCRUD from '../../../services/CRUDServices';
import CategorieFormLoadingComponent from '../../../components/categorie/CategorieFormLoadingComponent.vue';
import CategorieFormComponent from '../../../components/categorie/CategorieFormComponent.vue';
import { onBeforeMount } from 'vue';
import router from '../../../router/router';

const { loading, entity, find } = useCRUD('/categorie');

export default {
    setup() {
        onBeforeMount(async (): Promise<any> => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id);
        })

        return {
            loading, entity,
        }
    },

    components: {
        CategorieFormLoadingComponent,
        CategorieFormComponent
    },

}
</script>
