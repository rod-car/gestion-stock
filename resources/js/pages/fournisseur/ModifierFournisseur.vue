<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Modifier le fournisseur</h5>
            <router-link to="/fournisseur/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des fournisseurs</router-link>
        </div>
        <div class="card-body">
            <FournisseurFormComponent v-if="!Fournisseur.loading.value" :nouveau="false" :fournisseur="Fournisseur.entity.value" />
            <FournisseurFormLoadingComponent v-else />
        </div>
    </div>
</template>

<script>

import { onMounted } from 'vue';
import FournisseurFormComponent from '../../components/fournisseur/FournisseurFormComponent.vue';
import FournisseurFormLoadingComponent from '../../components/fournisseur/FournisseurFormLoadingComponent.vue';
import router from '../../router/router';
import useCRUD from '../../services/CRUDServices';

const Fournisseur = useCRUD('fournisseur')

export default {
    setup() {
        onMounted(async () => {
            const id = router.currentRoute.value.params.id;
            await Fournisseur.find(id);
        })

        return {
            Fournisseur,
        }
    },

    components: {
        FournisseurFormComponent,
        FournisseurFormLoadingComponent
    },

}
</script>
