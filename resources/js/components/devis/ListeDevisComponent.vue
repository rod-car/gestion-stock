<template>
    <table class="table table-striped">
        <thead class="bg-secondary text-white">
            <tr>
                <th class="p-3">Numéro</th>
                <th class="p-3">Date du dévis</th>
                <th class="p-3">Validité (Jour)</th>
                <th class="p-3">Expiré le</th>
                <th v-if="appro === true" class="p-3">Fournisseur</th>
                <th v-else class="p-3">Client</th>
                <th class="p-3">Status</th>
                <th class="text-center p-3">Actions</th>
            </tr>
        </thead>
        <tbody v-if="entities.length > 0">
            <tr v-for="(devis, index) in entities" v-bind:key="devis.id">
                <td class="align-middle">{{ devis.numero }}</td>
                <td class="align-middle">{{ formatDate(devis.date, false) }}</td>
                <td class="align-middle">{{ devis.validite ?? "Non définie" }}</td>
                <td class="align-middle">{{ devis.validite === null ? 'Non définie' : formatDate(expiration(devis.date, devis.validite), false) }}</td>
                <td class="align-middle" v-if="appro === true">{{ devis.frs.nom }}</td>
                <td class="align-middle" v-else>{{ devis.cl.nom }}</td>
                <td class="align-middle"><Status :value="devis.status" /></td>

                <td class="d-flex justify-content-center">
                    <router-link title="Voir ce devis" v-if="true" :to="{ name: `devis.${type}.voir`, params: { id: devis.id }}" class="btn btn-info btn-sm me-2 text-white"><i class="fa fa-eye"></i></router-link>
                    <router-link title="Modifier ce devis" v-if="true" :to="{ name: `devis.${type}.modifier`, params: { id: devis.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <router-link title="Créer un bon de commande pour ce devis" v-if="devis.status === 1" :to="{ name: `commande.${type}.nouveau`, query: { devis: devis.id }}" class="btn btn-warning btn-sm me-2 text-white"><i class="fa fa-arrow-right"></i></router-link>
                    <DeleteBtn title="Supprimer ce devis" v-if="true" type="danger" @click.prevent="confirmDeletion(devis.id, index)"/>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td class="text-center" colspan="9">Aucun devis</td>
            </tr>
        </tbody>
    </table>
</template>

<script lang="ts">
import { formatDate, expiration } from '../../functions/functions';
import { computed, defineComponent } from 'vue';
import Flash from '../../functions/Flash';
import DeleteBtn from '../html/DeleteBtn.vue';
import useCRUD from '../../services/CRUDServices';
import SimpleAlert from 'vue3-simple-alert';
import Status from '../html/Status.vue';

const { destroy } = useCRUD('/commandes');

export default defineComponent({
    components: {
    DeleteBtn,
        SimpleAlert,
        Status
    },

    props: {
        entities: {
            type: Array<any>,
            required: true,
        },
        appro: {
            type: Boolean,
            default: true,
            required: false,
        },
        commande: {
            type: Boolean,
            default: false,
            required: false,
        },
    },

    setup(props) {
        const confirmDeletion = async (id: number, index: number): Promise<any> => {
            await SimpleAlert.confirm("Voulez-vous supprimer ce devis ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                destroy(id, props.entities,index)
            }).catch((error: undefined) => {
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
            Flash, formatDate, expiration, destroy, confirmDeletion, type,
        }
    }

});

</script>
