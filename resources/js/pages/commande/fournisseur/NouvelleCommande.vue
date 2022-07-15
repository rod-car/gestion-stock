<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouvelle commande fournisseur</h5>
                    <router-link to="/commande/fournisseur/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste de commande fournisseur</router-link>
                </div>
            </div>

            <div class="card-body">
                <CommandeFormComponent :appro="true" :nouveau="true" />
            </div>
        </div>
    </div>
</template>

<script>

import CommandeFormComponent from '../../../components/commande/CommandeFormComponent.vue';

export default {
    components: {
        CommandeFormComponent
    },
}

</script>
