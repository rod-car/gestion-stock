<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouvelle facture</h5>
                    <router-link to="/facture/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des factures</router-link>
                </div>
            </div>

            <div class="card-body">
                <FactureFormLoadingComponent v-if="loading" />
                <FactureFormComponent v-else :nouveau="true" :commande="entity" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import router from '../../router/router';
import Flash from '../../functions/Flash';
import useCRUD from '../../services/CRUDServices';
import { defineComponent, onBeforeMount, ref, Ref } from 'vue';
import FactureFormComponent from '../../components/facturation/FactureFormComponent.vue';
import FactureFormLoadingComponent from '../../components/facturation/FactureFormLoadingComponent.vue';

const { entity, loading, find } = useCRUD('/commandes');

export default defineComponent({
    setup() {
        const commandeId: Ref<number | null> = ref(null);

        onBeforeMount(async (): Promise<any> => {
            const id = router.currentRoute.value.query.commande;

            if (id !== undefined && id !== null) commandeId.value = parseInt(id.toString());
            else commandeId.value = null;

            if (commandeId.value !== null) {
                // Recuperer la bon en question
                await find(commandeId.value);
                if (entity.value.type !== 2) {
                    Flash('error', 'Erreur', 'Veuillez selectionner une commande');
                    router.push('/facture/liste');
                    return;
                }
            }
        })

        return { entity, loading }
    },

    components: {
        FactureFormLoadingComponent,
        FactureFormComponent
    },
});

</script>
