<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Tous les articles du point de vente</h5>
                    <div class="d-flex justify-content-between">
                        <router-link :to="{ name: 'point-de-vente.voir', params: { id: id }}" class="btn btn-secondary me-3"><i class="fa fa-eye me-2"></i>Voir le point de vente</router-link>
                        <router-link to="/point-de-vente/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des point de vente</router-link>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <Table
                    name="article"
                    :data="articles"
                    :columns="columns"
                    :actions="false"
                    :loading="loading"
                    :casts="casts"
                    :searchable="true"
                    :ordered="true"
                />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import axiosClient from '../../axios';
import router from '../../router/router';
import Table from '../../components/html/Table.vue';
import { defineComponent, onBeforeMount, ref } from 'vue';

export default defineComponent({
    components: {
        Table
    },

    setup() {
        const loading = ref(false);
        const articles = ref([]);
        const columns = { reference: 'Réference', designation: 'Désignation', unite: 'Unité', 'entree - sortie': 'Quantité', 'fullArticle.pivot.pu': 'PU' };
        const casts = [];
        const id = parseInt(router.currentRoute.value.params.id.toString());

        casts['fullArticle.pivot.pu'] = 'money';

        onBeforeMount(async (): Promise<any> => {
            loading.value = true;

            let response = await axiosClient.get(`/depot/${id}/articles`);
            articles.value = response.data;

            loading.value = false;
        })

        return {
            articles, loading, columns, casts, id,
        }
    },

});

</script>
