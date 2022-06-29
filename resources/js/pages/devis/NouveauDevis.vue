<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau dévis</h5>
                    <router-link to="/devis/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des deviss</router-link>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <Input v-model="form.reference" :error="Devis.errors.value.reference" :required="true">Référence de l'devis</Input>
                        </div>

                        <div class="d-flex justify-content-end">
                            <SaveBtn @click.prevent="save" :loading="Devis.creating.value">Enregistrer</SaveBtn>
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
import useCRUD from '../../services/CRUDServices';

const Devis = useCRUD('/commande'); // Contient tous les fonctions CRUD pour le Devis

export default {
    components: {
        Input, SaveBtn, Alert,
    },
    setup() {
        return {
            Devis,
        }
    },
    data() {
        return {
            form: {
                reference: null,
                designation: null,
                unite: 'Nombre',
                stock_alert: null,
                categories: [],
            },
        }
    },
    methods: {
        async save () {
            await Devis.createEntity(this.form)
            window.scrollTo({ top: 0, behavior: 'smooth' })
            if (Devis.success.value !== null) this.resetForm()
            Devis.success.value = null
        },
        resetForm () {
            this.form = {
                reference: null,
                designation: null,
                unite: "Nombre",
                stock_alert: null,
                categories: [],
            }
        },

        check (e) {
            if (e.modelValue.length > 0) Devis.errors.value.categories = null
        }
    },
}
</script>
