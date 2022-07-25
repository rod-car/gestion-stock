<template>
    <form action="" method="post">
        <div class="row">
            <div class="col-xl-6 mb-3">
                <Input v-model="form.reference" :error="Article.errors.value.reference" :required="true">Référence de l'article</Input>
            </div>
            <div class="col-xl-6 mb-3">
                <Input v-model="form.designation" :error="Article.errors.value.designation" :required="true">Designation de l'article</Input>
            </div>
            <div class="col-xl-6 mb-3">
                <Input v-model="form.unite" :error="Article.errors.value.unite" :required="true">Unité de l'article</Input>
            </div>
            <div class="col-xl-6 mb-3">
                <Input v-model="form.stock_alert" type="number" :error="Article.errors.value.stock_alert" :required="false">Stock d'alerte</Input>
            </div>

            <div class="col-xl-12 mb-5">
                <label for="categorie" class="form-label">Catégories</label>
                <MultiSelect
                    v-bind:class="hasError ? 'border-danger' : ''"
                    label="libelle" valueProp="id" :multiple="true" v-model="form.categories"
                    :options="Categorie.entities.value" mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                    :searchable="true" noOptionsText="Aucune catégorie" noResultsText="Aucune catégorie"
                    @close="check"
                />

                <div class="text-danger mt-1" v-if="hasError">
                    {{ Article.errors.value.categories[0] }}
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <SaveBtn @click.prevent="save" :loading="Article.creating.value">Enregistrer</SaveBtn>
            </div>
        </div>
    </form>
</template>

<script>

import Input from '../html/Input.vue';
import SaveBtn from '../html/SaveBtn.vue';
import Alert from '../html/Alert.vue';
import MultiSelect from '@vueform/multiselect';
import useCRUD from '../../services/CRUDServices.ts';

const Article = useCRUD('/article'); // Contient tous les fonctions CRUD pour le article
const Categorie = useCRUD('/categorie'); // Contient tous les foncions CRUD pour le categorie

export default {
    name: "Nouveau article",
    components: {
        Input, SaveBtn, Alert, MultiSelect,
    },
    setup() {
        return {
            Article, Categorie,
        }
    },
    data() {
        return {
            form: {
                reference: null,
                designation: null,
                unite: 'Nombre',
                stock_alert: null,
                categories: [],
            },
        }
    },
    methods: {
        async save() {
            await Article.create(this.form)
            window.scrollTo({ top: 0, behavior: 'smooth' })
            if (Article.success.value !== null) {
                this.resetForm()
                this.$emit('article-cree')
            }
            Article.success.value = null
        },
        resetForm () {
            this.form = {
                reference: null,
                designation: null,
                unite: "Nombre",
                stock_alert: null,
                categories: [],
            }
        },

        check (e) {
            if (e.modelValue.length > 0) Article.errors.value.categories = null
        }
    },

    computed: {
        hasError () {
            if (Article.errors.value.categories && Article.errors.value.categories.length > 0) return true
            return false
        }
    },

    mounted() {
        Categorie.all({ type: 3 })
    },
}
</script>
