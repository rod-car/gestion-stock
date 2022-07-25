<template>
    <form action="" method="post">
        <div class="row mb-5">
            <div class="col-xl-12">
                <h6 class="text-uppercase text-primary mb-4">Information du dévis</h6>
                <div class="row">
                    <div class="col-xl-6 mb-3" :class="Devis.loading.value === true ? 'd-flex align-items-end' : ''">
                        <Input v-if="Devis.loading.value === false" v-model="form.numero" :error="Devis.errors.value.numero" disabled>Numéro du dévis</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>

                    <!-- ----------------------------------------------------------------------------------------- -->

                    <div v-if="form.appro === true" class="col-xl-6 mb-3">
                        <label for="fournisseur" class="form-label">
                            Fournisseur <span class="text-danger">(*)</span>
                            (<a v-if="creationFrs" href="#" @click.prevent="creerFrs" class="text-danger">Fermer</a>
                            <a v-else href="#" @click.prevent="creerFrs" class="text-primary">Créer nouveau</a>)
                        </label>

                        <MultiSelect v-if="!Fournisseur.loading.value" v-bind:class="hasError ? 'border-danger' : ''" label="nom" valueProp="id"
                            v-model="form.fournisseur" :options="Fournisseur.entities.value" :closeOnSelect="false"
                            :clearOnSelect="false" :searchable="true" noOptionsText="Aucun fournisseur"
                            noResultsText="Aucun fournisseur" @close="check" />
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />

                        <div class="text-danger mt-1" v-if="hasError">
                            {{ Devis.errors.value.fournisseur[0] }}
                        </div>
                    </div>

                    <div v-if="creationFrs" class="col-xl-12 border border-secondary shadow p-5 mb-5 mt-3">
                        <NouveauFournisseurComponent @frs-cree="frsCree" :nouveau="true" />
                    </div>

                    <!-- ----------------------------------------------------------------------------------------- -->

                    <div v-if="form.appro === false" class="col-xl-6 mb-3">
                        <label for="client" class="form-label">
                            Client <span class="text-danger">(*)</span>
                            (<a v-if="creationClient" href="#" @click.prevent="creerClient" class="text-danger">Fermer</a>
                            <a v-else href="#" @click.prevent="creerClient" class="text-primary">Créer nouveau</a>)
                        </label>

                        <MultiSelect v-if="!Client.loading.value" v-bind:class="hasError ? 'border-danger' : ''" label="nom" valueProp="id"
                            v-model="form.client" :options="Client.entities.value" :closeOnSelect="false"
                            :clearOnSelect="false" :searchable="true" noOptionsText="Aucun client"
                            noResultsText="Aucun client" @close="check" />

                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />

                        <div class="text-danger mt-1" v-if="hasError">
                            {{ Devis.errors.value.client[0] }}
                        </div>
                    </div>

                    <div v-if="creationClient" class="col-xl-12 border border-secondary shadow p-5 mb-5 mt-3">
                        <NouveauClientFormComponent @client-cree="clientCree" :nouveau="true" />
                    </div>

                    <!-- ----------------------------------------------------------------------------------------- -->

                    <div class="col-xl-6 mb-3">
                        <label for="date" class="form-label">Date <span class="text-danger">(*)</span></label>
                        <Datepicker locale="fr-MG" v-model="form.date" selectText="Valider" enableSeconds
                            cancelText="Annuler" placeholder="Selectionner la date" arrowNavigation :state="dateState"
                            @update:modelValue="checkDate"></Datepicker>

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
                <div class="d-flex justify-content-between mb-4">
                    <h6 class="text-uppercase text-primary">Information de l'article</h6>
                    <button v-if="creationArticle" @click="creerArticle" type="button" class="btn btn-danger"><i class="fa fa-close me-2"></i>Fermer</button>
                    <button v-else @click="creerArticle" type="button" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Créer une nouvelle</button>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div v-if="creationArticle" class="border border-secondary shadow p-5 mb-5 mt-3">
                            <NouveauArticleComponent @article-cree="articleCree" />
                        </div>

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
                                <tr v-for="i in nombreArticle" :key="i">
                                    <td>
                                        <MultiSelect label="designation" valueProp="id" v-model="form.articles[i - 1].id"
                                            :options="Article.entities.value" :closeOnSelect="false"
                                            :clearOnSelect="false" :searchable="true" noOptionsText="Aucun article"
                                            noResultsText="Aucun article" @close="checkArticle" />
                                        <span class="text-danger" v-if="Devis.errors.value[`articles.${i - 1}.id`]">
                                            {{ Devis.errors.value[`articles.${i - 1}.id`][0] }}
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" @input="calculerMontant(i - 1)" v-model="form.articles[i - 1].quantite" class="form-control">
                                        <span class="text-danger" v-if="Devis.errors.value[`articles.${i - 1}.quantite`]">
                                            {{ Devis.errors.value[`articles.${i - 1}.quantite`][0] }}
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" @input="calculerMontant(i - 1)" v-model="form.articles[i - 1].pu" name="pu" id="pu" class="form-control">
                                        <span class="text-danger" v-if="Devis.errors.value[`articles.${i - 1}.pu`]">
                                            {{ Devis.errors.value[`articles.${i - 1}.pu`][0] }}
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" @input="calculerMontant(i - 1)" v-model="form.articles[i - 1].tva" name="tva" id="tva" class="form-control">
                                        <span class="text-danger" v-if="Devis.errors.value[`articles.${i - 1}.tva`]">
                                            {{ Devis.errors.value[`articles.${i - 1}.tva`][0] }}
                                        </span>
                                    </td>
                                    <td><input type="number" disabled v-model="form.articles[i - 1].montant_ht" name="montant_ht" id="montant_ht" class="form-control"></td>
                                    <td><input type="number" disabled v-model="form.articles[i - 1].montant_ttc" name="montant_ttc" id="montant_ttc" class="form-control"></td>
                                    <td>
                                        <button type="button" v-if="i > 1" @click.prevent="removeItem(i - 1)" class="btn btn-danger"><i class="fa fa-minus"></i></button>
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
                    <SaveBtn v-if="nouveau" @click.prevent="save" :loading="Devis.creating.value">Enregistrer</SaveBtn>
                    <SaveBtn v-else @click.prevent="save" :loading="Devis.updating.value">Mettre a jour</SaveBtn>
                </div>
            </div>
        </div>
    </form>
