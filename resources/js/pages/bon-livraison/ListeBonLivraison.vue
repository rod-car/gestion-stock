<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste de bon de livraison</h5>
                    <router-link to="/bon-livraison/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Nouveau bon de livraison</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeBonLivraisonLoadingComponent v-if="loading" />
                <ListeBonLivraisonComponent v-else :appro="true" :entities="entities" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import useCRUD from '../../services/CRUDServices';
import { defineComponent, onBeforeMount } from 'vue';
import ListeBonLivraisonComponent from '../../components/bon-livraison/ListeBonLivraisonComponent.vue';
import ListeBonLivraisonLoadingComponent from '../../components/bon-livraison/ListeBonLivraisonLoadingComponent.vue';

const { loading, all, entities } = useCRUD('/bon-livraisons')

export default defineComponent({
    components: {
        ListeBonLivraisonLoadingComponent,
        ListeBonLivraisonComponent
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
