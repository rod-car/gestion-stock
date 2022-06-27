<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 v-if="!loading" class="text-muted">Entrepôt N° {{ depot.id }}</h5>
                    <Skeletor v-else width="50%" height="30" style="border-radius: 5px" />

                    <div class="d-flex justify-content-end">
                        <router-link v-if="$can('edit_entrepot') && depot.id" :to="{ name: 'entrepot.modifier', params: { id: depot.id }}" class="btn btn-warning text-white me-2">
                            <i class="fa fa-pencil me-2"></i>Modifier
                        </router-link>
                        <router-link v-if="$can('add_entrepot')" to="/entrepot/nouveau" class="btn btn-secondary me-2">
                            <i class="fa fa-plus me-2"></i>Nouveau
                        </router-link>
                        <router-link v-if="$can('view_entrepot')" to="/entrepot/liste" class="btn btn-primary me-2" >
                            <i class="fa fa-list me-2"></i>Liste
                        </router-link>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12 d-flex justify-content-between p-0">
                        <div class="shadow shadow-sm p-3 w-100 me-3">
                            <h3 class="" v-if="!loading">{{ depot.nom }}</h3>
                            <Skeletor v-else width="100%" height="40" style="border-radius: 5px" />
                            <hr>

                            <h6 v-if="!loading" class="fst-italic mb-3">Adresse: {{ depot.localisation }}</h6>
                            <Skeletor v-else width="75%" height="30" style="border-radius: 5px; margin-bottom: 1rem !important" />

                            <h6 v-if="!loading" class="fst-italic text-primary">Contact: {{ depot.contact }}</h6>
                            <Skeletor v-else width="50%" height="30" style="border-radius: 5px; margin-bottom: 1rem !important"/>
                        </div>

                        <div class="shadow shadow-sm p-3 w-100 ms-3">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="text-muted">Responsables</h5>
                                <router-link v-if="depot.id" :to="{ name: 'entrepot.gerer-responsables', params: { id: depot.id }}" class="btn btn-info text-white">
                                    <i class="fa fa-pencil me-2"></i>Mettre a jour
                                </router-link>
                            </div>
                            <div v-if="!loading">
                                <ul v-if="depot.responsables && depot.responsables.length > 0" class="list-group list-group-numbered">
                                    <li v-for="responsable in depot.responsables" :key="responsable.id" class="list-group-item list-group-item-action">
                                        <span class="fw-bold text-uppercase" v-text="responsable.nom_personnel"></span>&nbsp;
                                        <span v-text="responsable.prenoms_personnel"></span>&nbsp;
                                    </li>
                                </ul>

                                <ul v-else class="list-group">
                                    <li class="list-group-item list-group-item-action">
                                        Aucune responsable pour cet entrepôt
                                    </li>
                                </ul>
                            </div>

                            <ul v-else-if="loading" class="list-group">
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

                    <div class="col-xl-12 mt-5 p-0">
                        <div class="d-flex justify-content-between p-0">
                            <div class="me-2 shadow shadow-sm w-100 p-3">
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <h5 class="text-muted">Les articles dans cet entrepôt</h5>
                                    <a href="" class="btn btn-info btn-sm text-white"><i class="fa fa-eye me-2"></i>Test button</a>
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-action">
                                        <Skeletor width="100%" style="border-radius: 3px" height="30" />
                                    </li>
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
                            <div class="ms-2 shadow shadow-sm w-100 p-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="text-muted">Tous personnelles de cet entrepot</h5>
                                    <router-link class="btn btn-info btn-sm text-white" v-if="depot.id" :to="{ name: 'entrepot.gerer-personnelles', params: { id: depot.id }}"><i class="fa fa-pencil me-2"></i>Mettre a jour</router-link>
                                </div>
                                <div v-if="!loading">
                                    <ul v-if="depot.travailleurs && depot.travailleurs.length > 0" class="list-group list-group-numbered">
                                        <li v-for="personnel in depot.travailleurs" :key="personnel.id" class="list-group-item list-group-item-action">
                                            <span class="fw-bold text-uppercase" v-text="personnel.nom_personnel"></span>&nbsp;
                                            <span v-text="personnel.prenoms_personnel"></span>&nbsp;&nbsp;
                                            <span class="badge bg-danger" v-text="personnel.pivot.est_responsable ? 'Responsable': ''"></span>
                                        </li>
                                    </ul>

                                    <ul v-else class="list-group">
                                        <li class="list-group-item list-group-item-action">
                                            Aucune personnel pour cet entrepot
                                        </li>
                                    </ul>
                                </div>

                                <ul v-else-if="loading" class="list-group">
                                    <li class="list-group-item list-group-item-action">
                                        <Skeletor width="100%" style="border-radius: 3px" height="30" />
                                    </li>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useDepot from "../../services/DepotServices";
import { Skeletor } from "vue-skeletor";

const { depot, loading, getDepot } = useDepot();

export default {
    components: {
        Skeletor,
    },
    setup() {
        return {
            depot,
            loading,
            getDepot,
        };
    },
    data() {
        return {};
    },

    mounted() {
        const id = parseInt(this.$route.params.id);
        getDepot(id);
    },
};
</script>
