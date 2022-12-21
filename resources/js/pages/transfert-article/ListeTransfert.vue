<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">La liste des transferts</h5>
                    <router-link to="/transfert-article/nouveau" class="btn btn-primary"><i
                            class="fa fa-list me-2"></i>Liste des transerts</router-link>
                </div>
            </div>

            <div class="card-body">
                <TransfertListComponent></TransfertListComponent>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, onMounted } from 'vue'
import { useRoute } from 'vue-router'

import TransfertListComponent from '../../components/transfert-article/TransfertListComponent.vue'

export default defineComponent({
    components: {
        TransfertListComponent
    },
    setup() {
       const route = useRoute()

        onMounted(() => {
        const id = route.params.id
        console.log(id)
        })
    }
});



</script>
