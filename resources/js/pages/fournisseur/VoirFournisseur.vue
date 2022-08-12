<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Fiche fournisseur</h5>

            <div class="d-flex justify-content-between">
                <router-link to="/fournisseur/nouveau" class="btn btn-secondary me-2"><i class="fa fa-plus me-2"></i>Nouveau</router-link>
                <router-link v-if="!loading && entity.id" :to="{ name: 'fournisseur.modifier', params: { id: entity.id }}" class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/fournisseur/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <VoirFournisseurLoadingComponent v-if="loading" />
            <VoirFournisseurComponent v-else :fournisseur="entity" />
        </div>
    </div>
</template>

<script lang="ts">

import ProfileAvatar from 'vue-profile-avatar'
import VoirFournisseurLoadingComponent from '../../components/fournisseur/VoirFournisseurLoadingComponent.vue';
import VoirFournisseurComponent from '../../components/fournisseur/VoirFournisseurComponent.vue';
import useCRUD from '../../services/CRUDServices';
import { defineComponent, onBeforeMount } from 'vue';
import router from '../../router/router';

const { loading, entity, find } = useCRUD('/fournisseur');

export default defineComponent({
    setup() {
        onBeforeMount(async (): Promise<any> => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id);
        })

        return {
            loading, entity,
        }
    },

    components: {
        ProfileAvatar,
        VoirFournisseurLoadingComponent,
        VoirFournisseurComponent
    },

});
</script>
