<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste des articles</h5>
                    <router-link to="/article/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Nouvel
                        article</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeArticleLoadingComponent v-if="loading" />
                <ListeArticleComponent v-else :articles="entities" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import useCRUD from '../../services/CRUDServices';
import ListeArticleLoadingComponent from '../../components/article/ListeArticleLoadingComponent.vue';
import ListeArticleComponent from '../../components/article/ListeArticleComponent.vue';
import { defineComponent, onBeforeMount } from 'vue';

const { entities, loading, all } = useCRUD("/article")

export default defineComponent({
    components: {
        ListeArticleLoadingComponent,
        ListeArticleComponent
    },

    setup() {
        onBeforeMount(async (): Promise<any> => {
            await all();
        })

        return {
            entities, loading,
        }
    }

});
</script>
