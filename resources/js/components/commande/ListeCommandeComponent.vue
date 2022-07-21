<template>
    <table class="table table-striped">
        <thead class="bg-secondary text-white">
            <tr>
                <th class="p-3">Numéro</th>
                <th class="p-3">Date de création</th>
                <th v-if="appro === true">Fournisseur</th>
                <th v-else>Client</th>
                <th class="p-3">Adresse de livraison</th>
                <th class="p-3">Status</th>
                <th class="text-center p-3">Actions</th>
            </tr>
        </thead>
        <tbody v-if="entities.length > 0">
            <tr v-for="(commande, index) in entities" v-bind:key="commande.id">
                <td>{{ commande.numero }}</td>
                <td>{{ formatDate(commande.date) }}</td>
                <td v-if="appro === true">{{ commande.frs.nom }}</td>
                <td v-else>{{ commande.cl.nom }}</td>
                <td>{{ commande.adresse_livraison }}</td>
                <td><Status :value="commande.status" /></td>

                <td class="d-flex justify-content-center">
                    <router-link v-if="true" :to="{ name: `commande.${type}.voir`, params: { id: commande.id }}" class="btn btn-info btn-sm me-2 text-white"><i class="fa fa-eye"></i></router-link>
                    <router-link v-if="true" :to="{ name: `commande.${type}.modifier`, params: { id: commande.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <DeleteBtn v-if="true" type="danger" @click.prevent="confirmDeletion(commande.id, index)"/>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td class="text-center" colspan="9">Aucune commande</td>
            </tr>
        </tbody>
    </table>
</template>

<script>

import { formatDate, expiration } from '../../functions/functions';
import { computed } from 'vue';
import { Skeletor } from 'vue-skeletor';
import Flash from '../../functions/Flash';
import useCRUD from '../../services/CRUDServices';
import DeleteBtn from '../html/DeleteBtn.vue';
import Status from '../html/Status.vue';

const Commande = useCRUD('/commandes')

export default {
    components: {
        Skeletor, DeleteBtn, Status,
    },

    props: {
        entities: {
            type: Array,
            required: true,
        },
        appro: {
            type: Boolean,
            default: true,
            required: false,
        },
    },

    setup(props) {

        /**
         * Confirmer la suppresion d'un personnel
         *
         * @param   {integr}  id  Identifiant du personnel
         * @return  {void}
         */
        const confirmDeletion = (id, index) => {
            SimpleAlert.confirm("Voulez-vous supprimer la commande ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                Commande.deleteEntity(id, index)
            }).catch (error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce point de vente")
                }
            });
        }

        const type = computed(() => {
            if (props.appro === true) return "fournisseur"
            return "client"
        })

        return {
            Flash, formatDate, expiration, Commande, confirmDeletion, type,
        }
    }

}

</script>
