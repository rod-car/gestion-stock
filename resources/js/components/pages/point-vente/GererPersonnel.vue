<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 v-if="!loading" class="text-info">Gerer les personnelles du point de vente N° {{ depot.id }}</h5>
                    <Skeletor v-else width="50%" height="30" style="border-radius: 5px" />

                    <router-link v-if="$can('view_point_vente')" to="/point-de-vente/liste" class="btn btn-primary me-2">
                        <i class="fa fa-list me-2"></i>Liste des point de vente
                    </router-link>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="d-flex justify-content-between p-0">
                        <div class="shadow shadow-sm p-3 me-3 w-100">
                            <h3 class="" v-if="!loading">{{ depot.nom }}</h3>
                            <Skeletor v-else width="100%" height="40" style="border-radius: 5px" />
                            <hr>

                            <h6 v-if="!loading" class="fst-italic mb-3">Adresse: {{ depot.localisation }}</h6>
                            <Skeletor v-else width="75%" height="30" style="border-radius: 5px; margin-bottom: 1rem !important" />

                            <h6 v-if="!loading" class="fst-italic text-primary">Contact: {{ depot.contact }}</h6>
                            <Skeletor v-else width="50%" height="30" style="border-radius: 5px; margin-bottom: 1rem !important"/>
                        </div>

                        <div class="shadow shadow-sm p-3 ms-3 w-100">
                            <h5 class="mb-3 text-muted">Personnelles actuels</h5>
                            <div v-if="!loading">
                                <ul v-if="depot.travailleurs && depot.travailleurs.length > 0" class="list-group list-group-numbered">
                                    <li v-for="travailleur in depot.travailleurs" :key="travailleur.id" class="list-group-item list-group-item-action">
                                        <span class="fw-bold" v-text="travailleur.nom_personnel"></span>&nbsp;
                                        <span v-text="travailleur.prenoms_personnel"></span>&nbsp;
                                    </li>
                                </ul>

                                <ul v-else class="list-group">
                                    <li class="list-group-item list-group-item-action">
                                        Aucune personnelles qui travaillent dans ce point de vente
                                    </li>
                                </ul>
                            </div>
                            <ul v-else class="list-group">
                                <li class="list-group-item list-group-item-action">
                                    <Skeletor width="100%" style="border-radius: 3px" height="30" />
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <Skeletor width="100%" style="border-radius: 3px" height="30" />
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <Skeletor width="100%" style="border-radius: 3px" height="30" />
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-12 shadow shadow-sm p-3 mt-5">
                        <form action="" method="post">
                            <h5 class="mb-3 text-muted">Ajouter ou supprimer un (des) personnel (les) ici</h5>

                            <label for="travailleurs" class="form-label">Personnelles</label>
                            <Multiselect
                                v-if="!loading"
                                label="nomComplet" valueProp="id" :multiple="true"
                                v-model="depot.travailleurs" :options="personnelles" mode="tags"
                                :object="true"
                                :closeOnSelect="false" :clearOnSelect="false" :searchable="true"
                                placeholder="Selectionner les fonctions"
                            />

                            <Skeletor v-else width="100%" style="border-radius: 3px" height="30" />

                            <div class="d-flex justify-content-end mt-3">
                                <SaveBtn v-if="!loading" @click.prevent="save(depot.id)" :loading="updating">Enregistrer</SaveBtn>
                                <Skeletor v-else width="10%" style="border-radius: 3px" height="40" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import useDepot from "../../../services/DepotServices";
import { Skeletor } from "vue-skeletor";
import Multiselect from '@vueform/multiselect';
import usePersonnelles from '../../../services/PersonnelServices';
import SaveBtn from '../../html/SaveBtn.vue';

const { depot, success, loading, updating, getDepot, updateDepot } = useDepot();
const { personnelles, getPersonnelles } = usePersonnelles();

export default {
    components: {
        Skeletor, Multiselect, SaveBtn,
    },
    setup() {
        return {
            depot,
            loading,
            updating,
            success,
            personnelles,
            getDepot,
            updateDepot,
            getPersonnelles,
        };
    },
    mounted() {
        const id = parseInt(this.$route.params.id);
        getDepot(id);
        getPersonnelles(0);
    },
    methods: {
        async save(id) {
            const updateType = 2 // Type de mise a jour
            await updateDepot(id, depot.value, updateType);
            window.scrollTo({ top: 0, behavior: "smooth" });
            success.value = null
        },
    },
};

</script>
