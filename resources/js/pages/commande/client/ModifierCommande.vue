<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 v-if="!loading" class="text-info">Modifier le commande client N° {{ entity.numero }}</h5>
                    <Skeletor v-else height="35" width="40%" style="border-radius: 3px" />
                    <router-link to="/commande/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des commande client</router-link>
                </div>
            </div>

            <div class="card-body">
                <CommandeFormComponent v-if="!loading" :nouveau="false" :appro="false" :commande="entity" />
                <CommandeFormLoadingComponent v-else />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, onBeforeMount } from 'vue';
import { Skeletor } from 'vue-skeletor';
import CommandeFormComponent from '../../../components/commande/CommandeFormComponent.vue';
import CommandeFormLoadingComponent from '../../../components/commande/CommandeFormLoadingComponent.vue';
import router from '../../../router/router';
import useCRUD from '../../../services/CRUDServices';

const { entity, loading, find } = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Commande

export default defineComponent({
    components: {
        CommandeFormComponent,
        CommandeFormLoadingComponent,
        Skeletor,
    },

    setup() {
        onBeforeMount(async () => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id);
        })

        return {
            entity, loading,
        }
    }
})
</script>
