<template>
    <table class="table table-striped">
        <thead class="bg-secondary text-white">
            <tr>
                <th>Numéro</th>
                <th>Date de facturation</th>
                <th>Date de vente</th>
                <th>Client / Fournisseur</th>
                <th>Echéance</th>
                <th>Taux de penalité</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody v-if="factures.length > 0">
            <tr v-for="(facture, index) in factures" :key="facture.id">
                <td class="align-middle">{{ facture.numero_facture }}</td>
                <td class="align-middle">{{ formatDate(facture.date_facturation, false) }}</td>
                <td class="align-middle">{{ formatDate(facture.date_vente, false) }}</td>
                <td class="align-middle">{{ "Client ou Fourniseur" }}</td>
                <td class="align-middle">{{ facture.echeance }} Jours</td>
                <td class="align-middle">{{ format(facture.taux_penalite) }}</td>

                <td class="d-flex justify-content-center">
                    <router-link title="Voir la facture" v-if="true" :to="{ name: `facture.voir`, params: { id: facture.id }}" class="btn btn-info btn-sm me-2 text-white"><i class="fa fa-eye"></i></router-link>
                    <router-link title="Modifier la facture" v-if="true" :to="{ name: `facture.modifier`, params: { id: facture.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <DeleteBtn title="Supprimer la facture" v-if="true" type="danger" @click.prevent="confirmDeletion(facture.id, index)"/>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td class="text-center" colspan="9">Aucune facture</td>
            </tr>
        </tbody>
    </table>
</template>

<script lang="ts">
import { formatDate, expiration, format } from '../../functions/functions';
import Flash from '../../functions/Flash';
import useCRUD from '../../services/CRUDServices';
import DeleteBtn from '../html/DeleteBtn.vue';
import SimpleAlert from 'vue3-simple-alert';
import Status from '../html/Status.vue';

const { destroy } = useCRUD('/factures')

export default {
    components: {
        DeleteBtn,
        SimpleAlert,
        Status
    },

    props: {
        factures: {
            type: Array,
            required: true,
        },
    },

    setup(props: { factures: any[] }) {

        const confirmDeletion = async (id: number, index: number): Promise<any> => {
            await SimpleAlert.confirm("Voulez-vous supprimer ce facture ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                destroy(id, props.factures, index)
            }).catch (error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer cette facture")
                }
            });
        }

        return {
            formatDate, expiration, confirmDeletion, format,
        }
    }

}

</script>
