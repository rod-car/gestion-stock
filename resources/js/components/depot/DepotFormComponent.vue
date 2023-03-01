<template>
    <form action="" method="post">
        <div class="row">

            <div class="col-xl-6 mb-3">
                <Input v-model="form.nom" :error="errors.nom" :required="true">Nom {{
                    form.point_vente === true ? "du point de vente" : "de l'entrepot"
                }}</Input>
            </div>
            <div class="col-xl-6 mb-3">
                <Input v-model="form.localisation" :error="errors.localisation" :required="true">Localisation {{
                    form.point_vente === true ? "du point de vente" : "de l'entrepot"
                }}</Input>
            </div>
            <div class="col-xl-12 mb-3">
                <Input v-model="form.contact" :error="errors.contact">Contact</Input>
            </div>

            <div class="d-flex justify-content-end">
                <SaveBtn @click.prevent="save()" :loading="creating || updating">Enregistrer</SaveBtn>
            </div>
        </div>
    </form>
</template>

<script lang="ts">
import { defineComponent, onBeforeMount, ref, Ref } from "vue";
import Input from "../../components/html/Input.vue";
import SaveBtn from "../../components/html/SaveBtn.vue";
import useCRUD from "../../services/CRUDServices";

const { create, update, creating, updating, errors, success } = useCRUD("/depot");

type Form = {
    nom: string,
    localisation: string,
    contact: string,
    point_vente: boolean,
}

export default defineComponent({
    props: {
        nouveau: {
            type: Boolean,
            required: true,
            default: true,
        },
        depot: {
            type: Object,
            required: false,
            default: {},
        },
        pointVente: {
            type: Boolean,
            required: false,
            default: true,
        }
    },

    components: {
        Input, SaveBtn,
    },

    setup(props) {
        const form: Ref<Form> = ref({
            nom: '',
            localisation: '',
            contact: '',
            point_vente: props.pointVente,
        });

        const save = async (): Promise<any> => {
            if (props.nouveau === true) await create(form.value)
            else await update(props.depot.id, form.value, 3);

            window.scrollTo({ top: 0, behavior: 'smooth' });
            if (success.value !== null && props.nouveau === true) resetForm();
            success.value = null
        }

        const resetForm = (): void => {
            form.value = {
                nom: '',
                localisation: '',
                contact: '',
                point_vente: true,
            }
        }

        onBeforeMount(() => {
            if (props.nouveau === false && Object.keys(props.depot).length > 0) {
                form.value = {
                    nom: props.depot.nom,
                    localisation: props.depot.localisation,
                    contact: props.depot.contact,
                    point_vente: props.depot.point_vente,
                };
            }
        });

        return {
            form, creating, updating, errors, success, save,
        };
    }

});

</script>
