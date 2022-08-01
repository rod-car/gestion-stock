<template>
    <form action="" method="post">
        <div class="row">
            <div class="col-xl-12 mb-3">
                <Input v-model="form.libelle" :error="errors.libelle" :required="true">Nom de la catégorie</Input>
            </div>
            <div class="col-xl-12 mb-3">
                <Input type="textarea" v-model="form.description" :error="errors.description">Description de la catégorie</Input>
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
import { defineComponent, Ref, ref } from 'vue';
import useCRUD from '../../services/CRUDServices';

const { creating, errors, success, create, updating, update } = useCRUD("/categorie");

interface Form {
    libelle: string | null,
    description: string | null,
    type: number,
}

export default defineComponent({
    props: {
        nouveau: {
            type: Boolean,
            required: false,
            default: true,
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
        const form: Ref<Form> = ref({
            libelle: props.categorie === null ? null : props.categorie.libelle,
            description: props.categorie === null ? null : props.categorie.description,
            type: props.type, // Catégorie client
        });

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

        return {
            creating, errors, form, save, updating,
        }
    },

    components: {
        Input, SaveBtn,
    },

});

</script>
