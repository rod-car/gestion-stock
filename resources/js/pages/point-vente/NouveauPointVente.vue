<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau point de vente</h5>
                    <router-link to="/point-de-vente/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des point de vente</router-link>
                </div>
            </div>

            <div class="card-body">
                <DepotFormComponent :nouveau="true" :pointVente="true" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">

import DepotFormComponent from '../../components/depot/DepotFormComponent.vue';
import { defineComponent } from 'vue';

export default defineComponent({
    components: {
        DepotFormComponent,
    },
})

</script>
