<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 v-if="!loading" class="text-info">Modifier le commande fournisseur N° {{ entity.numero }}</h5>
                    <Skeletor v-else height="35" width="40%" style="border-radius: 3px" />
                    <router-link to="/commande/fournisseur/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des commande fournisseur</router-link>
                </div>
            </div>

            <div class="card-body">
                <BonReceptionFormComponent v-if="!loading" :nouveau="false" :appro="true" :commande="entity" />
                <BonReceptionFormLoadingComponent v-else />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, onBeforeMount } from 'vue';
import router from '../../router/router';
import useCRUD from '../../services/CRUDServices';
import { Skeletor } from 'vue-skeletor';
import BonReceptionFormComponent from '../../components/bon-reception/BonReceptionFormComponent.vue';
import BonReceptionFormLoadingComponent from '../../components/bon-reception/BonReceptionFormLoadingComponent.vue';

const { find, loading, entity } = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Commande

export default defineComponent({
    components: {
        Skeletor,
        BonReceptionFormComponent,
        BonReceptionFormLoadingComponent
    },

    setup() {
        onBeforeMount(async () => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id);
        })

        return {
            loading, entity,
        }
    }
});
</script>
