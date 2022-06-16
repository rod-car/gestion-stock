<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Gerer les responsables du point de vente N° {{ depot.id }}</h5>
                    <router-link v-if="$can('view_point_vente')" to="/point-de-vente/liste" class="btn btn-primary me-2">
                        <i class="fa fa-list me-2"></i>Liste des point de vente
                    </router-link>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="d-flex justify-content-between p-0">
                        <div class="shadow shadow-sm p-3 me-3 w-100">
                            <div>
                                <h3 class="" v-if="!loading">{{ depot.nom }}</h3>
                                <Skeletor v-else width="100%" height="40" style="border-radius: 5px" />
                            </div>
                            <hr />
                            <div>
                                <span v-if="!loading" class="fst-italic fs-5">{{ depot.localisation }}</span>
                                <Skeletor v-else width="75%" height="30" style="border-radius: 5px" />
                            </div>
                            <br />

                            <div>
                                <span v-if="!loading" class="fst-italic fs-5 text-primary">{{ depot.contact }}</span>
                                <Skeletor v-else width="50%" height="30" style="border-radius: 5px" />
                            </div>
                        </div>

                        <div class="shadow shadow-sm p-3 ms-3 w-100">
                            <h3 class="mb-3">Responsables actuels</h3>
                            <div v-if="!loading">
                                <ul v-if="depot.responsables && depot.responsables.length > 0" class="list-group list-group-numbered">
                                    <li v-for="responsable in depot.responsables" :key="responsable.id" class="list-group-item list-group-item-action">
                                        <span class="fw-bold" v-text="responsable.nom_personnel"></span>&nbsp;
                                        <span v-text="responsable.prenoms_personnel"></span>&nbsp;
                                    </li>
                                </ul>

                                <ul v-else class="list-group">
                                    <li class="list-group-item list-group-item-action">
                                        Aucune responsable pour ce point de vente
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
                            <h4 class="mb-3">Ajouter ou supprimer un (des) responsable (s) ici</h4>

                            <label for="responsables" class="form-label">Responsables</label>
                            <Multiselect
                                label="nomComplet" valueProp="id" :multiple="true"
                                v-model="depot.responsables" :options="personnelles" mode="tags"
                                :object="true"
                                :closeOnSelect="false" :clearOnSelect="false" :searchable="true"
                                placeholder="Selectionner les fonctions"
                            />

                            <div class="d-flex justify-content-end mt-3">
                                <SaveBtn @click.prevent="save(depot.id)" :loading="loading">Enregistrer</SaveBtn>
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

const { depot, loading, getDepot, updateDepot } = useDepot();
const { personnelles, getPersonnelles } = usePersonnelles();

export default {
    components: {
        Skeletor, Multiselect, SaveBtn,
    },
    setup() {
        return {
            depot,
            loading,
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
            await updateDepot(id, depot.value);
            window.scrollTo({ top: 0, behavior: "smooth" });
            success.value = null
        },
    },
};

</script>
