import useCRUD from 'resources/js/services/CRUDServices';
<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouvelle commande fournisseur</h5>
                    <router-link to="/commande/fournisseur/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste de commande fournisseur</router-link>
                </div>
            </div>

            <div class="card-body">
                <BonReceptionFormLoadingComponent v-if="loading" />
                <BonReceptionFormComponent v-else :appro="true" :nouveau="true" :devis="entity" />
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

const { entity, loading, find } = useCRUD('/commandes');

export default defineComponent({
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
    },

    components: {
        BonReceptionFormComponent,
        BonReceptionFormLoadingComponent
    },
});

</script>
