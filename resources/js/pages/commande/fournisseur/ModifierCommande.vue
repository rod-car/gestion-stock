<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Modifier le commande fournisseur N° {{ Commande.entity.value.numero }}</h5>
                    <router-link to="/commande/fournisseur/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des commande fournisseur</router-link>
                </div>
            </div>

            <div class="card-body">
                <CommandeFormComponent v-if="!Commande.loading.value" :nouveau="false" :appro="true" :commande="Commande.entity.value" />
                <CommandeFormLoadingComponent v-else />
            </div>
        </div>
    </div>
</template>

<script>

import { onBeforeMount } from 'vue';
import CommandeFormComponent from '../../../components/commande/CommandeFormComponent.vue';
import CommandeFormLoadingComponent from '../../../components/commande/CommandeFormLoadingComponent.vue';
import router from '../../../router/router';
import useCRUD from '../../../services/CRUDServices';

const Commande = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Commande

export default {
    components: {
        CommandeFormComponent,
        CommandeFormLoadingComponent
    },

    setup() {
        onBeforeMount(async () => {
            const id = router.currentRoute.value.params.id;
            await Commande.find(id);
        })

        return {
            Commande,
        }
    }
}
</script>
