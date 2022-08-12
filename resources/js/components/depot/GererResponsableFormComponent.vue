<template>
    <div class="row">
        <div class="d-flex justify-content-between p-0">
            <div class="shadow shadow-sm p-3 me-3 w-100">
                <h3 class="">{{ depot.nom }}</h3>
                <hr>

                <h6 class="fst-italic mb-3">Adresse: {{ depot.localisation }}</h6>
                <h6 class="fst-italic text-primary">Contact: {{ depot.contact }}</h6>
            </div>

            <div class="shadow shadow-sm p-3 ms-3 w-100">
                <h5 class="text-muted mb-3">Responsables actuels</h5>
                <div>
                    <ul v-if="depot.responsables && depot.responsables.length > 0" class="list-group list-group-numbered">
                        <li v-for="responsable in depot.responsables" :key="responsable.id" class="list-group-item list-group-item-action">
                            <span class="fw-bold" v-text="responsable.nom_personnel"></span>&nbsp;
                            <span v-text="responsable.prenoms_personnel"></span>&nbsp;
                        </li>
                    </ul>

                    <ul v-else class="list-group">
                        <li class="list-group-item list-group-item-action">
                            Aucune responsable
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="col-xl-12 shadow shadow-sm p-3 mt-5">
            <form action="" method="post">
                <h5 class="text-muted mb-3">Ajouter ou supprimer un (des) responsable (s) ici</h5>

                <label for="responsables" class="form-label">Responsables</label>
                <Multiselect
                    label="nomComplet" valueProp="id" :multiple="true"
                    v-model="depot.responsables" :options="responsables" mode="tags"
                    :object="true"
                    :closeOnSelect="false" :clearOnSelect="false" :searchable="true"
                    placeholder="Selectionner les responsables"
                />

                <div class="d-flex justify-content-end mt-3">
                    <SaveBtn @click.prevent="save(depot.id)" :loading="updating">Enregistrer</SaveBtn>
                </div>
            </form>
        </div>
    </div>
</template>

<script lang="ts">

import { Skeletor } from "vue-skeletor";
import Multiselect from '@vueform/multiselect';
import SaveBtn from '../../components/html/SaveBtn.vue';
import useCRUD from "../../services/CRUDServices";
import { defineComponent } from "vue";

const { update, updating, success } = useCRUD('/depot');

export default defineComponent({
    components: {
        Skeletor, Multiselect, SaveBtn,
    },

    props: {
        depot: {
            type: Object,
            required: true,
        },
        responsables: {
            type: Array<any>,
            required: true,
        }
    },

    setup(props) {
        const save = async (id: number): Promise<any> => {
            const updateType = 1 // Mise a jour de responsable
            await update(id, props.depot, updateType);

            window.scrollTo({ top: 0, behavior: "smooth" });
            success.value = null
        }

        return {
            save, updating,
        };
    },
});

</script>
