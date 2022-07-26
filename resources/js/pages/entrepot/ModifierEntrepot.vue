<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 v-if="!loading" class="text-info">Modifier l'entrepôt N° {{ entity.id }}</h5>
                    <Skeletor v-else width="50%" height="40" style="border-radius: 5px" />

                    <router-link to="/entrepot/liste" class="btn btn-primary">
                        <i class="fa fa-list me-2"></i>Liste des entrepôts
                    </router-link>
                </div>
            </div>

            <div class="card-body">
                <DepotFormLoadingComponent v-if="loading" />
                <DepotFormComponent v-else :nouveau="false" :depot="entity" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import useCRUD from "../../services/CRUDServices";
import { Skeletor } from 'vue-skeletor';
import { onBeforeMount } from "vue";
import router from "../../router/router";
import DepotFormComponent from "../../components/depot/DepotFormComponent.vue";
import DepotFormLoadingComponent from "../../components/depot/DepotFormLoadingComponent.vue";

const { loading, find, entity } = useCRUD('/depot');

export default {
    components: {
        Skeletor, DepotFormComponent, DepotFormLoadingComponent,
    },
    setup() {

        onBeforeMount(async (): Promise<any> => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id);
        });

        return {
            loading, find, entity,
        };
    },
};
</script>
