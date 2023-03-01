<template>
    <form action="" method="post">
        <div class="row">
            <div class="col-xl-12 mb-3">
                <Input v-model="form.libelle" :error="errors.libelle" :required="true">Nom de l'étiquette</Input>
            </div>

            <div class="col-xl-12 mb-3">
                <Input type="textarea" v-model="form.description" :error="errors.description">Description de
                l'étiquette</Input>
            </div>

        </div>
        <div class="d-flex justify-content-end">
            <SaveBtn @click.prevent="save" :loading="creating || updating">Enregistrer</SaveBtn>
        </div>
    </form>
</template>
<script lang="ts">

import SaveBtn from '../../components/html/SaveBtn.vue';
import Input from '../../components/html/Input.vue';
import Multiselect from '@vueform/multiselect';

import { computed, defineComponent, onMounted, Ref, ref } from 'vue';
import useCRUD from '../../services/CRUDServices';

const { creating, errors, success, create, updating, update, all, loading, entities } = useCRUD("/etiquette");

interface Form {
    libelle: string | null,
    description: string | null,
    type: string,
}

export default defineComponent({
    components: {
        Input, SaveBtn, Multiselect
    },
    props: {
        nouveau: {
            type: Boolean,
            required: true,
        },
        etiquette: {
            type: Object,
            required: false,
            default: null,
        },

        type: {
            type: String,
            required: true,
        }
    },
    setup(props) {

        const form = ref({
            libelle: props.etiquette === null ? null : props.etiquette.libelle,
            description: props.etiquette === null ? null : props.etiquette.description,
            type: props.type, // Catégorie client
        } as Form);


        const save = async () => {
            if (props.nouveau) await create(form.value)
            else if (props.etiquette !== null) await update(props.etiquette.id, form.value);
            else throw new Error("Vous devez specifier l'étiquette a modifier")

            window.scrollTo({ top: 0, behavior: 'smooth' });
            if (success.value !== null && props.nouveau) {

            }
            success.value = null
        }

        return {
            save, form, errors, creating, updating
        }
    }
})
</script>
