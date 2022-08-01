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
        <tbody v-if="clients.length > 0">
            <tr v-for="(client, index) in clients" v-bind:key="client.id">
                <td>{{ client.id }}</td>
                <td>{{ client.nom }}</td>
                <td>{{ client.adresse }}</td>
                <td>{{ client.contact }}</td>
                <td>{{ client.email ?? "Non définie" }}</td>
                <td>{{ client.nif ?? "Non définie" }}</td>
                <td>{{ client.cif ?? "Non définie" }}</td>
                <td>{{ client.stat ?? "Non définie" }}</td>
                <td class="d-flex justify-content-center">
                    <router-link v-if="true" :to="{ name: 'client.voir', params: { id: client.id }}" class="btn btn-info btn-sm me-2 text-white"><i class="fa fa-eye"></i></router-link>
                    <router-link v-if="true" :to="{ name: 'client.modifier', params: { id: client.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <DeleteBtn v-if="true" type="danger" @click.prevent="confirmDeletion(client.id, index)"/>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td class="text-center" colspan="9">Aucun client</td>
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

const { deleting, destroy } = useCRUD("/client")

export default defineComponent({
    components: {
        DeleteBtn,
    },

    props: {
        clients: {
            type: Array<any>,
            required: true,
        }
    },

    setup() {
        const confirmDeletion = async (id: number, index: number): Promise<any> => {
            VueSimpleAlert.confirm("Voulez-vous supprimer ce client ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                destroy(id, index)
            }).catch(error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce point de vente")
                }
            });
        }

        return {
            deleting, destroy, confirmDeletion,
        }
    },

});

</script>
