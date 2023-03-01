<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste des étiquettes</h5>
                    <router-link to="/parametres/etiquette/nouveau" class="btn btn-primary"><i
                            class="fa fa-plus me-2"></i>Nouvel
                        étiquette</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeEtiquetteComponent :etiquettes="entities"></ListeEtiquetteComponent>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, onBeforeMount } from "vue";

import ListeEtiquetteComponent from "../../components/etiquette/ListeEtiquetteComponent.vue"
import useCRUD from "../../services/CRUDServices";
const { all, entities, loading } = useCRUD('/etiquette');


export default {
    components: { ListeEtiquetteComponent },
    setup() {
        onBeforeMount(async (): Promise<any> => {
            await all(3);
        })

        return {
            loading, entities,
        };
    }
}

</script>
