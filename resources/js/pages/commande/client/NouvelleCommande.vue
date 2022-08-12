<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouvelle commande client</h5>
                    <router-link to="/commande/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste de commande client</router-link>
                </div>
            </div>

            <div class="card-body">
                <CommandeFormComponent :appro="false" :nouveau="true" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">

import { defineComponent } from 'vue';
import CommandeFormComponent from '../../../components/commande/CommandeFormComponent.vue';

export default defineComponent({
    components: {
        CommandeFormComponent
    },
});
</script>
