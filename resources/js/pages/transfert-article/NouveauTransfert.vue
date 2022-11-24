<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau transert d'article</h5>
                    <router-link to="/devis/fournisseur/liste" class="btn btn-primary"><i
                            class="fa fa-list me-2"></i>Liste des transerts</router-link>
                </div>
            </div>

            <div class="card-body">
                <TransfertForm></TransfertForm>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import TransfertForm from '../../components/transfert-article/TransfertFormComponent.vue'


export default defineComponent({
    components: {TransfertForm}
});

</script>
