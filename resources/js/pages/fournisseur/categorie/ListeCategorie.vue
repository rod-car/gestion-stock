<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste de catégorie de fournisseur</h5>
                    <router-link to="/fournisseur/categorie/nouveau" class="btn btn-primary"><i
                            class="fa fa-plus me-2"></i>Nouvelle catégorie</router-link>
                </div>
            </div>
            <div class="card-body">
                <ListeCategorieLoadingComponent v-if="loading" />
                <ListeCategorieComponent v-else :categories="entities" :type="2" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import useCRUD from "../../../services/CRUDServices";
import { defineComponent, onBeforeMount } from "vue";
import ListeCategorieComponent from "../../../components/categorie/ListeCategorieComponent.vue";
import ListeCategorieLoadingComponent from "../../../components/categorie/ListeCategorieLoadingComponent.vue";
const { entities, loading, all } = useCRUD('/categorie');

export default defineComponent({
    setup() {
        onBeforeMount(async (): Promise<any> => {
            await all(2);
        })

        return {
            entities, all, loading,
        };
    },
    components: { ListeCategorieComponent, ListeCategorieLoadingComponent }
});

</script>
