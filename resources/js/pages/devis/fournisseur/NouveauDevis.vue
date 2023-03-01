<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau devis fournisseur</h5>


                    <router-link to="/devis/fournisseur/liste" class="btn btn-primary"><i
                            class="fa fa-list me-2"></i>Liste des deviss</router-link>
                </div>
            </div>

            <div class="card-body">
                <DevisFormComponent :devis="entity" :nouveau="true" :appro="true" :number-auto="false"
                    :has-attachment="true" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import DevisFormComponent from '../../../components/devis/DevisFormComponent.vue'

export default defineComponent({

    components: {
        DevisFormComponent
    },

});

</script>
