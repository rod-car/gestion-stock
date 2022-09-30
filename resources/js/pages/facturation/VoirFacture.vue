<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Facture N° {{ entity.numero_facture }}</h5>

            <div class="d-flex justify-content-between">
                <router-link to="/facture/liste" class="btn btn-info me-2 text-white"><i class="fa fa-print me-2"></i>Imprimer</router-link>
                <router-link v-if="!loading && entity.id" :to="{ name: 'facture.modifier', params: { id: entity.id }}" class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/facture/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <VoirFactureComponent v-if="!loading" :facture="entity" />
            <VoirFactureLoadingComponent v-else />
        </div>
    </div>
</template>

<script lang="ts">

import { onBeforeMount } from 'vue';
import router from '../../router/router';
import useCRUD from '../../services/CRUDServices';
import VoirFactureComponent from '../../components/facturation/VoirFactureComponent.vue';
import VoirFactureLoadingComponent from '../../components/facturation/VoirFactureLoadingComponent.vue';

const { loading, find, entity } = useCRUD('/factures');

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
        VoirFactureComponent,
        VoirFactureLoadingComponent
    },

}
</script>

