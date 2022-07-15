<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Fiche devis client</h5>

            <div class="d-flex justify-content-between">
                <router-link to="/devis/client/nouveau" class="btn btn-secondary me-2"><i class="fa fa-plus me-2"></i>Nouveau</router-link>
                <router-link v-if="!Devis.loading.value" :to="{ name: 'devis.client.modifier', params: { id: Devis.entity.value.id }}" class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/devis/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <VoirDevisComponent v-if="!Devis.loading.value" :devis="Devis.entity.value" />
            <VoirDevisLoadingComponent v-else />
        </div>
    </div>
</template>

<script>

import { onBeforeMount } from 'vue'
import VoirDevisComponent from '../../../components/devis/VoirDevisComponent.vue'
import useCRUD from '../../../services/CRUDServices'
import router from '../../../router/router'
import VoirDevisLoadingComponent from '../../../components/devis/VoirDevisLoadingComponent.vue'

const Devis = useCRUD('/commandes')

export default {
    components: {
        VoirDevisComponent,
        VoirDevisLoadingComponent
    },

    setup() {
        onBeforeMount(async () => {
            const id = router.currentRoute.value.params.id
            await Devis.find(id)
        })

        return {
            Devis,
        }
    }

}

</script>
