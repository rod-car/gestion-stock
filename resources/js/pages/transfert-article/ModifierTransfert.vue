<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Modifier le transert d'article</h5>
                    <router-link to="/devis/fournisseur/liste" class="btn btn-primary"><i
                            class="fa fa-list me-2"></i>Liste des transerts</router-link>
                </div>
            </div>

            <div class="card-body">
                <TransfertForm v-if="!loading" :nouveau="false" :transfert="entity"></TransfertForm>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import useCRUD from '../../services/CRUDServices'
import router from '../../router/router';

import { defineComponent, onBeforeMount } from 'vue'
import TransfertForm from '../../components/transfert-article/TransfertFormComponent.vue'
const { entity, find, loading } = useCRUD('/transfert-article'); // Contient tous les fonctions CRUD pour les transferts



export default defineComponent({
    components: {TransfertForm},
    setup(){
        onBeforeMount(async () => {
            const id = parseInt(router.currentRoute.value.params.id.toString())
            await find(id)
        })

        return {
            entity, find, loading,
        }
    }
});

</script>
