<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste de commande fournisseur</h5>
                    <router-link to="/commande/fournisseur/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Créer une nouvelle commande</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeCommandeComponent v-if="!Commande.loading.value" :appro="true" :entities="Commande.entities.value" />
                <ListeCommandeLoadingComponent v-else />
            </div>
        </div>
    </div>
</template>

<script>
import { onBeforeMount } from 'vue';
import ListeCommandeComponent from '../../../components/commande/ListeCommandeComponent.vue';
import ListeCommandeLoadingComponent from '../../../components/commande/ListeCommandeLoadingComponent.vue';
import useCRUD from '../../../services/CRUDServices';

const Commande = useCRUD('/commandes')

export default {
    components: {
        ListeCommandeComponent,
        ListeCommandeLoadingComponent
    },

    setup() {

        onBeforeMount(async () => {
            await Commande.all({ type: 2, appro: true }) // Recuperer tous les commandes de fournisseurs
        })

        return {
            Commande,
        }
    },

}
</script>
