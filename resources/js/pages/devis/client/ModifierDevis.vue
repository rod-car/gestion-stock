<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Modifier le dévis N° {{ Devis.entity.value.numero }}</h5>
                    <router-link to="/devis/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des devis client</router-link>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="post">
                    <div class="row mb-5">
                        <div class="col-xl-12">
                            <h6 class="text-uppercase text-primary mb-4">Information du dévis</h6>
                            <div class="row">
                                <div class="col-xl-6 mb-3" :class="Devis.loading.value === true ? 'd-flex align-items-end' : ''">
                                    <label v-if="!Devis.loading.value" class="form-label">Numéro du dévis</label>
                                    <label v-if="!Devis.loading.value" class="form-control">{{ form.numero }}</label>
                                    <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                                </div>
                                <div class="col-xl-6 mb-3">
                                    <label for="client" class="form-label">Client <span class="text-danger">(*)</span></label>
                                    <MultiSelect
                                        v-bind:class="hasError ? 'border-danger' : ''"
                                        label="nom" valueProp="id" v-model="form.client"
                                        :options="Client.entities.value" :closeOnSelect="false" :clearOnSelect="false"
                                        :searchable="true" noOptionsText="Aucun client" noResultsText="Aucun client"
                                        @close="check"
                                    />
                                    <div class="text-danger mt-1" v-if="hasError">
                                        {{ Devis.errors.value.client[0] }}
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
                                        <tbody v-if="Devis.loading.value">
                                            <tr v-for="i in 5" :key="i">
                                                <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                                                <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                                                <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                                                <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                                                <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                                                <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                                                <td><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="i in nombre_article" :key="i">
                                                <template v-if="form.articles[i-1]">
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
                                                </template>
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
                                <SaveBtn @click.prevent="save()" :loading="Devis.updating.value">Enregistrer</SaveBtn>
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

const Devis = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Devis
const Client = useCRUD('/client'); // Recuperer le service de CRUD de client
const Article = useCRUD('/article')

export default {
    components: {
        Input, SaveBtn, Alert, Datepicker, MultiSelect, Skeletor
    },
    setup() {
        return {
            Devis, Client, Article, Flash,
        }
    },
    data() {
        return {
            form: {
                numero: null,
                type: 1,
                date: null,
                validite: null,
                client: null,
                articles: [],
            },
            nombre_article: 1,
        }
    },

    methods: {
        async save() {
            const id = Devis.entity.value.id
            await Devis.updateEntity(id, this.form)
            window.scrollTo({ top: 0, behavior: 'smooth' })
        },

        check (e) {
            if (e.modelValue !== null) Devis.errors.value.client = null
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

        generateArticleArray(articles) {
            articles.forEach(article => this.addItem(article, false))
        },

        removeItem (index) {
            this.form.articles.splice(index, 1)
            this.nombre_article--
        },

        addItem (article = null, increment = true) {
            this.form.articles.push({
                id: article === null ? null : article.id,
                quantite: article === null ? 1 : article.pivot.quantite,
                pu: article === null ? null : article.pivot.pu,
                tva: article === null ? 20 : article.pivot.tva,
                montant_ht: article === null ? null : article.pivot.quantite * article.pivot.pu,
                montant_ttc: article === null ? null : (article.pivot.quantite * article.pivot.pu) * (1 + (article.pivot.tva / 100)),
            })

            if (increment === true) this.nombre_article++
        },

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
        }
    },

    computed: {
        hasError () {
            if (Devis.errors.value.client && Devis.errors.value.client.length > 0) return true
            return false
        },

        dateState () {
            if (Devis.errors.value.date && Devis.errors.value.date.length > 0) return false
            return null
        },
    },

    mounted() {
        Article.getEntities()
        Client.getEntities()
    },

    async created() {
        await Devis.getEntity(this.$route.params.id)
        this.generateArticleArray(Devis.entity.value.articles)
        this.nombre_article = Devis.entity.value.articles.length

        this.form.numero = Devis.entity.value.numero
        this.form.date = Devis.entity.value.date
        this.form.validite = Devis.entity.value.validite
        this.form.client = Devis.entity.value.client
        this.form.type = 1
    },
}
</script>
