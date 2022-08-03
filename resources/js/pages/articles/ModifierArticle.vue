<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Modifier le article</h5>
            <router-link to="/article/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des articles</router-link>
        </div>
        <div class="card-body">
            <ArticleFormLoadingComponent v-if="loading" />
            <ArticleFormComponent v-else :nouveau="false" :article="entity" />
        </div>
    </div>
</template>

<script lang="ts">
import useCRUD from '../../services/CRUDServices';
import ArticleFormLoadingComponent from '../../components/article/ArticleFormLoadingComponent.vue';
import ArticleFormComponent from '../../components/article/ArticleFormComponent.vue';
import { defineComponent, onBeforeMount } from 'vue';
import router from '../../router/router';

const { entity, find, loading } = useCRUD('/article');

export default defineComponent({
    setup() {
        onBeforeMount(async (): Promise<any> => {
            const id = parseInt(router.currentRoute.value.params.id.toString());
            await find(id);
        })

        return {
            entity, find, loading,
        }
    },

    components: {
        ArticleFormLoadingComponent,
        ArticleFormComponent
    }

});
</script>
