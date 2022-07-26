<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 v-if="!loading" class="text-info">Modifier le point de vente N° {{ entity.id }}</h5>
                    <Skeletor v-else width="50%" height="40" style="border-radius: 5px" />
                    <router-link to="/point-de-vente/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des point de vente</router-link>
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
import router from "../../router/router";
import useCRUD from "../../services/CRUDServices";
import { defineComponent, onBeforeMount } from "vue";
import DepotFormComponent from "../../components/depot/DepotFormComponent.vue";
import DepotFormLoadingComponent from "../../components/depot/DepotFormLoadingComponent.vue";
import { Skeletor } from "vue-skeletor";

const { loading, entity, find } = useCRUD('/depot');

export default defineComponent({
    setup() {

        onBeforeMount(async (): Promise<any> => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id);
        });

        return {
            loading,
            entity,
            find,
        };
    },
    components: { DepotFormLoadingComponent, DepotFormComponent, Skeletor }
});

</script>
