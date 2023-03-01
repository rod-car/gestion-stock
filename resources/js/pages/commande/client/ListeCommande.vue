<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste de commande client</h5>
                    <router-link to="/commande/client/nouveau" class="btn btn-primary"><i
                            class="fa fa-plus me-2"></i>Nouvelle commande</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeCommandeComponent v-if="!loading" :appro="appro" :entities="entities" />
                <ListeCommandeLoadingComponent v-else />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, onBeforeMount, ref } from 'vue';
import ListeCommandeComponent from '../../../components/commande/ListeCommandeComponent.vue';
import ListeCommandeLoadingComponent from '../../../components/commande/ListeCommandeLoadingComponent.vue';
import useCRUD from '../../../services/CRUDServices';

const { entities, loading, all } = useCRUD('/commandes')

export default defineComponent({
    components: {
        ListeCommandeComponent,
        ListeCommandeLoadingComponent
    },

    setup() {
        const appro = ref(false)

        onBeforeMount(async () => {
            await all(2, null, appro.value) // Recuperer tous les commandes de clients
        })

        return {
            entities, loading, appro,
        }
    },

})
</script>
