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
                    <router-link :to="{ name: `${getName}.voir`, params: { id: depot.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-eye"></i></router-link>
                    <router-link v-if="$can(editAccess)" :to="{ name: `${getName}.modifier`, params: { id: depot.id }}" class="btn btn-info btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <form v-if="$can(deleteAccess)" action="" method="post">
                        <DeleteBtn type="danger" @click.prevent="confirmDeletion(depot.id, index)"/>
                    </form>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td class="text-center" colspan="6">Aucun élément</td>
            </tr>
        </tbody>
    </table>
</template>

<script lang="ts">
import useCRUD from "../../services/CRUDServices";
import { computed, defineComponent } from "vue";
import Flash from "../../functions/Flash";
import VueSimpleAlert from "vue3-simple-alert";
import DeleteBtn from '../../components/html/DeleteBtn.vue';

const { deleting, destroy } = useCRUD('/depot');

export default defineComponent({
    props: {
        depots: {
            type: Array<any>,
            required: true,
        },
        entrepot: {
            type: Boolean,
            required: true,
            default: false,
        },
    },

    setup(props) {

        const getName = computed((): string => {
            if (props.entrepot === true) return "entrepot";
            return "point-de-vente";
        })

        const editAccess = computed((): string => {
            if (props.entrepot === true) return "edit_entrepot";
            return "edit_point_vente";
        })

        const deleteAccess = computed((): string => {
            if (props.entrepot === true) return "delete_entrepot";
            return "delete_point_vente";
        })

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
            confirmDeletion, deleting, destroy, getName, editAccess, deleteAccess,
        };
    },

    components: {
        DeleteBtn,
    },

});

</script>
