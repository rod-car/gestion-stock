<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Modifier le fournisseur</h5>
            <router-link to="/fournisseur/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des fournisseurs</router-link>
        </div>
        <div class="card-body">
            <FournisseurFormLoadingComponent v-if="loading" />
            <FournisseurFormComponent v-else :nouveau="false" :fournisseur="entity" />
        </div>
    </div>
</template>

<script lang="ts">

import { defineComponent, onBeforeMount } from 'vue';
import FournisseurFormComponent from '../../components/fournisseur/FournisseurFormComponent.vue';
import FournisseurFormLoadingComponent from '../../components/fournisseur/FournisseurFormLoadingComponent.vue';
import router from '../../router/router';
import useCRUD from '../../services/CRUDServices';

const { loading, entity, find } = useCRUD('/fournisseur')

export default defineComponent({
    setup() {
        onBeforeMount(async (): Promise<any> => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id);
        })

        return {
            entity, loading, find,
        }
    },

    components: {
        FournisseurFormComponent,
        FournisseurFormLoadingComponent
    },

});
</script>
