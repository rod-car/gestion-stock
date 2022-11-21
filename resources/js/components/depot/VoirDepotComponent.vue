<template>
    <div class="row">
        <div class="col-xl-12 d-flex justify-content-between p-0">
            <div class="shadow shadow-sm p-3 w-100 me-3">
                <h3 class="">{{ depot.nom }}</h3><hr>
                <h6 class="fst-italic mb-3">Adresse: {{ depot.localisation }}</h6>
                <h6 class="fst-italic text-primary">Contact: {{ depot.contact }}</h6>
            </div>

            <div class="shadow shadow-sm p-3 w-100 ms-3">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="text-muted">Responsables</h5>
                    <router-link v-if="depot.id" :to="{ name: getName + '.gerer-responsables', params: { id: depot.id }}" class="btn btn-info text-white">
                        <i class="fa fa-pencil me-2"></i>Mettre a jour
                    </router-link>
                </div>
                <div>
                    <ul v-if="depot.responsables && depot.responsables.length > 0" class="list-group list-group-numbered">
                        <li v-for="responsable in depot.responsables" :key="responsable.id" class="list-group-item list-group-item-action">
                            <span class="fw-bold text-uppercase" v-text="responsable.nom_personnel"></span>&nbsp;
                            <span v-text="responsable.prenoms_personnel"></span>&nbsp;
                        </li>
                    </ul>

                    <ul v-else class="list-group">
                        <li class="list-group-item list-group-item-action">
                            Aucune responsable
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-12 mt-5 p-0">
            <div class="d-flex justify-content-between p-0">
                <div class="me-2 shadow shadow-sm w-100 p-3">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <h5 class="text-muted">Les articles</h5>
                        <router-link :to="{ name:  'point-de-vente.articles', params: { id: depot.id }}" class="btn btn-info btn-sm text-white"><i class="fa fa-eye me-2"></i>Voir tout</router-link>

                    </div>
                    <Table
                        name="article"
                        :data="articles"
                        :columns="columns"
                        :actions="false"
                        :loading="loading"
                        :casts="casts"
                    />
                </div>
                <div class="ms-2 shadow shadow-sm w-100 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-muted">Tous personnelles</h5>
                        <router-link class="btn btn-info btn-sm text-white" v-if="depot.id" :to="{ name: getName + '.gerer-personnelles', params: { id: depot.id }}"><i class="fa fa-pencil me-2"></i>Mettre a jour</router-link>
                    </div>
                    <div>
                        <ul v-if="depot.travailleurs && depot.travailleurs.length > 0" class="list-group list-group-numbered">
                            <li v-for="personnel in depot.travailleurs" :key="personnel.id" class="list-group-item list-group-item-action">
                                <span class="fw-bold text-uppercase" v-text="personnel.nom_personnel"></span>&nbsp;
                                <span v-text="personnel.prenoms_personnel"></span>&nbsp;&nbsp;
                                <span class="badge bg-danger" v-text="personnel.pivot.est_responsable ? 'Responsable': ''"></span>
                            </li>
                        </ul>

                        <ul v-else class="list-group">
                            <li class="list-group-item list-group-item-action">
                                Aucune personnel
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import axiosClient from "../../axios";
import { computed, defineComponent, onBeforeMount, ref } from "vue";
import { Skeletor } from "vue-skeletor";
import Table from "../html/Table.vue";
import store from "../../store";

export default defineComponent({
    props: {
        depot: {
            type: Object,
            required: true,
        },
        entrepot: {
            type: Boolean,
            default: false,
            required: true,
        }
    },

    setup(props) {
        const articles = ref([])
        const loading = ref(false);
        const columns = { reference: 'Réference', designation: 'Désignation', unite: 'Unité', 'entree - sortie': 'Quantité', detailsPrix: "PU" }
        const casts = [];

        casts['fullArticle.pivot.pu'] = 'money';

        const getName = computed((): string => {
            if (props.entrepot === true) return "entrepot";
            return "point-de-vente";
        });

        onBeforeMount(async () => {
            const limit: number = 5;

            loading.value = true;
            try {
                let response = await axiosClient.get(`/depot/${props.depot.id}/articles?limit=${limit}`)
                articles.value = response.data;
            } catch (err) {
                console.log(err)
            }

            loading.value = false

        });

        return {
            getName, articles, loading, columns, casts,
        };
    },

    components: {
        Skeletor,
        Table
    }
});

</script>
