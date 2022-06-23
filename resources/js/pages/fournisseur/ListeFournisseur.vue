<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste des fournisseurs</h5>
                    <router-link to="/fournisseur/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Ajouter un nouveau</router-link>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="text-uppercase">
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
                    <tbody v-if="loading">
                        <tr v-for="i in 5" :key="i">
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                        </tr>
                    </tbody>
                    <tbody v-else-if="fournisseurs.length > 0">
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
                            <td class="text-center" colspan="9">Aucun cateégorie pour le moment</td>
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

import DeleteBtn from '../../components/html/DeleteBtn.vue';
import { Skeletor } from 'vue-skeletor';
import Flash from '../../functions/Flash';
import useFournisseur from '../../services/fournisseur/FournisseurServices';

const { fournisseurs, loading, deleting, getFournisseurs, deleteFournisseur } = useFournisseur()

export default {
    components: {
        DeleteBtn, Skeletor,
    },

    setup() {
        return {
            fournisseurs, loading, deleting, getFournisseurs, deleteFournisseur,
        }
    },

    mounted() {
        getFournisseurs() // Recuperer les Fournisseurs
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
            SimpleAlert.confirm("Voulez-vous supprimer ce point de vente ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                deleteFournisseur(id, index)
            }).catch (error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce point de vente")
                }
            });
        }
    },

}
</script>
