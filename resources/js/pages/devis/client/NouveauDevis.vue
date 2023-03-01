<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau devis client</h5>

                    <router-link to="/devis/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste
                        de devis client</router-link>
                </div>
            </div>

            <div class="card-body">
                <SearchFromOldDevisComponent @articles="(id) => find(id)" />

                <DevisFormComponent :nouveau="true" :appro="false" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import DevisFormComponent from '../../../components/devis/DevisFormComponent.vue'
import useCRUD from '../../../services/CRUDServices';
import searchFromOldDevisComponent from "../../../components/devis/SearchFromOldDevisComponent.vue"
const { find, loading, entity } = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Devis

export default defineComponent({
    components: {
        DevisFormComponent, searchFromOldDevisComponent
    },
    setup() {
        return { find }
    }
});

</script>
