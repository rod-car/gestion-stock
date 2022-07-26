<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau entrepôt</h5>
                    <router-link to="/entrepot/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des entrepôts</router-link>
                </div>
            </div>

            <div class="card-body">
                <DepotFormComponent :nouveau="true" :pointVente="false" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import DepotFormComponent from "../../components/depot/DepotFormComponent.vue";
import { defineComponent } from "vue";

export default defineComponent({

    components: {
        DepotFormComponent,
    }

})

</script>
