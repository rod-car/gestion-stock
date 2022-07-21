<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau dévis fournisseur</h5>
                    <router-link to="/devis/fournisseur/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des deviss</router-link>
                </div>
            </div>

            <div class="card-body">
                <DevisFormComponent :nouveau="true" :appro="true" />
            </div>
        </div>
    </div>
</template>

<script>

import DevisFormComponent from '../../../components/devis/DevisFormComponent.vue'

export default {

    components: {
        DevisFormComponent,
    }

}

</script>
