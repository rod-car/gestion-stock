<template>
    <table class="table table-striped table-hover">
        <thead class="text-uppercase">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Localisation</th>
                <th>Contact</th>
                <th>Responsables</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody v-if="depots.length > 0">
            <tr v-for="(depot, index) in depots" v-bind:key="depot.id">
                <td>{{ depot.id }}</td>
                <td>{{ depot.nom }}</td>
                <td>{{ depot.localisation }}</td>
                <td>{{ depot.contact }}</td>
                <td>
                    <span class="badge bg-danger text-white fs-6 me-2" v-for="responsable in depot.responsables" :key="responsable.id">{{ responsable.nomComplet }}</span>
                </td>
                <td class="d-flex justify-content-center">
                    <router-link :to="{ name: 'point-de-vente.voir', params: { id: depot.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-eye"></i></router-link>
                    <router-link v-if="$can('edit_point_vente')" :to="{ name: 'point-de-vente.modifier', params: { id: depot.id }}" class="btn btn-info btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <form v-if="$can('delete_point_vente')" action="" method="post">
                        <DeleteBtn type="danger" @click.prevent="confirmDeletion(depot.id, index)"/>
                    </form>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td class="text-center" colspan="6">Aucune point de vente</td>
            </tr>
        </tbody>
    </table>
</template>

<script lang="ts">
import useCRUD from "../../services/CRUDServices";
import { defineComponent } from "vue";
import Flash from "../../functions/Flash";
import VueSimpleAlert from "vue3-simple-alert";
import DeleteBtn from '../../components/html/DeleteBtn.vue';

const { deleting, destroy } = useCRUD('/depot');

export default defineComponent({
    props: {
        depots: {
            type: Array<any>,
            required: true,
        }
    },

    setup() {

        /**
         * Confirmer la suppresion d'un personnel
         *
         * @param   {Number}  id  Identifiant du personnel
         * @param   {Number | null}  index Indice de l'element dans la liste
         *
         * @return  {Promise}
         */
        const confirmDeletion = async (id: number, index: number): Promise<any> => {
            await VueSimpleAlert.confirm("Voulez-vous supprimer ce point de vente ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                destroy(id, index)
            }).catch((error: undefined) => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce point de vente")
                }
            });
        }

        return {
            confirmDeletion, deleting, destroy,
        };
    },

    components: {
        DeleteBtn,
    },

});

</script>
