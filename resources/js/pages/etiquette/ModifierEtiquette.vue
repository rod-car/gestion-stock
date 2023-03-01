<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Modifier l'étiquette</h5>
            <router-link to="/parametres/etiquette/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des
                étiquettes</router-link>
        </div>
        <div class="card-body">
            <EtiquetteFormLoadingComponent v-if="!loading" :nouveau="false" :etiquette="entity" type="3" />
        </div>
    </div>
</template>

<script lang="ts">
import useCRUD from '../../services/CRUDServices';
import EtiquetteFormLoadingComponent from '../../components/etiquette/FormEtiquetteComponent.vue';
import { onBeforeMount } from 'vue';
import router from '../../router/router';

const { loading, entity, find } = useCRUD('/etiquette');

export default {
    setup() {
        onBeforeMount(async (): Promise<any> => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id);
        })

        return {
            loading, entity,
        }
    },

    components: {
        EtiquetteFormLoadingComponent
    },

}
</script>
