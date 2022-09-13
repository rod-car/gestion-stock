<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouvelle commande client</h5>
                    <router-link to="/commande/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste de commande client</router-link>
                </div>
            </div>

            <div class="card-body">
                <CommandeFormLoadingComponent v-if="loading" />
                <CommandeFormComponent v-else :appro="false" :nouveau="true" :devis="entity" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import router from '../../../router/router';
import { defineComponent, onBeforeMount, ref, Ref } from 'vue';
import CommandeFormComponent from '../../../components/commande/CommandeFormComponent.vue';
import CommandeFormLoadingComponent from '../../../components/commande/CommandeFormLoadingComponent.vue';
import useCRUD from '../../../services/CRUDServices';

const { find, entity, loading } = useCRUD('/commandes')

export default defineComponent({
    components: {
        CommandeFormComponent, CommandeFormLoadingComponent
    },

    setup() {
        const devisId: Ref<number | null> = ref(null);

        onBeforeMount(async (): Promise<any> => {
            const id = router.currentRoute.value.query.devis;

            if (id !== undefined && id !== null) {
                devisId.value = parseInt(id.toString());
            } else {
                devisId.value = null;
            }

            if (devisId.value !== null) {
                // Recuperer le devis en question
                await find(devisId.value);
            }
        })

        return { entity, loading }
    }
});
</script>
