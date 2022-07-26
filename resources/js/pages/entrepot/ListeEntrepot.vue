<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste d'entrepôt</h5>
                    <router-link to="/entrepot/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Ajouter un nouveau</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeDepotLoadingComponent v-if="loading" />
                <ListeDepotComponent v-else :depots="entities" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">

import useCRUD from '../../services/CRUDServices';
import ListeDepotComponent from '../../components/depot/ListeDepotComponent.vue';
import ListeDepotLoadingComponent from '../../components/depot/ListeDepotLoadingComponent.vue';
import { defineComponent, onMounted } from 'vue';

const { entities, loading, all } = useCRUD('/depot')

export default defineComponent({
    components: {
        ListeDepotComponent, ListeDepotLoadingComponent
    },

    setup() {
        onMounted(async (): Promise<any> => {
            await all(2);
        })

        return {
            entities, loading, all,
        }
    },

});

</script>
