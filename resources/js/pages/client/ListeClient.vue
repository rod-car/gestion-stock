<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste des clients</h5>
                    <router-link to="/client/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Ajouter un nouveau</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeClientLoadingComponent v-if="loading" />
                <ListeClientComponent v-else :clients="entities" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">

import useCRUD from '../../services/CRUDServices';
import { defineComponent, onBeforeMount } from 'vue';
import ListeClientComponent from '../../components/client/ListeClientComponent.vue';
import ListeClientLoadingComponent from '../../components/client/ListeClientLoadingComponent.vue';

const { loading, entities, all } = useCRUD("/client")

export default defineComponent({
    setup() {
        onBeforeMount(async () => {
            await all(1);
        });

        return {
            loading, entities,
        };
    },
    components: { ListeClientComponent, ListeClientLoadingComponent }
});

</script>
