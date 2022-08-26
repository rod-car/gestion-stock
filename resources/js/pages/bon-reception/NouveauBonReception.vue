import useCRUD from 'resources/js/services/CRUDServices';
<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau bon de reception</h5>
                    <router-link to="/bon-reception/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste de bon de réception</router-link>
                </div>
            </div>

            <div class="card-body">
                <BonReceptionFormLoadingComponent v-if="loading" />
                <BonReceptionFormComponent v-else :nouveau="true" :commande="entity" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import router from '../../router/router';
import useCRUD from '../../services/CRUDServices';
import { defineComponent, onBeforeMount, ref, Ref } from 'vue';
import BonReceptionFormComponent from '../../components/bon-reception/BonReceptionFormComponent.vue';
import BonReceptionFormLoadingComponent from '../../components/bon-reception/BonReceptionFormLoadingComponent.vue';
import Flash from '../../functions/Flash';

const { entity, loading, find } = useCRUD('/commandes');

export default defineComponent({
    setup() {
        const commandeId: Ref<number | null> = ref(null);

        onBeforeMount(async (): Promise<any> => {
            const id = router.currentRoute.value.query.commande;

            if (id !== undefined && id !== null) commandeId.value = parseInt(id.toString());
            else commandeId.value = null;

            if (commandeId.value !== null) {
                // Recuperer la commande en question
                await find(commandeId.value);
                if (entity.value.type !== 2) {
                    Flash('error', 'Erreur', 'Veuillez selectionner une commande');
                    router.push('/commande/fournisseur/liste');
                    return;
                }
            }
        })

        return { entity, loading }
    },

    components: {
        BonReceptionFormComponent,
        BonReceptionFormLoadingComponent
    },
});

</script>
