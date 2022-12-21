<template>
    <table class="table table-striped">
        <thead class="bg-secondary text-white">
            <tr>
                <th>Numéro</th>
                <th>Date de création</th>
                <th>Bon de commande</th>
                <th>Client</th>
                <th>Adresse de livraison</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody v-if="entities.length > 0">
            <tr v-for="(livraison, index) in entities" :key="livraison.id">
                <td class="align-middle">{{ livraison.numero }}</td>
                <td class="align-middle">{{ formatDate(livraison.date, false) }}</td>
                <td class="align-middle">{{ livraison.get_commande.numero }}</td>
                <td class="align-middle">{{ livraison.get_commande.cl.nom }}</td>
                <td class="align-middle">{{ livraison.adresse_livraison ?? "Non définie" }}</td>
                <td class="align-middle"><Status :value="livraison.status" /></td>

                <td class="d-flex justify-content-center">
                    <router-link title="Voir ce bon de livraison" v-if="true" :to="{ name: `bon-livraison.voir`, params: { id: livraison.id }}" class="btn btn-info btn-sm me-2 text-white"><i class="fa fa-eye"></i></router-link>
                    <!-- <router-link title="Modifier ce bon de livraison" v-if="true" :to="{ name: `bon-livraison.modifier`, params: { id: livraison.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link> -->
                    <DeleteBtn title="Supprimer ce bon de livraison" v-if="true" type="danger" @click.prevent="confirmDeletion(livraison.id, index)"/>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td class="text-center" colspan="9">Aucune bon de livraison</td>
            </tr>
        </tbody>
    </table>

    <!--input type="tel" class="form-control" @maska="phone = $event.target.dataset.maskRawValue" v-maska="'### ## ### ## - ### ## ### ##'" id=""-->
</template>

<script lang="ts">
import { formatDate, expiration } from '../../functions/functions';
import Flash from '../../functions/Flash';
import useCRUD from '../../services/CRUDServices';
import DeleteBtn from '../html/DeleteBtn.vue';
import SimpleAlert from 'vue3-simple-alert';
import Status from '../html/Status.vue';

const { destroy } = useCRUD('/bon-livraisons')

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
            await SimpleAlert.confirm("Voulez-vous supprimer le bon de livraison ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                destroy(id, props.entities, index)
            }).catch (error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce bon de livraison")
                }
            });
        }

        return {
            formatDate, expiration, confirmDeletion,
        }
    }

}

</script>
