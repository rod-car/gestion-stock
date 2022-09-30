<template>
    <form action="" method="post">
        <div class="row mb-5">
            <div class="col-xl-12">
                <h6 class="text-uppercase text-primary mb-4">Information de la facturation</h6>
                <div class="row mb-4">
                    <div class="col-xl-6 mb-3" :class="Facturation.loading.value === true ? 'd-flex align-items-end' : ''">
                        <Input v-if="Facturation.loading.value === false" v-model="form.numero_facture" :error="Facturation.errors.value.numero_facture">Numéro de la facture</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>

                    <div class="col-xl-6 mb-3">
                        <Input v-model="commande.cl.nom" :required="true" disabled>Client</Input>
                    </div>

                    <div class="col-xl-6 mb-3">
                        <label for="date" class="form-label">Date de création <span class="text-danger">(*)</span></label>
                        <Datepicker locale="fr-MG" v-model="form.date_facturation" selectText="Valider"
                            :enableTimePicker="false"
                            cancelText="Annuler" placeholder="Selectionner la date"
                            arrowNavigation
                            @update:modelValue="checkDate(1)" />

                        <div class="text-danger mt-1" v-if="dateState === false">
                            {{ Facturation.errors.value.date_facturation[0] }}
                        </div>
                    </div>

                    <div class="col-xl-6 mb-3">
                        <label for="date" class="form-label">Date de vente <span class="text-danger">(*)</span></label>
                        <Datepicker locale="fr-MG" v-model="form.date_vente" selectText="Valider"
                            :enableTimePicker="false"
                            cancelText="Annuler" placeholder="Selectionner la date"
                            arrowNavigation
                            @update:modelValue="checkDate(2)" />

                        <div class="text-danger mt-1" v-if="dateState === false">
                            {{ Facturation.errors.value.date_vente[0] }}
                        </div>
                    </div>

                    <div class="col-xl-6 mb-3">
                        <Input type="number" v-model="form.echeance" :required="true">Echeance (Jours)</Input>
                    </div>
                    <div class="col-xl-6 mb-3">
                        <Input type="number" v-model="form.taux_penalite" :required="true">Taux de penalité (Ar)</Input>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-xl-12">
                <div class="d-flex justify-content-between mb-4">
                    <h6 class="text-uppercase text-primary">Information de l'article</h6>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-warning">
                                <tr>
                                    <th>Designation</th>
                                    <th>Quantité</th>
                                    <th>Unité</th>
                                    <th class="text-end">Prix unitaire HT</th>
                                    <th v-if="(assujeti === true || commande.tva > 0)">% TVA</th>
                                    <th v-if="(assujeti === true || commande.tva > 0)" class="text-end">Total TVA</th>
                                    <th class="text-end">Total TTC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="article in commande.articles" :key="article.id">
                                    <td>{{ article.designation }}</td>
                                    <td>{{ article.pivot.quantite }}</td>
                                    <td>{{ article.unite }}</td>
                                    <td class="text-end">{{ format(article.pivot.pu) }}</td>
                                    <td v-if="(assujeti === true || commande.tva > 0)">{{ article.pivot.tva }}</td>
                                    <td v-if="(assujeti === true || commande.tva > 0)" class="text-end">{{ format(montantTVA(article)) }}</td>
                                    <td class="text-end">{{ format(montantTTC(article)) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="border-0">
                                    <td :colspan="(assujeti === true || commande.tva > 0) ? 7 : 5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td :colspan="(assujeti === true || commande.tva > 0) ? 6 : 4" class="text-end">TOTAL HT</td>
                                    <td class="text-end">{{ format(totalHT(commande.articles)) }}</td>
                                </tr>
                                <tr v-if="(assujeti === true || commande.tva > 0)">
                                    <td colspan="6" class="text-end">TOTAL TVA</td>
                                    <td class="text-end">{{ format(totalTVA(commande.articles)) }}</td>
                                </tr>
                                <tr class="text-warning">
                                    <td :colspan="(assujeti === true || commande.tva > 0) ? 6 : 4" class="text-end">TOTAL TTC</td>
                                    <td class="text-end">{{ format(totalTTC(commande.articles)) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="d-flex justify-content-end">
                    <SaveBtn v-if="nouveau" @click.prevent="save" :loading="Facturation.creating.value" :disabled="!valide">Enregistrer</SaveBtn>
                    <SaveBtn v-else @click.prevent="save" :loading="Facturation.updating.value" :disabled="!valide">Mettre a jour</SaveBtn>
                </div>
            </div>
        </div>
    </form>
</template>

<script lang="ts">
import Input from '../html/Input.vue';
import { Skeletor } from 'vue-skeletor';
import router from '../../router/router';
import SaveBtn from '../html/SaveBtn.vue';
import Flash from '../../functions/Flash';
import MultiSelect from '@vueform/multiselect';
import Datepicker from '@vuepic/vue-datepicker';
import useCRUD from '../../services/CRUDServices';
import { computed, onBeforeMount, ref, defineComponent, Ref } from 'vue';
import { format, totalHT, montantTTC, montantTVA, totalTVA, totalTTC } from '../../functions/functions'
import store from '../../store';

const Facturation = useCRUD('/factures'); // Contient tous les fonctions CRUD pour le Bon de Facturation
const Depot = useCRUD('/depot'); // Contient tous les fonctions CRUD pour le Bon de Facturation

type Form = {
    numero_facture: string|null,
    commande: number,
    echeance: number,
    taux_penalite: number,
    date_facturation: Date,
    date_vente: Date|null
}

export default defineComponent({
    name: "FacturationFormComponent",
    components: {
        Input, SaveBtn, Datepicker, MultiSelect, Skeletor,
    },

    props: {
        /**
         * Permet de savoir si on veut modifier un facture ou créer une
         * @values true, false
         */
        nouveau: {
            type: Boolean,
            required: false,
        },

        /**
         * La facture a modifier dans le cas d'une modification
         */
        facture: {
            type: Object,
            required: false,
        },

        /**
         * Commande a convertir en facture
         */
        commande: {
            type: Object,
            required: true,
        },
    },

    setup(props) {
        const form: Ref<Form> = ref({
            numero_facture: null,
            commande: props.commande.id,
            echeance: 30,
            taux_penalite: 1000,
            date_facturation: new Date(),
            date_vente: null,
        });

        const valide: Ref<boolean> = ref(true);
        const nombreArticle = ref(1);
        const infoEntreprise = store.state.infoEntreprise

        const assujeti = computed((): boolean => {
            return infoEntreprise.generale.assujeti
        })

        const check = (e: { modelValue: null; }) => {
            if (e.modelValue !== null) Depot.errors.value.categories = null
        }

        const hasError = computed((): boolean => {
            if (Depot.errors.value.categories && Depot.errors.value.categories.length > 0) return true
            return false
        })

        const save = async () => {
            if (props.nouveau === true) {
                await Facturation.create(form.value)
                if (Facturation.success.value !== null) {
                    router.replace({ query: {} })
                    router.push(`/facture/voir/${Facturation.entity.value.id}`)
                }
            } else if (props.facture) {
                await Facturation.update(props.facture.id, form.value)
            }

            window.scrollTo({ top: 0, behavior: 'smooth' })
            Facturation.success.value = null
        }

        const checkDate = (type: number) => {
            if (type === 1) Facturation.errors.value.date_facturation = null
            if (type === 2) Facturation.errors.value.date_vente = null
        }

        /**
         * Recuperer la nouvelle numéro du dévis et le mettre dans la formulaire
         *
         * @return  {Promise}
         */
        const setFacturationKey = async (): Promise<any> => {
            await Facturation.getKey() // Numéro de la facture
            form.value.numero_facture = Facturation.key.value
        }

        const dateState = computed(() => {
            if (Facturation.errors.value.date && Facturation.errors.value.date.length > 0) return false
            return null
        })

        onBeforeMount(() => {
            nombreArticle.value = props.commande.articles.length
            form.value.commande = props.commande.id
            form.value.date_vente = props.commande.date

            if (props.nouveau === true) setFacturationKey();
        })

        return {
            hasError, valide, form, nombreArticle, Facturation, dateState, assujeti,
            Flash, setFacturationKey, checkDate, save, check, format,
            montantTVA, totalHT, montantTTC, totalTVA, totalTTC,
        }
    },

})

</script>
