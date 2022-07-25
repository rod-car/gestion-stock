<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Modifier le article</h5>
            <router-link to="/article/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des articles</router-link>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-xl-6 mb-3">
                        <Input v-if="!Article.loading.value" v-model="Article.entity.value.reference" :error="Article.errors.value.reference" :required="true">Référence de l'article</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-6 mb-3">
                        <Input v-if="!Article.loading.value" v-model="Article.entity.value.designation" :error="Article.errors.value.designation" :required="true">Désignation de l'article</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>

                    <div class="col-xl-6 mb-3">
                        <Input v-if="!Article.loading.value" v-model="Article.entity.value.unite" :error="Article.errors.value.unite" :required="false">Unité de l'article</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-6 mb-3">
                        <Input v-if="!Article.loading.value" v-model="Article.entity.value.stock_alert" :error="Article.errors.value.stock_alert" :required="false">Stock d'alerte</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-12 mb-3">
                        <label v-if="!Article.loading.value" for="categorie" class="form-label">Catégorie <span class="text-danger">(*)</span></label>
                        <MultiSelect
                            v-if="!Article.loading.value"
                            v-bind:class="hasError ? 'border-danger' : ''"
                            label="libelle" valueProp="id" :multiple="true" v-model="Article.entity.value.categories"
                            :options="Categorie.entities.value" mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                            :searchable="true" :object="true"
                            noOptionsText="Aucune catégorie" noResultsText="Aucune catégorie"
                            @close="check"
                        />

                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />

                        <div class="text-danger mt-1" v-if="hasError">
                            {{ Article.errors.value.categories[0] }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <SaveBtn @click.prevent="save(Article.entity.value.id)" :loading="Article.creating.value">Enregistrer</SaveBtn>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

import SaveBtn from '../../components/html/SaveBtn.vue';
import Input from '../../components/html/Input.vue';
import { Skeletor } from 'vue-skeletor';
import MultiSelect from '@vueform/multiselect';
import useCRUD from '../../services/CRUDServices.ts';

const Article = useCRUD('/article')
const Categorie = useCRUD('/categorie')

export default {
    setup() {
        return {
            Article, Categorie,
        }
    },

    components: {
        Input, SaveBtn, Skeletor, MultiSelect,
    },

    methods: {
        async save(id) {
            await Article.update(id, Article.entity.value);
            window.scrollTo({ top: 0, behavior: "smooth" });
            Article.success.value = null
        },
    },

    mounted() {
        const id = parseInt(this.$route.params.id);
        Article.find(id)
        Categorie.all({ type: 3 })
    },

}
</script>
