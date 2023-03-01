<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 v-if="!loading" class="text-info">Modifier le devis N° {{ entity.numero }}</h5>
                    <Skeletor v-else height="35" width="40%" style="border-radius: 3px" />
                    <router-link to="/devis/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste
                        des devis</router-link>
                </div>
            </div>

            <div class="card-body">
                <DevisFormComponent v-if="!loading" :nouveau="false" :appro="false" :devis="entity" />
                <DevisFormLoadingComponent v-else />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { Skeletor } from 'vue-skeletor';
import useCRUD from '../../../services/CRUDServices';
import DevisFormComponent from '../../../components/devis/DevisFormComponent.vue';
import DevisFormLoadingComponent from '../../../components/devis/DevisFormLoadingComponent.vue';

import { onBeforeMount } from 'vue';
import router from '../../../router/router';

const { find, loading, entity } = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Devis

export default {
    components: {
        DevisFormComponent, DevisFormLoadingComponent, Skeletor,
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
