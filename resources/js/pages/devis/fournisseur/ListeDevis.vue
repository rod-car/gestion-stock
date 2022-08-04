<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste des devis fournisseur</h5>
                    <router-link to="/devis/fournisseur/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Créer un nouveau dévis fournisseur</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeDevisLoadingComponent v-if="loading" />
                <ListeDevisComponent v-else :entities="entities" :appro="true" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">

import { defineComponent, onBeforeMount } from 'vue';
import ListeDevisComponent from '../../../components/devis/ListeDevisComponent.vue';
import ListeDevisLoadingComponent from '../../../components/devis/ListeDevisLoadingComponent.vue';
import useCRUD from '../../../services/CRUDServices';

const { loading, entities, all } = useCRUD('/commandes')

export default defineComponent({
    components: {
        ListeDevisComponent, ListeDevisLoadingComponent,
    },

    setup() {
        onBeforeMount(async (): Promise<any> => {
            await all(1, null, true) // Recuperer les deviss
        })

        return {
            loading, entities,
        }
    },

})
</script>
