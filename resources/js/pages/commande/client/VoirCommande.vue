<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Fiche commande client</h5>

            <div class="d-flex justify-content-between">
                <router-link to="/commande/client/nouveau" class="btn btn-secondary me-2"><i class="fa fa-plus me-2"></i>Nouvelle</router-link>
                <router-link v-if="!Commande.loading.value && Commande.entity.value.id" :to="{ name: 'commande.client.modifier', params: { id: Commande.entity.value.id }}" class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/commande/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <VoirCommandeComponent v-if="!Commande.loading.value" :appro="false" :commande="Commande.entity.value" />
            <VoirCommandeLoadingComponent v-else />
        </div>
    </div>
</template>

<script>

import { onBeforeMount } from 'vue';
import router from '../../../router/router';
import useCRUD from '../../../services/CRUDServices.ts';
import VoirCommandeComponent from '../../../components/commande/VoirCommandeComponent.vue';
import VoirCommandeLoadingComponent from '../../../components/commande/VoirCommandeLoadingComponent.vue';

const Commande = useCRUD('/commandes');

export default {
    setup() {

        onBeforeMount(async () => {
            const id = parseInt(router.currentRoute.value.params.id);
            await Commande.find(id)
        })

        return {
            Commande,
        }
    },

    components: {
        VoirCommandeComponent,
        VoirCommandeLoadingComponent
    },

}
</script>

