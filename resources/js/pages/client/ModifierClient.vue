<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Modifier le client</h5>
            <router-link to="/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des clients</router-link>
        </div>
        <div class="card-body">
            <ClientFormComponent v-if="!Client.loading.value" :nouveau="false" :client="Client.entity.value" />
            <ClientFormLoadingComponent v-else />
        </div>
    </div>
</template>

<script>

import useCRUD from '../../services/CRUDServices.ts';
import ClientFormComponent from '../../components/client/ClientFormComponent.vue';
import ClientFormLoadingComponent from '../../components/client/ClientFormLoadingComponent.vue';
import { onMounted } from 'vue';
import router from '../../router/router';

const Client = useCRUD('/client')

export default {
    components: {
        ClientFormComponent, ClientFormLoadingComponent,
    },

    setup() {
        onMounted(async () => {
            const id = parseInt(router.currentRoute.value.params.id)
            await Client.find(id)
        })

        return {
            Client,
        }
    },

}
</script>
