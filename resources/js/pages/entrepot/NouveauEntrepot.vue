<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau entrepôt</h5>
                    <router-link to="/entrepot/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des entrepôts</router-link>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <Input v-model="form.nom" :error="errors.nom" :required="true">Nom de l'entrepôt</Input>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <Input v-model="form.localisation" :error="errors.localisation" :required="true">Localisation de l'entrepôt</Input>
                        </div>
                        <div class="col-xl-12 mb-3">
                            <Input v-model="form.contact" :error="errors.contact">Contact</Input>
                        </div>
                        <div class="d-flex justify-content-end">
                            <SaveBtn @click.prevent="save" :loading="loading">Enregistrer</SaveBtn>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import Input from '../../components/html/Input.vue';
import SaveBtn from '../../components/html/SaveBtn.vue';
import Alert from '../../components/html/Alert.vue';
import useDepot from '../../services/DepotServices';

const { success, errors, loading, createDepot } = useDepot()

export default {
    components: {
        Input, SaveBtn, Alert,
    },
    setup() {
        return {
            success, errors, loading,
            createDepot,
        }
    },
    data() {
        return {
            form: {
                nom: null,
                localisation: null,
                contact: null,
                point_vente: false,
            },
        }
    },
    methods: {
        async save () {
            await createDepot(this.form)
            window.scrollTo({ top: 0, behavior: 'smooth' });
            if (success.value !== null) this.resetForm();
            success.value = null
        },
        resetForm () {
            this.form = {
                nom: null,
                localisation: null,
                contact: null,
                point_vente: false,
            }
        },
    },
}
</script>
