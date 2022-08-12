<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau fournisseur</h5>
                    <router-link to="/fournisseur/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des fournisseurs</router-link>
                </div>
            </div>

            <div class="card-body">
                <FournisseurComponent :nouveau="true" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import FournisseurComponent from '../../components/fournisseur/FournisseurFormComponent.vue'

export default defineComponent({
    components: {
        FournisseurComponent,
    },
});
</script>
