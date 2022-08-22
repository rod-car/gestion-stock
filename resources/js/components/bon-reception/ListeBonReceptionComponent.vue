<template>
    <table class="table table-striped">
        <thead class="bg-secondary text-white">
            <tr>
                <th class="p-3">Numéro</th>
                <th class="p-3">Date de création</th>
                <th class="p-3">Bon de commande</th>
                <th class="p-3">Fournisseur</th>
                <th class="p-3">Adresse de livraison</th>
                <th class="p-3">Status</th>
                <th class="text-center p-3">Actions</th>
            </tr>
        </thead>
        <tbody v-if="entities.length > 0">
            <tr v-for="(reception, index) in entities" :key="reception.id">
                <td class="align-middle">{{ reception.numero }}</td>
                <td class="align-middle">{{ formatDate(reception.date, false) }}</td>
                <td class="align-middle">{{ reception.get_commande.numero }}</td>
                <td class="align-middle">{{ reception.get_commande.frs.nom }}</td>
                <td class="align-middle">{{ reception.adresse_livraison ?? "Non définie" }}</td>
                <td class="align-middle"><Status :value="reception.status" /></td>

                <td class="d-flex justify-content-center">
                    <router-link title="Voir ce bon de reception" v-if="true" :to="{ name: `bon-reception.voir`, params: { id: reception.id }}" class="btn btn-info btn-sm me-2 text-white"><i class="fa fa-eye"></i></router-link>
                    <router-link title="Modifier ce bon de reception" v-if="true" :to="{ name: `bon-reception.modifier`, params: { id: reception.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <DeleteBtn title="Supprimer ce bon de reception" v-if="true" type="danger" @click.prevent="confirmDeletion(reception.id, index)"/>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td class="text-center" colspan="9">Aucune bon de reception</td>
            </tr>
        </tbody>
    </table>

    <input type="tel" name="" input-mask="000 00 000 00" id="">
</template>

<script lang="ts">
import { formatDate, expiration } from '../../functions/functions';
import Flash from '../../functions/Flash';
import useCRUD from '../../services/CRUDServices';
import DeleteBtn from '../html/DeleteBtn.vue';
import SimpleAlert from 'vue3-simple-alert';
import Status from '../html/Status.vue';

const { destroy } = useCRUD('/commandes')

export default {
    components: {
        DeleteBtn,
        SimpleAlert,
        Status
    },

    props: {
        entities: {
            type: Array,
            required: true,
        },
    },

    setup(props: { entities: any[] }) {
        const confirmDeletion = async (id: number, index: number): Promise<any> => {
            await SimpleAlert.confirm("Voulez-vous supprimer la commande ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                destroy(id, props.entities, index)
            }).catch (error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce point de vente")
                }
            });
        }

        return {
            Flash, formatDate, expiration, confirmDeletion,
        }
    }

}

</script>
