<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 v-if="!loading" class="text-muted">Entrepôt N° {{ entity.id }}</h5>
                    <Skeletor v-else width="50%" height="30" style="border-radius: 5px" />

                    <div class="d-flex justify-content-end">
                        <router-link v-if="$can('edit_entrepot') && entity.id" :to="{ name: 'entrepot.modifier', params: { id: entity.id }}" class="btn btn-warning text-white me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                        <router-link v-if="$can('add_entrepot')" to="/entrepot/nouveau" class="btn btn-secondary me-2"><i class="fa fa-plus me-2"></i>Nouveau</router-link>
                        <router-link v-if="$can('view_entrepot')" to="/entrepot/liste" class="btn btn-primary me-2" ><i class="fa fa-list me-2"></i>Liste</router-link>
                    </div>

                </div>
            </div>

                <div class="card-body">
                    <VoirDepotLoadingComponent v-if="loading" />
                    <VoirDepotComponent v-else :depot="entity" :entrepot="true" />
                </div>
        </div>
    </div>
</template>

<script lang="ts">
import router from "../../router/router";
import useCRUD from "../../services/CRUDServices";
import { defineComponent, onBeforeMount } from "vue";
import VoirDepotComponent from "../../components/depot/VoirDepotComponent.vue";
import VoirDepotLoadingComponent from "../../components/depot/VoirDepotLoadingComponent.vue";
import { Skeletor } from 'vue-skeletor';

const { loading, entity, find } = useCRUD('/depot');

export default defineComponent({
    setup() {
        onBeforeMount(async (): Promise<any> => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id);
        });
        return {
            entity,
            loading,
            find,
        };
    },
    components: { VoirDepotComponent, VoirDepotLoadingComponent, Skeletor }
});

</script>
