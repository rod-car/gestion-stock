<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Fiche commande client</h5>

            <div class="d-flex justify-content-between">
                <router-link
                    :to="{ name: 'bon-livraison.nouveau', query: { commande: entity.id }}"
                    title='Créer un bon de livraison a partir de ce bon de commande'
                    v-if="!entity.recu" class="btn btn-success me-2">
                    <i class="fa fa-arrow-right me-2"></i>
                    Convertir en bon de livraison
                </router-link>
                <router-link to="/commande/client/nouveau" class="btn btn-secondary me-2"><i class="fa fa-plus me-2"></i>Nouvelle</router-link>
                <router-link v-if="!loading && entity.id" :to="{ name: 'commande.client.modifier', params: { id: entity.id }}" class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/commande/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <VoirCommandeComponent v-if="!loading" :appro="false" :commande="entity" />
            <VoirCommandeLoadingComponent v-else />
        </div>
    </div>
</template>

<script lang="ts">
import { onBeforeMount } from 'vue';
import router from '../../../router/router';
import useCRUD from '../../../services/CRUDServices';
import VoirCommandeComponent from '../../../components/commande/VoirCommandeComponent.vue';
import VoirCommandeLoadingComponent from '../../../components/commande/VoirCommandeLoadingComponent.vue';

const { find, loading, entity } = useCRUD('/commandes');

export default {
    setup() {

        onBeforeMount(async () => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id)
        })

        return {
            entity, loading,
        }
    },

    components: {
        VoirCommandeComponent,
        VoirCommandeLoadingComponent
    },

}
</script>

