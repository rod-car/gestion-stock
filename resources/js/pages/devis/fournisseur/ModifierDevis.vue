<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 v-if="!Devis.loading.value" class="text-info">Modifier le dévis N° {{ Devis.entity.value.numero }}</h5>
                    <Skeletor v-else height="35" width="40%" style="border-radius: 3px" />
                    <router-link to="/devis/fournisseur/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des deviss</router-link>
                </div>
            </div>

            <div class="card-body">
                <DevisFormComponent v-if="!Devis.loading.value" :nouveau="false" :devis="Devis.entity.value" />
                <DevisFormLoadingComponent v-else />
            </div>
        </div>
    </div>
</template>

<script>

import useCRUD from '../../../services/CRUDServices';
import DevisFormComponent from '../../../components/devis/DevisFormComponent.vue';
import DevisFormLoadingComponent from '../../../components/devis/DevisFormLoadingComponent.vue';
import { Skeletor } from 'vue-skeletor';

import { onBeforeMount } from 'vue';
import router from '../../../router/router';

const Devis = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Devis

export default {
    components: {
        DevisFormComponent, DevisFormLoadingComponent, Skeletor,
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
