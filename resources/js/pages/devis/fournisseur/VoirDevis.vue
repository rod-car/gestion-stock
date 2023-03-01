<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Fiche devis fournisseur</h5>

            <div class="d-flex justify-content-between">
                <router-link title="Créer un bon de commande pour ce devis" v-if="parseInt(entity.status) === 1"
                    :to="{ name: `commande.fournisseur.nouveau`, query: { devis: entity.id } }"
                    class="btn btn-success btn-sm me-2 ">Passer une commande</router-link>
                <router-link to="/devis/fournisseur/nouveau" class="btn btn-secondary me-2"><i
                        class="fa fa-plus me-2"></i>Nouveau devis</router-link>
                <router-link v-if="!loading" :to="{ name: 'devis.fournisseur.modifier', params: { id: entity.id } }"
                    class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/devis/fournisseur/liste" class="btn btn-primary"><i
                        class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <VoirDevisComponent v-if="!loading" :devis="entity" :appro="true" />
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

const { find, loading, entity } = useCRUD('/commandes')

export default {
    components: {
        VoirDevisComponent,
        VoirDevisLoadingComponent
    },

    setup() {
        onBeforeMount(async (): Promise<any> => {
            const id = parseInt(router.currentRoute.value.params.id.toString())
            await find(id)
        })

        return {
            entity, loading,
        }
    }

}

</script>
