<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Fiche devis client</h5>

            <div class="d-flex justify-content-between">
                <router-link title="Créer un bon de commande pour ce devis"
                    v-if="entity.status === 1"
                    :to="{ name: `commande.client.nouveau`, query: { devis: entity.id }}"
                    class="btn btn-success me-2"><i class="fa fa-arrow-right me-2"></i>
                    Convertir en bon de commande
                </router-link>
                <router-link to="/devis/client/nouveau" class="btn btn-secondary me-2"><i class="fa fa-plus me-2"></i>Nouveau</router-link>
                <router-link v-if="!loading" :to="{ name: 'devis.client.modifier', params: { id: entity.id }}" class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/devis/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <VoirDevisComponent v-if="!loading" :devis="entity" />
            <VoirDevisLoadingComponent v-else />
        </div>
    </div>
</template>

<script lang="ts">

import { onBeforeMount } from 'vue'
import router from '../../../router/router'
import useCRUD from '../../../services/CRUDServices'
import VoirDevisComponent from '../../../components/devis/VoirDevisComponent.vue'
import VoirDevisLoadingComponent from '../../../components/devis/VoirDevisLoadingComponent.vue'

const { loading, entity, find } = useCRUD('/commandes')

export default {
    components: {
        VoirDevisComponent,
        VoirDevisLoadingComponent
    },

    setup() {
        onBeforeMount(async () => {
            const id = parseInt(router.currentRoute.value.params.id.toString())
            await find(id)
        })

        return {
            loading, entity,
        }
    }

}

</script>
