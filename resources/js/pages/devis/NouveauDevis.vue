<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau dévis</h5>
                    <router-link to="/devis/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des deviss</router-link>
                </div>
            </div>

            {{ form }}

            <div class="card-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <Input v-model="form.numero" :error="Devis.errors.value.numero" required>Réference du dévis</Input>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="fournisseur" class="form-label">Fournisseur</label>
                            <MultiSelect
                                v-bind:class="hasError ? 'border-danger' : ''"
                                label="nom" valueProp="id" v-model="form.fournisseur"
                                :options="Fournisseur.entities.value" :closeOnSelect="false" :clearOnSelect="false"
                                :searchable="true" noOptionsText="Aucun fournisseur" noResultsText="Aucun fournisseur"
                                @close="check"
                            />
                            <div class="text-danger mt-1" v-if="hasError">
                                {{ Devis.errors.value.fournisseur[0] }}
                            </div>
                        </div>
                        <div class="col-xl-12 mb-3">
                            <label for="date" class="form-label">Date</label>
                            <Datepicker
                                required
                                locale="fr-FR"
                                v-model="form.date"
                                selectText="Valider"
                                enableSeconds cancelText="Annuler"
                                placeholder="Selectionner la date"
                                arrowNavigation :state="dateState"
                                @update:modelValue="checkDate"
                            ></Datepicker>
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
import Datepicker from '@vuepic/vue-datepicker';
import MultiSelect from '@vueform/multiselect';

const Devis = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Devis
const Fournisseur = useCRUD('/fournisseur'); // Recuperer le service de CRUD de fournisseur

export default {
    components: {
        Input, SaveBtn, Alert, Datepicker, MultiSelect,
    },
    setup() {
        return {
            Devis, Fournisseur,
        }
    },
    data() {
        return {
            form: {
                numero: null,
                type: 1,
                date: null,
                fournisseur: null,
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
                numero: null,
                type: 1,
                date: null,
                fournisseur: null,
            }
        },

        check (e) {
            if (e.modelValue !== null) Devis.errors.value.fournisseur = null
        },

        checkDate (e) {
            Devis.errors.value.date = null
        }
    },

    computed: {
        hasError () {
            if (Devis.errors.value.fournisseur && Devis.errors.value.fournisseur.length > 0) return true
            return false
        },

        dateState () {
            if (Devis.errors.value.date && Devis.errors.value.date.length > 0) return false
            return null
        },
    },

    mounted() {
        Fournisseur.getEntities();
    },
}
</script>
