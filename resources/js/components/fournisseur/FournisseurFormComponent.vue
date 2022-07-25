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
                <label for="categorie" class="form-label">Catégorie</label>
                <MultiSelect v-bind:class="hasError ? 'border-danger' : ''" label="libelle" valueProp="id"
                    :multiple="true" v-model="form.categories" :options="Categorie.entities.value" mode="tags" :closeOnSelect="false"
                    :clearOnSelect="false" :searchable="true" noOptionsText="Aucune catégorie" :object="nouveau === true ? false : true"
                    noResultsText="Aucune catégorie" @close="check" />

                <div class="text-danger mt-1" v-if="hasError">
                    {{ Fournisseur.errors.value.categories[0] }}
                </div>
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

<script>

import Input from '../html/Input.vue';
import SaveBtn from '../html/SaveBtn.vue';
import MultiSelect from '@vueform/multiselect';
import useCRUD from '../../services/CRUDServices.ts';
import { computed, onMounted, ref } from 'vue';

const Fournisseur = useCRUD('/fournisseur');
const Categorie = useCRUD('/categorie');

export default {
    props: {
        nouveau: {
            type: Boolean,
            required: false,
            default: false,
        },
        fournisseur: {
            type: Object,
            required: false,
        }
    },

    components: {
        Input, SaveBtn, MultiSelect,
    },

    emits: ['frs-cree'],

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
                await Fournisseur.create(form.value);
            } else {
                const id = props.fournisseur.id;
                await Fournisseur.update(id, form.value);
            }
            window.scrollTo({ top: 0, behavior: 'smooth' })
            if (Fournisseur.success.value !== null && props.nouveau === true) {
                resetForm()
                emit('frs-cree')
            }
            Fournisseur.success.value = null
        }

        const resetForm = () => {
            setForm(null)
        }

        const setForm = (value = null) => {
            form.value = {
                nom: value === null ? null : value.nom ,
                adresse: value === null ? null : value.adresse,
                email: value === null ? null : value.email,
                contact: value === null ? null : value.contact,
                categories: value === null ? [] : value.categories,
                nif: value === null ? null : value.nif,
                cif: value === null ? null : value.cif,
                stat: value === null ? null : value.stat,
            }
        }

        const check = (e) => {
            if (e.modelValue.length > 0) Fournisseur.errors.value.categories = null
        }

        const hasError = computed(() => {
            if (Fournisseur.errors.value.categories && Fournisseur.errors.value.categories.length > 0) return true
            return false
        })

        onMounted(async () => {
            if (props.nouveau === false) {
                setForm(props.fournisseur)
            }
            await Categorie.all({ type: 2 })
        })

        return {
            Fournisseur, Categorie, form, save, resetForm, hasError, check, setForm,
        }
    },
}
</script>
