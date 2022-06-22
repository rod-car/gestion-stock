<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Liste de catégorie de clien</h5>
                    <router-link to="/client/categorie/nouveau" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Ajouter un nouveau</router-link>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="text-uppercase">
                        <tr>
                            <th>ID</th>
                            <th>Libelle</th>
                            <th>Description</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="loading">
                        <tr v-for="i in 5" :key="i">
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                            <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                        </tr>
                    </tbody>
                    <tbody v-else-if="categories.length > 0">
                        <tr v-for="(categorie, index) in categories" v-bind:key="categorie.id">
                            <td>{{ categorie.id }}</td>
                            <td>{{ categorie.libelle }}</td>
                            <td>{{ categorie.description }}</td>
                            <td class="d-flex justify-content-center">
                                <router-link v-if="true" :to="{ name: 'client.categorie.modifier', params: { id: categorie.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                                <DeleteBtn v-if="true" type="danger" @click.prevent="confirmDeletion(categorie.id, index)"/>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td class="text-center" colspan="6">Aucun cateégorie pour le moment</td>
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
import useCategorie from '../../../services/categorie/CategorieServices';
import DeleteBtn from '../../../components/html/DeleteBtn.vue';
import { Skeletor } from 'vue-skeletor';
import Flash from '../../../functions/Flash';

const { categories, loading, deleting, getCategories, deleteCategorie } = useCategorie()

export default {
    components: {
        DeleteBtn, Skeletor,
    },

    setup() {
        return {
            categories, loading, deleting, getCategories, deleteCategorie,
        }
    },

    mounted() {
        getCategories(1) // Recuperer les categories de client
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
                deleteCategorie(id, index)
            }).catch (error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce point de vente")
                }
            });
        }
    },

}
</script>
