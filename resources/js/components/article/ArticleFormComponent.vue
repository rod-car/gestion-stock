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

            <div class="col-xl-12 mb-3">
                <label for="categorie" class="form-label">Catégories
                    (<a v-if="creationCategorie" href="#" @click.prevent="creerCategorie" class="text-danger">Fermer</a>
                    <a v-else href="#" @click.prevent="creerCategorie" class="text-primary">Créer nouveau</a>)
                </label>
                <MultiSelect
                    v-if="!Categorie.loading.value"
                    :class="hasError ? 'border-danger' : ''"
                    label="libelle" valueProp="id" :multiple="true" v-model="form.categories"
                    :options="Categorie.entities.value" mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                    :searchable="true"
                    :object="nouveau === false ? true: false"
                    placeholder="Selectionner les catégories"
                    noOptionsText="Aucune catégorie"
                    noResultsText="Aucune catégorie"
                    @close="check"
                />
                <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />

                <div class="text-danger mt-1" v-if="hasError">
                    {{ Article.errors.value.categories[0] }}
                </div>
            </div>

            <div v-if="creationCategorie" class="col-xl-12 border border-secondary shadow p-5 mb-5 mt-3">
                <CategorieFormComponent @categorie-cree="categorieCree" :nouveau="true" :type="3" />
            </div>

            <div class="d-flex justify-content-end mt-3">
                <SaveBtn @click.prevent="save" :loading="Article.creating.value">Enregistrer</SaveBtn>
            </div>
        </div>
    </form>
</template>

<script lang="ts">

import Input from '../html/Input.vue';
import SaveBtn from '../html/SaveBtn.vue';
import Alert from '../html/Alert.vue';
import MultiSelect from '@vueform/multiselect';
import useCRUD from '../../services/CRUDServices';
import { computed, defineComponent, onMounted, Ref, ref } from 'vue';
import CategorieFormComponent from '../categorie/CategorieFormComponent.vue';

const Article = useCRUD('/article'); // Contient tous les fonctions CRUD pour le article
const Categorie = useCRUD('/categorie'); // Contient tous les foncions CRUD pour le categorie

interface Form {
    reference: string|null,
    designation: string|null,
    unite: string,
    stock_alert: number|null,
    categories: Array<any>,
}

export default defineComponent({
    name: "Nouveau article",
    components: {
        Input, SaveBtn, Alert, MultiSelect, CategorieFormComponent,
    },

    props: {
        nouveau: {
            type: Boolean,
            required: true,
        },
        article: {
            type: Object,
            required: false,
        }
    },

    setup(props, { emit }) {
        const form = ref({
            reference: null,
            designation: null,
            unite: 'Nombre',
            stock_alert: null,
            categories: [],
        } as Form);

        const creationCategorie: Ref<boolean> = ref(false)

        const categorieCree = async (): Promise<any> => {
            creationCategorie.value = false;
            await Categorie.all(1)
        }

        const creerCategorie = () => {
            creationCategorie.value = !creationCategorie.value;
        }

        const save = async (): Promise<any> => {
            if (props.nouveau === true) await Article.create(form.value)
            else if (props.article) await Article.update(props.article.id, form.value);

            window.scrollTo({ top: 0, behavior: 'smooth' })

            if (Article.success.value !== null && props.nouveau === true) {
                resetForm()
                emit('article-cree')
            }
            Article.success.value = null
        }

        const resetForm = (): void => {
            form.value = {
                reference: null,
                designation: null,
                unite: "Nombre",
                stock_alert: null,
                categories: [],
            }
        }

        const check = (e: { modelValue: string | any[]; }): void => {
            if (e.modelValue.length > 0) Article.errors.value.categories = null
        }

        const hasError = computed((): boolean => {
            if (Article.errors.value.categories && Article.errors.value.categories.length > 0) return true
            return false
        });

        onMounted(async (): Promise<any> => {
            if (props.nouveau === false && props.article) {
                form.value = {
                    reference: props.article.reference,
                    designation: props.article.designation,
                    unite: props.article.unite,
                    stock_alert: props.article.stock_alert,
                    categories: props.article.categories,
                }
            }
            await Categorie.all(3)
        })

        return {
            Article, Categorie, form, save, hasError, check, categorieCree, creationCategorie, creerCategorie,
        }
    }
});

</script>
