<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste de devis fournisseur</h5>
                    <router-link to="/devis/fournisseur/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Créer un nouveau dévis</router-link>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="text-uppercase">
                        <tr>
                            <th>Numéro</th>
                            <th>Date du dévis</th>
                            <th>Validité (Jour)</th>
                            <th>Expiré le</th>
                            <th>Fournisseur</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
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
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                        </tr>
                    </tbody>
                    <tbody v-else-if="entities.length > 0">
                        <tr v-for="(devis, index) in entities" v-bind:key="devis.id">
                            <td>{{ devis.numero }}</td>
                            <td>{{ formatDate(devis.date) }}</td>
                            <td>{{ devis.validite ?? "Non définie" }}</td>
                            <td>{{ devis.validite === null ? 'Non définie' : formatDate(expiration(devis.date, devis.validite)) }}</td>
                            <td>{{ devis.frs.nom }}</td>
                            <td><Status :value="devis.status" /></td>

                            <td class="d-flex justify-content-center">
                                <router-link v-if="true" :to="{ name: 'devis.fournisseur.voir', params: { id: devis.id }}" class="btn btn-info btn-sm me-2 text-white"><i class="fa fa-eye"></i></router-link>
                                <router-link v-if="true" :to="{ name: 'devis.fournisseur.modifier', params: { id: devis.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                                <DeleteBtn v-if="true" type="danger" @click.prevent="confirmDeletion(devis.id, index)"/>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td class="text-center" colspan="9">Aucun devis</td>
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

const { entities, loading, deleting, getEntities, deleteEntity } = useCRUD("/commandes")

export default {
    components: {
        DeleteBtn, Skeletor, Status,
    },

    setup() {
        return {
            entities, loading, deleting, getEntities, deleteEntity,
            formatDate, expiration,
        }
    },

    mounted() {
        getEntities({ type: 1, appro: true }) // Recuperer les deviss
    },

    methods: {
        /**
         * Confirmer la suppresion d'un personnel
         *
         * @param   {integr}  id  Identifiant du personnel
         *
         * @return  {void}
         */
        confirmDeletion (id, index) {
            SimpleAlert.confirm("Voulez-vous supprimer ce devis ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                deleteEntity(id, index)
            }).catch (error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce point de vente")
                }
            });
        }
    },

}
</script>
