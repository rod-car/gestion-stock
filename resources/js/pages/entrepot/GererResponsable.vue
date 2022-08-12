<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 v-if="!Depot.loading.value" class="text-info">Gerer les responsables de l'entrepôt N° {{ Depot.entity.value.id }}</h5>
                    <Skeletor v-else width="50%" height="30" style="border-radius: 5px" />
                    <router-link v-if="$can('view_entrepot')" to="/entrepot/liste" class="btn btn-primary me-2"><i class="fa fa-list me-2"></i>Liste des entrepôts</router-link>
                </div>
            </div>

            <div class="card-body">
                <GererResponsableFormLoadingComponent v-if="Depot.loading.value" />
                <GererResponsableFormComponent v-else :depot="Depot.entity.value" :responsables="Responsable.entities.value" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">

import { Skeletor } from "vue-skeletor";
import GererResponsableFormLoadingComponent from '../../components/depot/GererResponsableFormLoadingComponent.vue';
import GererResponsableFormComponent from '../../components/depot/GererResponsableFormComponent.vue';
import { defineComponent, onBeforeMount } from "vue";
import router from "../../router/router";
import useCRUD from "../../services/CRUDServices";

const Depot = useCRUD('/depot');
const Responsable = useCRUD('/user');

export default defineComponent({
    components: {
        Skeletor, GererResponsableFormComponent, GererResponsableFormLoadingComponent,
    },
    setup() {
        onBeforeMount(async (): Promise<any> => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await Depot.find(id);
            await Responsable.all(0);
        })

        return {
            Responsable, Depot,
        };
    },
});

</script>