</template>

<script>

import Input from '../html/Input.vue';
import SaveBtn from '../html/SaveBtn.vue';
import useCRUD from '../../services/CRUDServices.ts';
import Datepicker from '@vuepic/vue-datepicker';
import MultiSelect from '@vueform/multiselect';
import Flash from '../../functions/Flash';
import { Skeletor } from 'vue-skeletor';
import Config from '../../config/config.ts';
import { computed, onMounted, onBeforeMount, ref } from 'vue';

import NouveauArticleComponent from '../article/NouveauArticleComponent.vue';
import NouveauFournisseurComponent from '../fournisseur/FournisseurFormComponent.vue';
import NouveauClientFormComponent from '../client/ClientFormComponent.vue';

import { montantHT, montantTTC } from '../../functions/functions.ts';

const Devis = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Devis
const Fournisseur = useCRUD('/fournisseur'); // Recuperer le service de CRUD de fournisseur
const Client = useCRUD('/client'); // Recuperer le service de CRUD de client
const Article = useCRUD('/article')

export default {
    name: "DevisFormComponent",
    components: {
        Input, SaveBtn, Datepicker, MultiSelect, Skeletor, NouveauArticleComponent, NouveauFournisseurComponent, NouveauClientFormComponent,
    },

    props: {
        /**
         * Permet de savoir si on veut modifier un devis ou créer une
         * @values true, false
         */
        nouveau: {
            type: Boolean,
            required: false,
        },

        /**
         * Devis a modifier dans le cas d'une modification
         */
        devis: {
            type: Object,
            required: false,
        },

        /**
         * Permet de determiner si le devis est un approvisionnement ou vente
         * @values true, false
         */
        appro: {
            type: Boolean,
            required: true,
            default: true,
        },
    },

    setup(props) {
        const form = ref({
            numero: null,
            type: 1,
            date: null,
            validite: 7,
            fournisseur: null,
            client: null,
            appro: props.appro,
            articles: [],
        });

        const nombreArticle = ref(1);
        const creationArticle = ref(false);
        const creationFrs = ref(false);
        const creationClient = ref(false);

        const articleCree = () => {
            Article.all()
            creationArticle.value = false;
        }

        const creerArticle = () => {
            creationArticle.value = !creationArticle.value;
        }

        const frsCree = () => {
            Fournisseur.all()
            creationFrs.value = false;
        }

        const creerFrs = () => {
            creationFrs.value = !creationFrs.value;
        }

        const clientCree = () => {
            Client.all()
            creationClient.value = false;
        }

        const creerClient = () => {
            creationClient.value = !creationClient.value;
        }

        const save = async () => {
            if (props.nouveau === true) {
                await Devis.create(form.value)
                if (Devis.success.value !== null) {
                    resetForm()
                    setDevisKey()
                }
            } else {
                await Devis.update(props.devis.id, form.value)
            }

            window.scrollTo({ top: 0, behavior: 'smooth' })
            Devis.success.value = null
        }

        const resetForm = () => {
            form.value = {
                numero: null,
                type: 1,
                date: null,
                validite: 7,
                fournisseur: null,
                client: null,
                appro: props.appro,
                articles: [],
            }
            nombreArticle.value = 1
            generateArticleArray(nombreArticle.value)
        }

        const check = (e) => {
            if (e.modelValue !== null) Devis.errors.value.fournisseur = null
        }

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

        const checkDate = (e) => {
            Devis.errors.value.date = null
        }

        const generateArticleArrayFromArticles = (articles) => {
            articles.forEach(article => addItem(false, article))
        }

        const generateArticleArray = (nombreArticle) => {
            for (let i = 0; i < nombreArticle; i++) {
                addItem(false)
            }
        }

        const removeItem = (index) => {
            form.value.articles.splice(index, 1)
            nombreArticle.value--
        }

        const addItem = (increment = true, article = null) => {
            if (nombreArticle.value > Config.devis.MAX_ARTICLE) {
                Flash('error', "Message d'erreur", `Nombre d'article maximum atteint. Limite ${Config.devis.MAX_ARTICLE}`)
                return
            }

            if (article === null) {
                form.value.articles.push({
                    id: null,
                    quantite: 1,
                    pu: null,
                    tva: 20.00,
                    montant_ht: null,
                    montant_ttc: null,
                })
            } else {
                form.value.articles.push({
                    id: article === null ? null : article.id,
                    quantite: article === null ? 1 : article.pivot.quantite,
                    pu: article === null ? null : article.pivot.pu,
                    tva: article === null ? 20 : article.pivot.tva,
                    montant_ht: article === null ? null : montantHT(article),
                    montant_ttc: article === null ? null : montantTTC(article),
                })
            }

            if (increment === true) nombreArticle.value++
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
         * Recuperer la nouvelle numéro du dévis et le mettre dans la formulaire
         *
         * @return  {void}
         */
        const setDevisKey = async () => {
            await Devis.getKey({ type: 1, appro: form.value.appro })
            form.value.numero = Devis.key
        }

        const hasError = computed (() => {
            if (Devis.errors.value.fournisseur && Devis.errors.value.fournisseur.length > 0 && form.value.appro === true) return true
            if (Devis.errors.value.client && Devis.errors.value.client.length > 0 && form.value.appro === false) return true
            return false
        })

        const dateState = computed(() => {
            if (Devis.errors.value.date && Devis.errors.value.date.length > 0) return false
            return null
        })

        onMounted(() => {
            Article.all();
            Fournisseur.all();
            Client.all();
            if (props.nouveau === true) setDevisKey();
        })

        onBeforeMount(() => {
            if (props.nouveau === false) {
                nombreArticle.value = props.devis.articles.length
                form.value.numero = props.devis.numero
                form.value.date = props.devis.date
                form.value.validite = props.devis.validite
                form.value.fournisseur = props.devis.fournisseur
                form.value.client = props.devis.client
                form.value.type = 1
                form.value.appro = props.appro

                generateArticleArrayFromArticles(props.devis.articles)
            } else {
                form.value.appro = props.appro;
                generateArticleArray(nombreArticle.value);
            }
        })

        return {
            Devis, Fournisseur, Client, Article, Flash, creerArticle, creationArticle, articleCree, creationFrs, frsCree, creerFrs,
            form, nombreArticle, checkArticle, setDevisKey, hasError, dateState, calculerMontant, addItem, removeItem,
            generateArticleArray, generateArticleArrayFromArticles, checkDate, check, save, clientCree, creerClient, creationClient,
        }
    },

}

</script>
