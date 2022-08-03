<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste de catégorie d'article</h5>
                    <router-link to="/article/categorie/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Ajouter un nouveau</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeCategorieLoadingComponent v-if="loading" :column="5" />
                <ListeCategorieComponent v-else :categories="entities" :type="3" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, onBeforeMount } from "vue";
import ListeCategorieLoadingComponent from "../../../components/categorie/ListeCategorieLoadingComponent.vue";
import ListeCategorieComponent from "../../../components/categorie/ListeCategorieComponent.vue";
import useCRUD from "../../../services/CRUDServices";

const { all, entities, loading } = useCRUD('/categorie');

export default defineComponent({
    setup() {
        onBeforeMount(async (): Promise<any> => {
            await all(3);
        })

        return {
            loading, entities,
        };
    },
    components: { ListeCategorieLoadingComponent, ListeCategorieComponent }
});

</script>
