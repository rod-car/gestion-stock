<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-uppercase text-info">Liste de point de vente</h5>
                    <router-link to="/point-de-vente/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Ajouter un nouveau</router-link>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="text-uppercase">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Localisation</th>
                            <th>Contact</th>
                            <th>Responsables</th>
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
                        </tr>
                    </tbody>
                    <tbody v-else-if="depots.length > 0">
                        <tr v-for="(depot, index) in depots" v-bind:key="depot.id">
                            <td>{{ depot.id }}</td>
                            <td>{{ depot.nom }}</td>
                            <td>{{ depot.localisation }}</td>
                            <td>{{ depot.contact }}</td>
                            <td>{{ "Rakoto, Beloha" }}</td>
                            <td class="d-flex justify-content-center">
                                <router-link :to="{ name: 'point-de-vente.voir', params: { id: depot.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-eye"></i></router-link>
                                <router-link v-if="$can('edit_point_vente')" :to="{ name: 'point-de-vente.modifier', params: { id: depot.id }}" class="btn btn-info btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                                <form v-if="$can('delete_point_vente')" action="" method="post">
                                    <DeleteBtn type="danger" @click.prevent="confirmDeletion(depot.id, index)"/>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td class="text-center" colspan="6">Aucune point de vente</td>
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
import useDepot from '../../../services/DepotServices';
import DeleteBtn from '../../html/DeleteBtn.vue';
import { Skeletor } from 'vue-skeletor';
import Flash from '../../../functions/Flash';

const { depots, loading, getDepots, deleteDepot } = useDepot()

export default {
    components: {
        DeleteBtn, Skeletor,
    },
    setup() {
        return {
            depots, loading, getDepots,
        }
    },

    mounted() {
        getDepots()
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
                deleteDepot(id)
                depots.value.splice(index)
                Flash('success', "Message de succès", "Le point de vente est supprimé avec succès")
            }).catch (error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce point de vente")
                }
            });
        }
    },

}
</script>
