<template>
    <table class="table table-striped table-hover">
        <thead class="bg-secondary text-white">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Contact</th>
                <th>Email</th>
                <th>NIF</th>
                <th>CIF</th>
                <th>STAT</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody v-if="fournisseurs.length > 0">
            <tr v-for="(fournisseur, index) in fournisseurs" v-bind:key="fournisseur.id">
                <td>{{ fournisseur.id }}</td>
                <td>{{ fournisseur.nom }}</td>
                <td>{{ fournisseur.adresse }}</td>
                <td>{{ fournisseur.contact }}</td>
                <td>{{ fournisseur.email ?? "Non définie" }}</td>
                <td>{{ fournisseur.nif ?? "Non définie" }}</td>
                <td>{{ fournisseur.cif ?? "Non définie" }}</td>
                <td>{{ fournisseur.stat ?? "Non définie" }}</td>
                <td class="d-flex justify-content-center">
                    <router-link v-if="true" :to="{ name: 'fournisseur.voir', params: { id: fournisseur.id }}" class="btn btn-info btn-sm me-2 text-white"><i class="fa fa-eye"></i></router-link>
                    <router-link v-if="true" :to="{ name: 'fournisseur.modifier', params: { id: fournisseur.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <DeleteBtn v-if="true" type="danger" @click.prevent="confirmDeletion(fournisseur.id, index)"/>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td class="text-center" colspan="9">Aucun fournisseur</td>
            </tr>
        </tbody>
    </table>
</template>

<script lang="ts">
import Flash from '../../functions/Flash';
import useCRUD from '../../services/CRUDServices';
import DeleteBtn from '../../components/html/DeleteBtn.vue';
import { defineComponent } from 'vue';
import VueSimpleAlert from 'vue3-simple-alert';

const { deleting, destroy } = useCRUD("/fournisseur")

export default defineComponent({
    components: {
        DeleteBtn,
    },

    props: {
        fournisseurs: {
            type: Array<any>,
            required: true,
        }
    },

    setup(props) {
        const confirmDeletion = async (id: number, index: number): Promise<any> => {
            VueSimpleAlert.confirm("Voulez-vous supprimer ce fournisseur ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                destroy(id, props.fournisseurs, index)
            }).catch(error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce fournisseur")
                }
            });
        }

        return {
            deleting, destroy, confirmDeletion,
        }
    },

});

</script>
