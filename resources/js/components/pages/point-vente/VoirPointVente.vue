<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-uppercase text-info">
                        Point de vente N° {{ depot.id }}
                    </h5>

                    <div class="d-flex justify-content-end">
                        <router-link
                            v-if="$can('edit_point_vente') && depot.id"
                            :to="{
                                name: 'point-de-vente.modifier',
                                params: { id: depot.id },
                            }"
                            class="btn btn-warning me-2"
                        >
                            <i class="fa fa-pencil me-2"></i>Modifier ce point
                            de vente
                        </router-link>
                        <router-link
                            v-if="$can('add_point_vente')"
                            to="/point-de-vente/nouveau"
                            class="btn btn-secondary me-2"
                            ><i class="fa fa-plus me-2"></i>Nouveau point de
                            vente</router-link
                        >
                        <router-link
                            v-if="$can('view_point_vente')"
                            to="/point-de-vente/liste"
                            class="btn btn-primary me-2"
                            ><i class="fa fa-list me-2"></i>Liste des point de
                            vente</router-link
                        >
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 shadow shadow-sm p-3">
                        <h1>{{ depot.nom }}</h1>
                        <hr />
                        <span class="fst-italic fs-3">{{
                            depot.localisation
                        }}</span
                        ><br />
                        <span class="fst-italic fs-3 text-primary">{{
                            depot.contact
                        }}</span>
                    </div>
                    <div class="col-xl-6 shadow shadow-sm p-3">
                        <h3 class="mb-3">Responsables</h3>
                        <ul class="list-group list-group-numbered">
                            <li class="list-group-item list-group-item-action">
                                RAKOTO Beloha
                            </li>
                            <li class="list-group-item list-group-item-action">
                                JEAN Paul
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-12 shadow shadow-sm p-3 mt-3">
                        <h3 class="mb-3">Liste des articles</h3>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-action">
                                ART001 - Ordinateur de bureau
                            </li>
                            <li class="list-group-item list-group-item-action">
                                ART002 - Ordinateur portable
                            </li>
                            <li class="list-group-item list-group-item-action">
                                ART003 - Souris
                            </li>
                            <li class="list-group-item list-group-item-action">
                                ART001 - Clavier
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useDepot from "../../../services/DepotServices";

const { depot, getDepot } = useDepot();

export default {
    setup() {
        return {
            depot,
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
