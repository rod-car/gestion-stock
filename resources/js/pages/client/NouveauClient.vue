<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau client</h5>
                    <router-link to="/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des clients</router-link>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <Input v-model="form.nom" :error="Client.errors.value.nom" :required="true">Nom du client</Input>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <Input v-model="form.adresse" :error="Client.errors.value.adresse" :required="true">Adresse</Input>
                        </div>
                        <div class="col-xl-3 mb-3">
                            <Input v-model="form.email" :error="Client.errors.value.email" :required="false">Email</Input>
                        </div>
                        <div class="col-xl-3 mb-3">
                            <Input v-model="form.contact" :error="Client.errors.value.contact" :required="true">Contact</Input>
                        </div>

                        <div class="col-xl-6 mb-3">
                            <label for="categorie" class="form-label">Catégorie</label>
                            <MultiSelect
                                v-bind:class="hasError ? 'border-danger' : ''"
                                label="libelle" valueProp="id" :multiple="true" v-model="form.categories"
                                :options="Categorie.entities.value" mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                                :searchable="true" noOptionsText="Aucune catégorie" noResultsText="Aucune catégorie"
                                @close="check"
                            />

                            <div class="text-danger mt-1" v-if="hasError">
                                {{ Client.errors.value.categories[0] }}
                            </div>
                        </div>

                        <div class="col-xl-3 mb-3">
                            <Input v-model="form.nif" :error="Client.errors.value.nif" :required="false">NIF</Input>
                        </div>
                        <div class="col-xl-3 mb-3">
                            <Input v-model="form.cif" :error="Client.errors.value.cif" :required="false">CIF</Input>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <Input v-model="form.stat" :error="Client.errors.value.stat" :required="false">STAT</Input>
                        </div>

                        <div class="d-flex justify-content-end">
                            <SaveBtn @click.prevent="save" :loading="Client.creating.value">Enregistrer</SaveBtn>
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
import useCRUD from '../../services/CRUDServices';

const Client = useCRUD('/client'); // Contient tous les fonctions CRUD pour le Client
const Categorie = useCRUD('/categorie'); // Contient tous les foncions CRUD pour le categorie

export default {
    components: {
        Input, SaveBtn, Alert, MultiSelect,
    },
    setup() {
        return {
            Client, Categorie,
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
            await Client.createEntity(this.form)
            window.scrollTo({ top: 0, behavior: 'smooth' })
            if (Client.success.value !== null) this.resetForm()
            Client.success.value = null
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
            if (e.modelValue.length > 0) Client.errors.value.categories = null
        }
    },

    computed: {
        hasError () {
            if (Client.errors.value.categories && Client.errors.value.categories.length > 0) return true
            return false
        }
    },

    mounted() {
        Categorie.getEntities({ type: 1 })
    },
}
</script>
