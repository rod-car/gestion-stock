<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste des devis client</h5>
                    <router-link to="/devis/client/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Créer un nouveau dévis client</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeDevisComponent v-if="!Devis.loading.value" :entities="Devis.entities.value" :appro="false" />
                <ListeDevisLoadingComponent v-else />
            </div>
        </div>
    </div>
</template>

<script>

import { onMounted } from 'vue';
import ListeDevisComponent from '../../../components/devis/ListeDevisComponent.vue';
import ListeDevisLoadingComponent from '../../../components/devis/ListeDevisLoadingComponent.vue';
import useCRUD from '../../../services/CRUDServices';

const Devis = useCRUD('/commandes')

export default {
    components: {
        ListeDevisComponent, ListeDevisLoadingComponent,
    },

    setup() {
        onMounted(() => {
            Devis.getEntities({ type: 1, appro: false }) // Recuperer les deviss
        })

        return {
            Devis,
        }
    },

}
</script>
