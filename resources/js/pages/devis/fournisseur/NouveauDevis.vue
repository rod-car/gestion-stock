<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau dévis fournisseur</h5>
                    <router-link to="/devis/fournisseur/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des deviss</router-link>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="post">
                    <div class="row mb-5">
                        <div class="col-xl-12">
                            <h6 class="text-uppercase text-primary mb-4">Information du dévis</h6>
                            <div class="row">
                                <div class="col-xl-6 mb-3" :class="Devis.loading.value === true ? 'd-flex align-items-end' : ''">
                                    <Input v-if="Devis.loading.value === false" v-model="form.numero" :error="Devis.errors.value.numero" disabled>Numéro du dévis</Input>
                                    <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                                </div>
                                <div class="col-xl-6 mb-3">
                                    <label for="fournisseur" class="form-label">Fournisseur <span class="text-danger">(*)</span></label>
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
                                <div class="col-xl-6 mb-3">
                                    <label for="date" class="form-label">Date <span class="text-danger">(*)</span></label>
                                    <Datepicker
                                        locale="fr-MG"
                                        v-model="form.date"
                                        selectText="Valider"
                                        enableSeconds cancelText="Annuler"
                                        placeholder="Selectionner la date"
                                        arrowNavigation :state="dateState"
                                        @update:modelValue="checkDate"
                                    ></Datepicker>

                                    <div class="text-danger mt-1" v-if="dateState === false">
                                        {{ Devis.errors.value.date[0] }}
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <Input type="number" v-model="form.validite" :error="Devis.errors.value.validite" required>Validité du dévis (en Jour)</Input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-12">
                            <h6 class="text-uppercase text-primary mb-4">Information de l'article</h6>
                            <div class="row">
                                <div class="col-xl-12">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="w-25">Nom de l'article</th>
                                                <th>Quantité</th>
                                                <th>Prix unitaire</th>
                                                <th>TVA</th>
                                                <th>Montant HT</th>
                                                <th>Montant TTC</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="i in nombre_article" :key="i">
                                                <td>
                                                    <MultiSelect
                                                        label="designation" valueProp="id" v-model="form.articles[i-1].id"
                                                        :options="Article.entities.value" :closeOnSelect="false" :clearOnSelect="false"
                                                        :searchable="true" noOptionsText="Aucun article" noResultsText="Aucun article"
                                                        @close="checkArticle"
                                                    />
                                                    <span class="text-danger" v-if="Devis.errors.value[`articles.${i-1}.id`]">
                                                        {{ Devis.errors.value[`articles.${i-1}.id`][0] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="number" @input="calculerMontant(i-1)" v-model="form.articles[i - 1].quantite" class="form-control">
                                                    <span class="text-danger" v-if="Devis.errors.value[`articles.${i-1}.quantite`]">
                                                        {{ Devis.errors.value[`articles.${i-1}.quantite`][0] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="number" @input="calculerMontant(i-1)" v-model="form.articles[i - 1].pu" name="pu" id="pu" class="form-control">
                                                    <span class="text-danger" v-if="Devis.errors.value[`articles.${i-1}.pu`]">
                                                        {{ Devis.errors.value[`articles.${i-1}.pu`][0] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="number" @input="calculerMontant(i-1)" v-model="form.articles[i - 1].tva" name="tva" id="tva" class="form-control">
                                                    <span class="text-danger" v-if="Devis.errors.value[`articles.${i-1}.tva`]">
                                                        {{ Devis.errors.value[`articles.${i-1}.tva`][0] }}
                                                    </span>
                                                </td>
                                                <td><input type="number" disabled v-model="form.articles[i - 1].montant_ht" name="montant_ht" id="montant_ht" class="form-control"></td>
                                                <td><input type="number" disabled v-model="form.articles[i - 1].montant_ttc" name="montant_ttc" id="montant_ttc" class="form-control"></td>
                                                <td>
                                                    <button type="button" v-if="i > 1" @click.prevent="removeItem(i-1)" class="btn btn-danger"><i class="fa fa-minus"></i></button>
                                                    <button type="button" v-else @click.prevent="addItem()" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="d-flex justify-content-end">
                                <SaveBtn @click.prevent="save" :loading="Devis.creating.value">Enregistrer</SaveBtn>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import Input from '../../../components/html/Input.vue';
import SaveBtn from '../../../components/html/SaveBtn.vue';
import Alert from '../../../components/html/Alert.vue';
import useCRUD from '../../../services/CRUDServices';
import Datepicker from '@vuepic/vue-datepicker';
import MultiSelect from '@vueform/multiselect';
import Flash from '../../../functions/Flash';
import { Skeletor } from 'vue-skeletor';
import Config from '../../../config/config.js';

const Devis = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Devis
const Fournisseur = useCRUD('/fournisseur'); // Recuperer le service de CRUD de fournisseur
const Article = useCRUD('/article')

export default {
    components: {
        Input, SaveBtn, Alert, Datepicker, MultiSelect, Skeletor
    },
    setup() {
        return {
            Devis, Fournisseur, Article, Flash, Config,
        }
    },
    data() {
        return {
            form: {
                numero: null,
                type: 1,
                date: null,
                validite: null,
                fournisseur: null,
                appro: true,
                articles: [],
            },
            nombre_article: 1,
        }
    },

    methods: {
        async save () {
            await Devis.createEntity(this.form)
            window.scrollTo({ top: 0, behavior: 'smooth' })
            if (Devis.success.value !== null)
            {
                this.resetForm()
                this.setDevisKey()
            }
            Devis.success.value = null
        },

        resetForm () {
            this.form = {
                numero: null,
                type: 1,
                date: null,
                validite: null,
                fournisseur: null,
                appro: true,
                articles: [],
            }
            this.nombre_article = 1
            this.generateArticleArray(this.nombre_article)
        },

        check (e) {
            if (e.modelValue !== null) Devis.errors.value.fournisseur = null
        },

        checkArticle (e) {
            if (this.form.articles.length > 1 && e.modelValue !== null) {
                let find = this.form.articles.filter(article => parseInt(article.id) === parseInt(e.modelValue))
                if (find.length > 1) {
                    let i = 0
                    this.form.articles.map(article => {
                        if (parseInt(article.id) === parseInt(e.modelValue)) {
                            if (i === 1) {
                                Flash('danger', "Information", "Cette article existe déja dans votre liste")
                                article.id = null
                            }
                            i++
                        }
                    })
                }
            }
        },

        checkDate (e) {
            Devis.errors.value.date = null
        },

        generateArticleArray (nombreArticle) {
            for (let i = 0; i < nombreArticle; i++) {
                this.addItem(false)
            }
        },

        removeItem (index) {
            this.form.articles.splice(index, 1)
            this.nombre_article--
        },

        addItem(increment = true) {
            if (this.nombre_article > Config.devis.MAX_ARTICLE) {
                Flash('error', "Message d'erreur", `Nombre d'article maximum atteint. Limite ${Config.devis.MAX_ARTICLE}`)
                return
            }

            this.form.articles.push({
                id: null,
                quantite: 1,
                pu: null,
                tva: 20.00,
                montant_ht: null,
                montant_ttc: null,
            })

            if (increment === true) this.nombre_article++
        },


        /**
         * Permet de calculer le montant pour une ligne de l'article
         *
         * @param {Number}  index   Index de la ligne darticle
         */
        calculerMontant (index) {
            const pu = this.form.articles[index].pu
            const quantite = this.form.articles[index].quantite
            const tva = this.form.articles[index].tva

            if (pu < 0) this.form.articles[index].pu = Math.abs(pu)
            if (quantite < 0) this.form.articles[index].quantite = Math.abs(quantite)
            if (tva < 0) this.form.articles[index].tva = Math.abs(tva)

            let montant_ht = Math.round((Math.abs(quantite) * Math.abs(pu)) * 100) / 100
            let montant_ttc = Math.round((montant_ht + (montant_ht * Math.abs(tva) / 100)) * 100) / 100

            this.form.articles[index].montant_ht = montant_ht
            this.form.articles[index].montant_ttc = montant_ttc
        },


        /**
         * Recuperer la nouvelle numéro du dévis et le mettre dans la formulaire
         *
         * @return  {void}
         */
        async setDevisKey() {
            await Devis.getKey({ type: 1, appro: true })
            this.form.numero = Devis.key
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
        Article.getEntities()
        Fournisseur.getEntities()
        this.setDevisKey()
    },

    created () {
        this.generateArticleArray(this.nombre_article)
    },
}
</script>
