<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Fiche article</h5>
            <div class="d-flex justify-content-between">
                <router-link to="/article/nouveau" class="btn btn-secondary me-2"><i
                        class="fa fa-plus me-2"></i>Nouveau</router-link>
                <router-link v-if="!loading && entity.id" :to="{ name: 'article.modifier', params: { id: entity.id } }"
                    class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/article/liste" class="btn btn-primary"><i
                        class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <VoirArticleLoadingComponent v-if="loading" />
            <VoirArticleComponent v-else :article="entity" />
            <VoirArticleParDepotComponent :depot="articleParDepot.data"></VoirArticleParDepotComponent>
        </div>
    </div>
</template>

<script lang="ts">
import useCRUD from '../../services/CRUDServices';
import VoirArticleComponent from '../../components/article/VoirArticleComponent.vue';
import VoirArticleLoadingComponent from '../../components/article/VoirArticleLoadingComponent.vue';
import router from '../../router/router';
import axiosClient from '../../axios'
import VoirArticleParDepotComponent from '../../components/article/VoirArticleParDepotComponent.vue'

import { onBeforeMount, onMounted, ref } from 'vue';

const { entity, loading, find } = useCRUD('/article');

export default {
    setup() {

        const articleParDepot = ref([])

        onBeforeMount(async (): Promise<any> => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id)
        })

        onMounted(async () => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            articleParDepot.value = await axiosClient.get('/article/voir-par-depot/' + id)
        })

        return {
            entity, loading, articleParDepot
        }
    },

    components: {
        VoirArticleComponent,
        VoirArticleLoadingComponent,
        VoirArticleParDepotComponent
    },

}
</script>

