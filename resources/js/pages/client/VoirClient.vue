<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Fiche client</h5>

            <div class="d-flex justify-content-between">
                <router-link to="/client/nouveau" class="btn btn-secondary me-2"><i class="fa fa-plus me-2"></i>Nouveau</router-link>
                <router-link v-if="!loading && entity.id" :to="{ name: 'client.modifier', params: { id: entity.id }}" class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <VoirClientLoadingComponent v-if="loading" />
            <VoirClientComponent v-else :client="entity" />
        </div>
    </div>
</template>

<script lang="ts">
import VoirClientLoadingComponent from '../../components/client/VoirClientLoadingComponent.vue';
import { defineComponent, onBeforeMount } from 'vue';
import useCRUD from '../../services/CRUDServices';
import VoirClientComponent from '../../components/client/VoirClientComponent.vue';
import router from '../../router/router';

const { entity, find, loading } = useCRUD('/client');

export default defineComponent({
    setup() {
        onBeforeMount(async (): Promise<any> => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id)
        })

        return {
            entity, find, loading,
        }
    },

    components: {
        VoirClientLoadingComponent,
        VoirClientComponent
    },

});
</script>

