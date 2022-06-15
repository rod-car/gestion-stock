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
                        <div>
                            <h3 class="text-uppercase" v-if="!loading">
                                {{ depot.nom }}
                            </h3>
                            <Skeletor
                                v-else
                                width="100%"
                                height="40"
                                style="border-radius: 5px"
                            />
                        </div>
                        <hr />
                        <div>
                            <span v-if="!loading" class="fst-italic fs-5">{{
                                depot.localisation
                            }}</span>
                            <Skeletor
                                v-else
                                width="75%"
                                height="30"
                                style="border-radius: 5px"
                            />
                        </div>
                        <br />

                        <div>
                            <span
                                v-if="!loading"
                                class="fst-italic fs-5 text-primary"
                                >{{ depot.contact }}</span
                            >
                            <Skeletor
                                v-else
                                width="50%"
                                height="30"
                                style="border-radius: 5px"
                            />
                        </div>
                    </div>
                    <div class="col-xl-6 shadow shadow-sm p-3">
                        <h3 class="mb-3">Responsables</h3>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-action">
                                <Skeletor
                                    width="100%"
                                    style="border-radius: 3px"
                                    height="30"
                                />
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <Skeletor
                                    width="100%"
                                    style="border-radius: 3px"
                                    height="30"
                                />
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-12 shadow shadow-sm p-3 mt-3">
                        <h3 class="mb-3">Liste des articles</h3>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-action">
                                <Skeletor
                                    width="100%"
                                    style="border-radius: 3px"
                                    height="30"
                                />
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <Skeletor
                                    width="100%"
                                    style="border-radius: 3px"
                                    height="30"
                                />
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <Skeletor
                                    width="100%"
                                    style="border-radius: 3px"
                                    height="30"
                                />
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <Skeletor
                                    width="100%"
                                    style="border-radius: 3px"
                                    height="30"
                                />
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
