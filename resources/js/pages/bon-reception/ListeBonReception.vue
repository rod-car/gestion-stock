<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste de bon de reception</h5>
                    <router-link to="/bon-reception/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Nouveau bon de reception</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeBonReceptionLoadingComponent v-if="loading" />
                <ListeBonReceptionComponent v-else :appro="true" :entities="entities" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import useCRUD from '../../services/CRUDServices';
import { defineComponent, onBeforeMount } from 'vue';
import ListeBonReceptionComponent from '../../components/bon-reception/ListeBonReceptionComponent.vue';
import ListeBonReceptionLoadingComponent from '../../components/bon-reception/ListeBonReceptionLoadingComponent.vue';

const { loading, all, entities } = useCRUD('/bon-receptions')

export default defineComponent({
    components: {
        ListeBonReceptionLoadingComponent,
        ListeBonReceptionComponent
    },

    setup() {
        onBeforeMount(async (): Promise<any> => {
            await all() // Recuperer tous les commandes de fournisseurs
        })

        return {
            loading, entities,
        }
    },

})
</script>
