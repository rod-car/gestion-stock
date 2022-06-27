<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau fournisseur</h5>
                    <router-link to="/fournisseur/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des fournisseurs</router-link>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <Input v-model="form.nom" :error="errors.nom" :required="true">Nom du fournisseur</Input>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <Input v-model="form.adresse" :error="errors.adresse" :required="true">Adresse</Input>
                        </div>
                        <div class="col-xl-3 mb-3">
                            <Input v-model="form.email" :error="errors.email" :required="false">Email</Input>
                        </div>
                        <div class="col-xl-3 mb-3">
                            <Input v-model="form.contact" :error="errors.contact" :required="true">Contact</Input>
                        </div>

                        <div class="col-xl-6 mb-3">
                            <label for="categorie" class="form-label">Catégorie</label>
                            <MultiSelect
                                v-bind:class="hasError ? 'border-danger' : ''"
                                label="libelle" valueProp="id" :multiple="true" v-model="form.categories"
                                :options="categories" mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                                :searchable="true"
                                noOptionsText="Aucune catégorie"
                                noResultsText="Aucune catégorie"
                                @close="check"
                            />

                            <div class="text-danger mt-1" v-if="hasError">
                                {{ errors.categories[0] }}
                            </div>
                        </div>

                        <div class="col-xl-3 mb-3">
                            <Input v-model="form.nif" :error="errors.nif" :required="false">NIF</Input>
                        </div>
                        <div class="col-xl-3 mb-3">
                            <Input v-model="form.cif" :error="errors.cif" :required="false">CIF</Input>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <Input v-model="form.stat" :error="errors.stat" :required="false">STAT</Input>
                        </div>

                        <div class="d-flex justify-content-end">
                            <SaveBtn @click.prevent="save" :loading="creating">Enregistrer</SaveBtn>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import Input from '../../components/html/Input.vue';
import SaveBtn from '../../components/html/SaveBtn.vue';
import Alert from '../../components/html/Alert.vue';
import MultiSelect from '@vueform/multiselect';
import useFournisseur from '../../services/fournisseur/FournisseurServices';
import useCategories from '../../services/categorie/CategorieServices';

const { success, errors, creating, createFournisseur } = useFournisseur()
const { categories, loading, getCategories } = useCategories();

export default {
    components: {
        Input, SaveBtn, Alert, MultiSelect,
    },
    setup() {
        return {
            success, errors, loading, creating, categories, getCategories,
            createFournisseur, getCategories,
        }
    },
    data() {
        return {
            form: {
                nom: null,
                adresse: null,
                email: null,
                contact: null,
                categories: [],
                nif: null,
                cif: null,
                stat: null,
            },
        }
    },
    methods: {
        async save () {
            await createFournisseur(this.form)
            window.scrollTo({ top: 0, behavior: 'smooth' })
            if (success.value !== null) this.resetForm()
            success.value = null
        },
        resetForm () {
            this.form = {
                nom: null,
                adresse: null,
                email: null,
                contact: null,
                categories: [],
                nif: null,
                cif: null,
                stat: null,
            }
        },

        check (e) {
            if (e.modelValue.length > 0) errors.value.categories = null
        }
    },

    computed: {
        hasError () {
            if (errors.value.categories && errors.value.categories.length > 0) return true
            return false
        }
    },

    mounted() {
        getCategories(2)
    },
}
</script>
