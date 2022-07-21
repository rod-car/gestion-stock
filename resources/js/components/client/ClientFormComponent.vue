<template>
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
</template>

<script>

import Input from '../html/Input.vue';
import SaveBtn from '../html/SaveBtn.vue';
import Alert from '../html/Alert.vue';
import MultiSelect from '@vueform/multiselect';
import useCRUD from '../../services/CRUDServices';
import { ref, computed, onMounted } from 'vue';

const Client = useCRUD('/client'); // Contient tous les fonctions CRUD pour le Client
const Categorie = useCRUD('/categorie'); // Contient tous les foncions CRUD pour le categorie

export default {
    components: {
        Input, SaveBtn, Alert, MultiSelect,
    },

    props: {
        nouveau: {
            type: Boolean,
            required: false,
            default: true,
        },
        client: {
            type: Object,
            required: false,
            default: null,
        }
    },

    emits: ['client-cree'],

    setup(props, { emit }) {
        const form = ref({
            nom: null,
            adresse: null,
            email: null,
            contact: null,
            categories: [],
            nif: null,
            cif: null,
            stat: null,
        })


        const save = async () => {
            if (props.nouveau === true) {
                await Client.createEntity(form.value)
            } else {
                const id = props.client.id
                await Client.updateEntity(id, form.value)
            }

            window.scrollTo({ top: 0, behavior: 'smooth' })
            if (Client.success.value !== null && props.nouveau === true) {
                resetForm()
                emit('client-cree');
            }
            Client.success.value = null
        }

        const resetForm = () => {
            form.value = {
                nom: null,
                adresse: null,
                email: null,
                contact: null,
                categories: [],
                nif: null,
                cif: null,
                stat: null,
            }
        }

        const check = (e) => {
            if (e.modelValue.length > 0) Client.errors.value.categories = null
        }

        const hasError = computed(() => {
            if (Client.errors.value.categories && Client.errors.value.categories.length > 0) return true
            return false
        })

        onMounted(() => {
            if (props.nouveau === false) {
                form.value = {
                    nom: props.client.nom,
                    adresse: props.client.adresse,
                    email: props.client.email,
                    contact: props.client.contact,
                    categories: props.client.categories,
                    nif: props.client.nif,
                    cif: props.client.cif,
                    stat: props.client.stat,
                }
            }
            Categorie.getEntities({ type: 1 })
        })

        return {
            Client, Categorie, form, save, resetForm, check,
        }
    },
}
</script>
