<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste de point de vente</h5>
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
                    <tbody v-else-if="entities.length > 0">
                        <tr v-for="(depot, index) in entities" v-bind:key="depot.id">
                            <td>{{ depot.id }}</td>
                            <td>{{ depot.nom }}</td>
                            <td>{{ depot.localisation }}</td>
                            <td>{{ depot.contact }}</td>
                            <td>
                                <span class="badge bg-danger text-white fs-6 me-2" v-for="responsable in depot.responsables" :key="responsable.id">{{ responsable.nomComplet }}</span>
                            </td>
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

import DeleteBtn from '../../components/html/DeleteBtn.vue';
import { Skeletor } from 'vue-skeletor';
import Flash from '../../functions/Flash';
import useCRUD from '../../services/CRUDServices';

const { entities, loading, deleting, all, destroy } = useCRUD('/depot')

export default {
    components: {
        DeleteBtn, Skeletor,
    },

    setup() {
        return {
            entities, loading, deleting, all, destroy,
        }
    },

    mounted() {
        all({type: 1})
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
                destroy(id, index)
            }).catch (error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce point de vente")
                }
            });
        }
    },

}

</script>
