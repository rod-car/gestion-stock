<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-uppercase text-info">Nouveau point de vente</h5>
                    <router-link to="/point-de-vente/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des point de vente</router-link>
                </div>
            </div>
            <div class="card-body">
                <Alert type="success" :message="success" />
                <Alert type="danger" :message="errors.message" />

                <form action="" method="post">
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <Input v-model="form.nom" :error="errors.nom" :required="true">Nom du point de vente</Input>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <Input v-model="form.localisation" :error="errors.localisation" :required="true">Localisation du point de vente</Input>
                        </div>
                        <div class="col-xl-12 mb-3">
                            <Input v-model="form.contact" :error="errors.contact">Contact</Input>
                        </div>
                        <div class="d-flex justify-content-end">
                            <SaveBtn @click.prevent="save">Enregistrer</SaveBtn>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import Input from '../../html/Input.vue';
import SaveBtn from '../../html/SaveBtn.vue';
import Alert from '../../html/Alert.vue';
import useDepot from '../../../services/DepotServices';

const { success, errors, createDepot } = useDepot()

export default {
    components: {
        Input, SaveBtn, Alert,
    },
    setup() {
        return {
            success, errors,
            createDepot,
        }
    },
    data() {
        return {
            form: {
                nom: null,
                localisation: null,
                contact: null,
                point_vente: true,
            },
        }
    },
    methods: {
        async save () {
            await createDepot(this.form)

            window.scrollTo({ top: 0, behavior: 'smooth' });

            if (success.value !== null) this.resetForm();
        },
        resetForm () {
            this.form = {
                nom: null,
                localisation: null,
                contact: null,
                point_vente: true,
            }
        },
    },
}
</script>
