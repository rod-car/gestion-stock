<template>
    <form action="" method="post">
        <div class="row">
            <div class="col-xl-6 mb-3">
                <Input v-model="form.nom" :error="Fournisseur.errors.value.nom" :required="true">Nom du fournisseur</Input>
            </div>
            <div class="col-xl-6 mb-3">
                <Input v-model="form.adresse" :error="Fournisseur.errors.value.adresse" :required="true">Adresse</Input>
            </div>
            <div class="col-xl-3 mb-3">
                <Input v-model="form.email" :error="Fournisseur.errors.value.email" :required="false">Email</Input>
            </div>
            <div class="col-xl-3 mb-3">
                <Input v-model="form.contact" :error="Fournisseur.errors.value.contact" :required="true">Contact</Input>
            </div>

            <div class="col-xl-6 mb-3">
                <label for="categorie" class="form-label">Catégorie
                    (<a v-if="creationCategorie" href="#" @click.prevent="creerCategorie" class="text-danger">Fermer</a>
                    <a v-else href="#" @click.prevent="creerCategorie" class="text-primary">Créer nouveau</a>)</label>
                <MultiSelect
                    v-if="!Categorie.loading.value"
                    :class="hasError ? 'border-danger' : ''"
                    :object="nouveau === false ? true : false"
                    label="libelle" valueProp="id" :multiple="true" v-model="form.categories"
                    :options="Categorie.entities.value"
                    mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                    :searchable="true" noOptionsText="Aucune catégorie" noResultsText="Aucune catégorie"
                    @close="check"
                />
                <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />

                <div class="text-danger mt-1" v-if="hasError">
                    {{ Fournisseur.errors.value.categories[0] }}
                </div>
            </div>

            <div v-if="creationCategorie" class="col-xl-12 border border-secondary shadow p-5 mb-5 mt-3">
                <CategorieFormComponent @categorie-cree="categorieCree" :nouveau="true" :type="2" />
            </div>

            <div class="col-xl-3 mb-3">
                <Input v-model="form.nif" :error="Fournisseur.errors.value.nif" :required="false">NIF</Input>
            </div>
            <div class="col-xl-3 mb-3">
                <Input v-model="form.cif" :error="Fournisseur.errors.value.cif" :required="false">CIF</Input>
            </div>
            <div class="col-xl-6 mb-3">
                <Input v-model="form.stat" :error="Fournisseur.errors.value.stat" :required="false">STAT</Input>
            </div>

            <div class="d-flex justify-content-end">
                <SaveBtn @click.prevent="save" :loading="Fournisseur.creating.value">Enregistrer</SaveBtn>
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

const Fournisseur = useCRUD('/fournisseur'); // Contient tous les fonctions CRUD pour le Fournisseur
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
        fournisseur: {
            type: Object,
            required: false,
            default: null,
        }
    },

    emits: ['frs-cree'],

    setup(props, { emit }) {
        const form = ref({
            nom: null, adresse: null,
            email: null, contact: null,
            categories: [], nif: null,
            cif: null, stat: null,
        } as Form)

        const creationCategorie: Ref<boolean> = ref(false)

        const save = async (): Promise<any> => {
            if (props.nouveau === true) {
                await Fournisseur.create(form.value)
            } else {
                const id = props.fournisseur.id
                await Fournisseur.update(id, form.value)
            }

            window.scrollTo({ top: 0, behavior: 'smooth' })
            if (Fournisseur.success.value !== null && props.nouveau === true) {
                resetForm()
                emit('frs-cree');
            }
            Fournisseur.success.value = null
        }

        const categorieCree = async (): Promise<any> => {
            creationCategorie.value = false;
            await Categorie.all(2)
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
            if (e.modelValue.length > 0) Fournisseur.errors.value.categories = null
        }

        const hasError = computed((): boolean => {
            if (Fournisseur.errors.value.categories && Fournisseur.errors.value.categories.length > 0) return true
            return false
        })

        onMounted(async (): Promise<any> => {
            if (props.nouveau === false) {
                form.value = {
                    nom: props.fournisseur.nom,
                    adresse: props.fournisseur.adresse,
                    email: props.fournisseur.email,
                    contact: props.fournisseur.contact,
                    categories: props.fournisseur.categories,
                    nif: props.fournisseur.nif,
                    cif: props.fournisseur.cif,
                    stat: props.fournisseur.stat,
                }
            }
            await Categorie.all(2)
        })

        return {
            Fournisseur, Categorie, form, save, resetForm, check, hasError, categorieCree, creerCategorie, creationCategorie,
        }
    },
});

</script>
