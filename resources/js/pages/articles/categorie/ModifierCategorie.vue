<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Modifier la catégorie de article</h5>
            <router-link to="/article/categorie/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des catégories</router-link>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-xl-12 mb-3">
                        <Input v-if="!loading" v-model="categorie.libelle" :error="errors.libelle" :required="true">Nom de la catégorie</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-12 mb-3">
                        <label v-if="!loading" for="sous_categories" class="form-label">Sous catégories</label>
                        <Multiselect v-if="!loading"
                            label="libelle" valueProp="id" :multiple="true" v-model="categorie.sous_categories"
                            :object="true"
                            :options="categories" mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                            :searchable="true" placeholder="Selectionner lees sous catégories"
                            noOptionsText="Aucune catégorie"
                            noResultsText="Aucune catégorie"
                        />
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-12 mb-3">
                        <Input v-if="!loading" type="textarea" v-model="categorie.description" :error="errors.description">Description de la catégorie</Input>
                        <Skeletor v-else height="80" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="d-flex justify-content-end">
                        <SaveBtn v-if="!loading" @click.prevent="save(categorie.id)" :loading="updating">Enregistrer</SaveBtn>
                        <Skeletor v-else height="40" width="10%" style="border-radius: 3px" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

import SaveBtn from '../../../components/html/SaveBtn.vue';
import Input from '../../../components/html/Input.vue';
import useCategorie from '../../../services/categorie/CategorieServices';
import Multiselect from '@vueform/multiselect';
import { Skeletor } from 'vue-skeletor';

const { updating, loading, categorie, categories, errors, success, getCategorie, getCategories, updateCategorie } = useCategorie();

export default {
    setup() {
        return {
            loading, updating, errors, success, categorie, categories, getCategorie, updateCategorie, getCategories,
        }
    },

    components: {
        Input, SaveBtn, Skeletor, Multiselect,
    },

    methods: {
        async save(id) {
            await updateCategorie(id, categorie.value);
            window.scrollTo({ top: 0, behavior: "smooth" });
            success.value = null
        },
    },

    mounted() {
        const id = parseInt(this.$route.params.id);
        getCategorie(id)
        getCategories(3, id)
    },

}
</script>
