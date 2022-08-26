<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Bon de reception</h5>

            <div class="d-flex justify-content-between">
                <router-link to="/bon-reception/nouveau" class="btn btn-secondary me-2"><i class="fa fa-plus me-2"></i>Nouvelle</router-link>
                <router-link v-if="!loading && entity.id" :to="{ name: 'bon-reception.modifier', params: { id: entity.id }}" class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/bon-reception/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <VoirBonReceptionComponent v-if="!loading" :bon-reception="entity" />
            <VoirBonReceptionLoadingComponent v-else />
        </div>
    </div>
</template>

<script lang="ts">

import { onBeforeMount } from 'vue';
import router from '../../router/router';
import useCRUD from '../../services/CRUDServices';
import VoirBonReceptionComponent from '../../components/bon-reception/VoirBonReceptionComponent.vue';
import VoirBonReceptionLoadingComponent from '../../components/bon-reception/VoirBonReceptionLoadingComponent.vue';

const { loading, find, entity } = useCRUD('/bon-receptions');

export default {
    setup() {

        onBeforeMount(async () => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id)
        })

        return {
            loading, entity,
        }
    },

    components: {
        VoirBonReceptionComponent,
        VoirBonReceptionLoadingComponent
    },

}
</script>

