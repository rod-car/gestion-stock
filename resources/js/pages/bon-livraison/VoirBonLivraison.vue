<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Bon de livraison</h5>

            <div class="d-flex justify-content-between">
                <router-link to="/bon-livraison/nouveau" class="btn btn-secondary me-2"><i class="fa fa-plus me-2"></i>Nouvelle</router-link>
                <router-link v-if="!loading && entity.id" :to="{ name: 'bon-livraison.modifier', params: { id: entity.id }}" class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/bon-livraison/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <VoirBonLivraisonComponent v-if="!loading" :bon-livraison="entity" />
            <VoirBonLivraisonLoadingComponent v-else />
        </div>
    </div>
</template>

<script lang="ts">

import { onBeforeMount } from 'vue';
import router from '../../router/router';
import useCRUD from '../../services/CRUDServices';
import VoirBonLivraisonComponent from '../../components/bon-livraison/VoirBonLivraisonComponent.vue';
import VoirBonLivraisonLoadingComponent from '../../components/bon-livraison/VoirBonLivraisonLoadingComponent.vue';

const { loading, find, entity } = useCRUD('/bon-livraisons');

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
        VoirBonLivraisonComponent,
        VoirBonLivraisonLoadingComponent
    },

}
</script>

