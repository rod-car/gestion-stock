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
                <label for="categorie" class="form-label">Catégorie
                    (<a v-if="creationCategorie" href="#" @click.prevent="creerCategorie" class="text-danger">Fermer</a>
                    <a v-else href="#" @click.prevent="creerCategorie" class="text-primary">Créer nouveau</a>)</label>
                <MultiSelect
                    v-if="!Categorie.loading.value"
                    v-bind:class="hasError ? 'border-danger' : ''"
                    label="libelle" valueProp="id" :multiple="true" v-model="form.categories"
                    :options="Categorie.entities.value" mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                    :searchable="true" noOptionsText="Aucune catégorie" noResultsText="Aucune catégorie"
                    @close="check"
                />
                <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />

                <div class="text-danger mt-1" v-if="hasError">
                    {{ Client.errors.value.categories[0] }}
                </div>
            </div>

            <div v-if="creationCategorie" class="col-xl-12 border border-secondary shadow p-5 mb-5 mt-3">
                <CategorieFormComponent @categorie-cree="categorieCree" :nouveau="true" :type="1" />
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

<script lang="ts">

import Input from '../html/Input.vue';
import SaveBtn from '../html/SaveBtn.vue';
import Alert from '../html/Alert.vue';
import MultiSelect from '@vueform/multiselect';
import useCRUD from '../../services/CRUDServices';
import { ref, computed, onMounted, defineComponent, Ref } from 'vue';
import { Skeletor } from 'vue-skeletor';
import CategorieFormComponent from '../categorie/CategorieFormComponent.vue';

const Client = useCRUD('/client'); // Contient tous les fonctions CRUD pour le Client
const Categorie = useCRUD('/categorie'); // Contient tous les foncions CRUD pour le categorie

interface Form {
    nom: string | null,
    adresse: string | null,
    email: string | null,
    contact: string | null,
    categories: Array<any>,
    nif: string | null,
    cif: string | null,
    stat: string | null,
}

export default defineComponent({
    components: {
        Input,
        SaveBtn,
        Alert,
        MultiSelect,
        Skeletor,
        CategorieFormComponent
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
        const form: Ref<Form> = ref({
            nom: null, adresse: null,
            email: null, contact: null,
            categories: [], nif: null,
            cif: null, stat: null,
        })

        const creationCategorie: Ref<boolean> = ref(false)

        const save = async (): Promise<any> => {
            if (props.nouveau === true) {
                await Client.create(form.value)
            } else {
                const id = props.client.id
                await Client.update(id, form.value)
            }

            window.scrollTo({ top: 0, behavior: 'smooth' })
            if (Client.success.value !== null && props.nouveau === true) {
                resetForm()
                emit('client-cree');
            }
            Client.success.value = null
        }

        const categorieCree = async (): Promise<any> => {
            creationCategorie.value = false;
            await Categorie.all(1)
        }

        const creerCategorie = () => {
            creationCategorie.value = !creationCategorie.value;
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

        const check = (e: { modelValue: string | any[]; }) => {
            if (e.modelValue.length > 0) Client.errors.value.categories = null
        }

        const hasError = computed((): boolean => {
            if (Client.errors.value.categories && Client.errors.value.categories.length > 0) return true
            return false
        })

        onMounted(async (): Promise<any> => {
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
            await Categorie.all(1)
        })

        return {
            Client, Categorie, form, save, resetForm, check, hasError, categorieCree, creerCategorie, creationCategorie,
        }
    },
});

</script>
