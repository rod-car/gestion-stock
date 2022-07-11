<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouvelle commande client</h5>
                    <router-link to="/commande/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste de commande client</router-link>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="post">
                    <div class="row mb-5">
                        <div class="col-xl-12">
                            <h6 class="text-uppercase text-primary mb-4">Information de la commande</h6>
                            <div class="row">
                                <div class="col-xl-6 mb-3" :class="Commande.loading.value === true ? 'd-flex align-items-end' : ''">
                                    <Input v-if="Commande.loading.value === false" v-model="form.numero" :error="Commande.errors.value.numero" disabled>Numéro de la commande</Input>
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
                                        {{ Commande.errors.value.client[0] }}
                                    </div>
                                </div>
                                <div class="col-xl-6 mb-3">
                                    <label for="date" class="form-label">Date de création de la commande <span class="text-danger">(*)</span></label>
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
                                        {{ Commande.errors.value.date[0] }}
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <Input v-model="form.adresse_livraison" :error="Commande.errors.value.adresse_livraison">Adresse de livraison</Input>
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
                                                    <span class="text-danger" v-if="Commande.errors.value[`articles.${i-1}.id`]">
                                                        {{ Commande.errors.value[`articles.${i-1}.id`][0] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="number" @input="calculerMontant(i-1)" v-model="form.articles[i - 1].quantite" class="form-control">
                                                    <span class="text-danger" v-if="Commande.errors.value[`articles.${i-1}.quantite`]">
                                                        {{ Commande.errors.value[`articles.${i-1}.quantite`][0] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="number" @input="calculerMontant(i-1)" v-model="form.articles[i - 1].pu" name="pu" id="pu" class="form-control">
                                                    <span class="text-danger" v-if="Commande.errors.value[`articles.${i-1}.pu`]">
                                                        {{ Commande.errors.value[`articles.${i-1}.pu`][0] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="number" @input="calculerMontant(i-1)" v-model="form.articles[i - 1].tva" name="tva" id="tva" class="form-control">
                                                    <span class="text-danger" v-if="Commande.errors.value[`articles.${i-1}.tva`]">
                                                        {{ Commande.errors.value[`articles.${i-1}.tva`][0] }}
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
                                <SaveBtn @click.prevent="save" :loading="Commande.creating.value">Enregistrer</SaveBtn>
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
import { Skeletor } from 'vue-skeletor';
import MultiSelect from '@vueform/multiselect';
import Datepicker from '@vuepic/vue-datepicker';

import useCRUD from '../../../services/CRUDServices';
import Flash from '../../../functions/Flash';
import Config from '../../../config/config.js';
import { onMounted, computed, onBeforeMount, ref } from 'vue';

const Commande = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Commande
const Client = useCRUD('/client'); // Recuperer le service de CRUD de Client
const Article = useCRUD('/article')

export default {
    components: {
        Input, SaveBtn, MultiSelect, Datepicker, Skeletor,
    },
    setup(){
        const form = ref({
            numero: null, type: 2,
            date: null, validite: null,
            client: null, appro: false,
            adresse_livraison: null,
            articles: [],
        })

        const nombre_article = ref(1)

        /**
         * Generer un tableau d'article en fonction de nombre d'article
         *
         * @param   {Number}  nombreArticle  Nombre d'article
         * @return  {void}
         */
        const generateArticleArray = (nombreArticle) => {
            for (let i = 0; i < nombreArticle; i++) {
                addItem(false)
            }
        }


        /**
         * Enregistrer le commande
         *
         * @return  {void}
         */
        const save = async () => {
            await Commande.createEntity(form.value)
            window.scrollTo({ top: 0, behavior: 'smooth' })
            if (Commande.success.value !== null) {
                resetForm()
                setNumeroCommande()
            }
            Commande.success.value = null
        }


        /**
         * Reinitialiser les champs
         *
         * @return  {void}
         */
        const resetForm = () => {
            form.value = {
                numero: null, type: 2,
                date: null, validite: null,
                client: null, appro: false,
                adresse_livraison: null,
                articles: [],
            }
            nombre_article.value = 1
            generateArticleArray(nombre_article.value)
        }


        /**
         * Appelé quand le champ de client change
         *
         * @param   {Event} e   Evenement emis
         * @return  {void}
         */
        const check = (e) => {
            if (e.modelValue !== null) Commande.errors.value.client = null
        }


        /**
         * Appeler quand l'article change
         *
         * @param   {Event} e   Change event
         * @return  {void}
         */
        const checkArticle = (e) => {
            if (form.value.articles.length > 1 && e.modelValue !== null) {
                let find = form.value.articles.filter(article => parseInt(article.id) === parseInt(e.modelValue))
                if (find.length > 1) {
                    let i = 0
                    form.value.articles.map(article => {
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
        }


        /**
         * Verifier la changement de la date
         *
         * @param   {Event} e   Evenement émis
         */
        const checkDate = (e) => {
            Commande.errors.value.date = null
        }


        /**
         * Retirer un élément dans la liste des articles
         *
         * @param   {Number}    index   Indice de l'élément dans la table
         * @return  {void}
         */
        const removeItem = (index) => {
            form.value.articles.splice(index, 1)
            nombre_article.value--
        }


        /**
         * Retirer un élément dans la liste des articles
         *
         * @param   {Boolean}    increent   Si on veut incrementer le nombre d'article
         * @return  {void}
         */
        const addItem = (increment = true) => {
            if (nombre_article.value > Config.commande.MAX_ARTICLE) {
                Flash('error', "Message d'erreur", `Nombre d'article maximum atteint. Limite ${Config.commande.MAX_ARTICLE}`)
                return
            }

            form.value.articles.push({
                id: null,
                quantite: 1,
                pu: null,
                tva: 20.00,
                montant_ht: null,
                montant_ttc: null,
            })

            if (increment === true) nombre_article.value++
        }


        /**
         * Permet de calculer le montant pour une ligne de l'article
         *
         * @param {Number}  index   Index de la ligne darticle
         */
        const calculerMontant = (index) => {
            const pu = form.value.articles[index].pu
            const quantite = form.value.articles[index].quantite
            const tva = form.value.articles[index].tva

            if (pu < 0) form.value.articles[index].pu = Math.abs(pu)
            if (quantite < 0) form.value.articles[index].quantite = Math.abs(quantite)
            if (tva < 0) form.value.articles[index].tva = Math.abs(tva)

            let montant_ht = Math.round((Math.abs(quantite) * Math.abs(pu)) * 100) / 100
            let montant_ttc = Math.round((montant_ht + (montant_ht * Math.abs(tva) / 100)) * 100) / 100

            form.value.articles[index].montant_ht = montant_ht
            form.value.articles[index].montant_ttc = montant_ttc
        }


        /**
        * Recuperer la nouvelle numéro de la commande et le mettre dans la formulaire
        *
        * @return  {void}
        */
        const setNumeroCommande = async () => {
            await Commande.getKey({ type: 2, appro: false })
            form.value.numero = Commande.key
        }

        onMounted(() => {
            Article.getEntities()
            Client.getEntities()
            setNumeroCommande()
        })

        const hasError = computed(() => {
            if (Commande.errors.value.client && Commande.errors.value.client.length > 0) return true
            return false
        })

        const dateState = computed(() => {
            if (Commande.errors.value.date && Commande.errors.value.date.length > 0) return false
            return null
        })

        onBeforeMount(() => {
            generateArticleArray(nombre_article.value)
        })

        return {
            form, nombre_article, Commande, Client, Article, Flash, Config,
            resetForm, addItem, removeItem, calculerMontant, setNumeroCommande, check, checkDate, checkArticle, save, hasError, dateState,
        }
    }

}

</script>
