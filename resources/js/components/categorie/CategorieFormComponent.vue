<template>
    <form action="" method="post">
        <div class="row">
            <div class="col-xl-12 mb-3">
                <Input v-model="form.libelle" :error="errors.libelle" :required="true">Nom de la catégorie</Input>
            </div>

            <div v-if="type === 3" class="col-xl-12 mb-3">
                <label for="sous_categories" class="form-label">Sous catégories</label>
                <Multiselect :class="hasError ? 'border-danger' : ''" label="libelle" valueProp="id" :multiple="true"
                    v-model="form.sous_categories" :options="entities" mode="tags" :closeOnSelect="false"
                    :clearOnSelect="false" :searchable="true" placeholder="Selectionner les sous catégories"
                    :object="nouveau === false ? true : false" noOptionsText="Aucune catégorie"
                    noResultsText="Aucune catégorie" />
                <div class="text-danger mt-1" v-if="hasError">
                    {{ errors.sous_categories[0] }}
                </div>
            </div>


            <div class="col-xl-12 mb-3">
                <Input type="textarea" v-model="form.description" :error="errors.description">Description de la
                catégorie</Input>
            </div>
            <div class="d-flex justify-content-end">
                <SaveBtn @click.prevent="save" :loading="creating || updating">Enregistrer</SaveBtn>
            </div>
        </div>
    </form>
</template>

<script lang="ts">

import SaveBtn from '../../components/html/SaveBtn.vue';
import Input from '../../components/html/Input.vue';
import { computed, defineComponent, onMounted, Ref, ref } from 'vue';
import useCRUD from '../../services/CRUDServices';
import Multiselect from '@vueform/multiselect';

const { creating, errors, success, create, updating, update, all, loading, entities } = useCRUD("/categorie");

interface Form {
    libelle: string | null,
    description: string | null,
    type: number,
    sous_categories?: Array<any> | null
}

export default defineComponent({
    props: {
        nouveau: {
            type: Boolean,
            required: true,
        },

        categorie: {
            type: Object,
            required: false,
            default: null,
        },

        type: {
            type: Number,
            required: true,
        }
    },

    emits: ['categorie-cree'],

    setup(props, { emit }) {
        const form = ref({
            libelle: props.categorie === null ? null : props.categorie.libelle,
            description: props.categorie === null ? null : props.categorie.description,
            type: props.type, // Catégorie client
            sous_categories: (props.nouveau === false && props.categorie !== null) ? props.categorie.sous_categories : []
        } as Form);

        const save = async (): Promise<any> => {
            if (props.nouveau) await create(form.value)
            else if (props.categorie !== null) await update(props.categorie.id, form.value);
            else throw new Error("Vous devez specifier la categorie a modifier")

            window.scrollTo({ top: 0, behavior: 'smooth' });
            if (success.value !== null && props.nouveau) {
                resetForm()
                emit('categorie-cree');
            }
            success.value = null
        }

        const resetForm = (): void => {
            form.value = {
                libelle: null,
                description: null,
                type: props.type,
            }
        }

        const hasError = computed((): boolean => {
            if (errors.value.sous_categories && errors.value.sous_categories.length > 0) return true
            return false
        });

        onMounted(async (): Promise<any> => {
            if (props.type === 3 && props.nouveau === false) await all(3, props.categorie.id);
            await all(3);
        })

        return {
            creating, errors, form, save, updating, loading, entities, hasError,
        }
    },

    components: {
        Input, SaveBtn, Multiselect,
    },

});

</script>
