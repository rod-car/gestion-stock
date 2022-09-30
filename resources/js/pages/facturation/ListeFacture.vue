<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste de factures</h5>
                </div>
            </div>
            <div class="card-body">
                <ListeFactureLoadingComponent v-if="loading" />
                <ListeFactureComponent v-else :factures="entities" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import useCRUD from '../../services/CRUDServices';
import { defineComponent, onBeforeMount } from 'vue';
import ListeFactureComponent from '../../components/facturation/ListeFactureComponent.vue';
import ListeFactureLoadingComponent from '../../components/facturation/ListeFactureLoadingComponent.vue';

const { loading, all, entities } = useCRUD('/factures')

export default defineComponent({
    components: {
        ListeFactureLoadingComponent,
        ListeFactureComponent
    },

    setup() {
        onBeforeMount(async (): Promise<any> => {
            await all() // Recuperer tous les bon de livraison client
        })

        return {
            loading, entities,
        }
    },

})
</script>
