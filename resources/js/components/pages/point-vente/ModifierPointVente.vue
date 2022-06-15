<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-uppercase text-info">
                        Modifier le point de vente N° {{ depot.id }}
                    </h5>
                    <router-link
                        to="/point-de-vente/liste"
                        class="btn btn-primary"
                        ><i class="fa fa-list me-2"></i>Liste des point de vente
                    </router-link>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <Input v-model="depot.nom" :error="errors.nom" :required="true" >Nom du point de vente</Input>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <Input v-model="depot.localisation" :error="errors.localisation" :required="true">Localisation du point de vente</Input>
                        </div>
                        <div class="col-xl-12 mb-3">
                            <Input v-model="depot.contact" :error="errors.contact">Contact</Input>
                        </div>
                        <div class="d-flex justify-content-end">
                            <SaveBtn @click.prevent="save(depot.id)" :loading="loading">Enregistrer</SaveBtn>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Input from "../../html/Input.vue";
import SaveBtn from "../../html/SaveBtn.vue";
import useDepot from "../../../services/DepotServices";

const { success, loading, errors, depot, getDepot, updateDepot } = useDepot();

export default {
    components: {
        Input,
        SaveBtn,
    },
    setup() {
        return {
            success,
            errors,
            depot,
            loading,
            getDepot,
            updateDepot,
        };
    },
    data() {
        return {
            form: {
                nom: null,
                localisation: null,
                contact: null,
                point_vente: true,
            },
        };
    },
    methods: {
        async save(id) {
            await updateDepot(id, depot.value);
            window.scrollTo({ top: 0, behavior: "smooth" });
            if (success.value !== null) this.resetForm();
            success.value = null
        },
        resetForm() {
            this.form = {
                nom: null,
                localisation: null,
                contact: null,
                point_vente: true,
            };
        },
    },
    mounted() {
        const id = parseInt(this.$route.params.id);
        getDepot(id);
    },
};
</script>
