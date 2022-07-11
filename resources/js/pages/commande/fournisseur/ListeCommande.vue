<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste de commande fournisseur</h5>
                    <router-link to="/commande/fournisseur/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Créer une nouvelle commande</router-link>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th class="p-3">Numéro</th>
                            <th class="p-3">Date de création</th>
                            <th class="p-3">Fournisseur</th>
                            <th class="p-3">Adresse de livraison</th>
                            <th class="p-3">Status</th>
                            <th class="text-center p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="loading">
                        <tr v-for="i in 5" :key="i">
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                        </tr>
                    </tbody>
                    <tbody v-else-if="entities.length > 0">
                        <tr v-for="(commande, index) in entities" v-bind:key="commande.id">
                            <td>{{ commande.numero }}</td>
                            <td>{{ formatDate(commande.date) }}</td>
                            <td>{{ commande.frs.nom }}</td>
                            <td>{{ commande.adresse_livraison ?? "Non définie" }}</td>
                            <td><Status :value="commande.status" /></td>

                            <td class="d-flex justify-content-center">
                                <router-link v-if="true" :to="{ name: 'commande.fournisseur.voir', params: { id: commande.id }}" class="btn btn-info btn-sm me-2 text-white"><i class="fa fa-eye"></i></router-link>
                                <router-link v-if="true" :to="{ name: 'commande.fournisseur.modifier', params: { id: commande.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
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

                <!--div class="pagination">
                    <pagination align="center" :data="personnelles" @pagination-change-page="getPersonnelles"></pagination>
                </div-->
            </div>
        </div>
    </div>
</template>

<script>

import { Skeletor } from 'vue-skeletor';
import Flash from '../../../functions/Flash';
import useCRUD from '../../../services/CRUDServices';
import DeleteBtn from '../../../components/html/DeleteBtn.vue';
import Status from '../../../components/html/Status.vue';
import { formatDate, expiration } from '../../../functions/functions';
import { onMounted } from 'vue';

const { entities, loading, deleting, getEntities, deleteEntity } = useCRUD("/commandes")

export default {
    components: {
        DeleteBtn, Skeletor, Status,
    },

    setup() {

        /**
         * Confirmer la suppresion d'un personnel
         *
         * @param   {integr}  id  Identifiant du personnel
         * @return  {void}
         */
        const confirmDeletion = (id, index) => {
            SimpleAlert.confirm("Voulez-vous supprimer cette commande ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                deleteEntity(id, index)
            }).catch (error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce point de vente")
                }
            });
        }

        onMounted(() => {
            getEntities({ type: 2, appro: true }) // Recuperer tous les commandes de fournisseurs
        })

        return {
            entities, loading, deleting, getEntities, deleteEntity,
            formatDate, expiration, confirmDeletion,
        }
    },

}
</script>
