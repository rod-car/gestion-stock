<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste des fournisseurs</h5>
                    <router-link to="/fournisseur/nouveau" class="btn btn-primary"><i
                            class="fa fa-plus me-2"></i>Nouveau fournisseur</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeFournisseurLoadingComponent v-if="loading" />
                <ListeFournisseurComponent v-else :fournisseurs="entities" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import ListeFournisseurLoadingComponent from "../../components/fournisseur/ListeFournisseurLoadingComponent.vue";
import ListeFournisseurComponent from "../../components/fournisseur/ListeFournisseurComponent.vue";
import { defineComponent, onBeforeMount } from "vue";
import useCRUD from "../../services/CRUDServices";

const { loading, entities, all } = useCRUD('/fournisseur');

export default defineComponent({

    setup() {
        onBeforeMount(async (): Promise<any> => {
            await all(2);
        })

        return {
            loading, entities,
        };
    },
    components: { ListeFournisseurComponent, ListeFournisseurLoadingComponent }

});

</script>
