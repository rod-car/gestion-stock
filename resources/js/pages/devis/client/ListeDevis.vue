<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste des points de ventes</h5>
                    <router-link to="/devis/client/nouveau" class="btn btn-primary"><i
                            class="fa fa-plus me-2"></i>Nouveau devis</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeDevisComponent v-if="!loading" :entities="entities" :appro="false" />
                <ListeDevisLoadingComponent v-else />

            </div>
        </div>
    </div>
</template>

<script lang="ts">

import { onBeforeMount } from 'vue';
import ListeDevisComponent from '../../../components/devis/ListeDevisComponent.vue';
import ListeDevisLoadingComponent from '../../../components/devis/ListeDevisLoadingComponent.vue';
import useCRUD from '../../../services/CRUDServices';

const { all, entities, loading } = useCRUD('/commandes')

export default {
    components: {
        ListeDevisComponent, ListeDevisLoadingComponent,
    },

    setup() {
        onBeforeMount(async (): Promise<any> => {
            await all(1, null, false) // Recuperer les deviss
        })

        return {
            all, loading, entities,
        }
    },

}
</script>
