<template>
    <form action="" method="post">
        <div class="row mb-5">
            <div class="col-xl-12">
                <h6 class="text-uppercase text-primary mb-4">Information de la commande</h6>
                <div class="row">
                    <div class="col-xl-6 mb-3" :class="Commande.loading.value === true ? 'd-flex align-items-end' : ''">
                        <Input v-if="Commande.loading.value === false" v-model="form.numero" :error="Commande.errors.value.numero" disabled>Numéro du dévis</Input>
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
                            {{ Commande.errors.value.fournisseur[0] }}
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
                            {{ Commande.errors.value.client[0] }}
                        </div>
                    </div>

                    <div v-if="creationClient" class="col-xl-12 border border-secondary shadow p-5 mb-5 mt-3">
                        <NouveauClientFormComponent @client-cree="clientCree" :nouveau="true" />
                    </div>

                    <!-- ----------------------------------------------------------------------------------------- -->

                    <div class="col-xl-6 mb-3">
                        <label for="date" class="form-label">Date <span class="text-danger">(*)</span></label>
                        <Datepicker locale="fr-MG" v-model="form.date" selectText="Valider"
                            :enableTimePicker="false"
                            cancelText="Annuler" placeholder="Selectionner la date" arrowNavigation
                            @update:modelValue="checkDate"></Datepicker>

                        <div class="text-danger mt-1" v-if="dateState === false">
                            {{ Commande.errors.value.date[0] }}
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <Input v-model="form.adresse_livraison" :error="Commande.errors.value.adresse_livraison" required>Adresse de livraison</Input>
                    </div>

                    <!-- Mentionner ici le point de vente ou entrepot qui fait la vente. Uniquement pour la vente -->

                    <div v-if="form.appro === false" class="col-xl-12 mb-3">
                        <label for="depot" class="form-label">Point de vente ou Depôt</label>

                        <MultiSelect
                            v-model="form.depot"
                            placeholder="Rechercher un depot"
                            noResultsText="Aucun depot trouvé"
                            noOptionsText="Aucun depot trouvé"
                            label="nom"
                            valueProp="id"
                            :closeOnSelect="true"
                            :filter-results="true"
                            :multiple="false"
                            :min-chars="1"
                            :resolve-on-load="resolveOnLoad"
                            :delay="500"
                            :searchable="true"
                            :object="false"
                            :disabled="(devis && devis.id !== null) || (commande && commande.devis !== null)"
                            :options="async function (query: string) {
                                return await fetchDepots(query)
                            }"
                        />

                        <div class="text-danger mt-1" v-if="hasError">
                            {{ Commande.errors.value.depot[0] }}
                        </div>
                    </div>

                    <!-- ------------------------------------------- -->
                </div>
            </div>
        </div>

        <div v-if="appro || form.depot" class="row mb-5">
            <div class="col-xl-12">
                <div class="d-flex justify-content-between mb-4">
                    <h6 class="text-uppercase text-primary">Information de l'article</h6>
                    <button v-if="creationArticle" @click="creerArticle" type="button" class="btn btn-danger"><i class="fa fa-close me-2"></i>Fermer</button>
                    <button v-else-if="appro" @click="creerArticle" type="button" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Créer une nouvelle</button>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div v-if="creationArticle" class="border border-secondary shadow p-5 mb-5 mt-3">
                            <ArticleFormComponent @article-cree="articleCree" :nouveau="true" />
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
                                            v-if="appro === true"
                                            :options="Article.entities.value" :closeOnSelect="false"
                                            :clearOnSelect="false" :searchable="true" noOptionsText="Aucun article"
                                            noResultsText="Aucun article" @close="checkArticle" />

                                        <MultiSelect
                                            v-else
                                            v-model="form.articles[i - 1].object"
                                            placeholder="Rechercher un article"
                                            noResultsText="Aucun article trouvé"
                                            noOptionsText="Aucun article trouvé"
                                            :closeOnSelect="true"
                                            :filter-results="true"
                                            :multiple="false"
                                            :min-chars="1"
                                            :resolve-on-load="resolveOnLoad"
                                            :delay="500"
                                            :searchable="true"
                                            :object="true"
                                            :options="async function (query: string) {
                                                return await fetchArticles(query)
                                            }"
                                            @select="handleSelect(i-1)"
                                        />
                                        <span class="text-danger" v-if="Commande.errors.value[`articles.${i - 1}.id`]">
                                            {{ Commande.errors.value[`articles.${i - 1}.id`][0] }}
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" @input="calculerMontant(i - 1)" v-model="form.articles[i - 1].quantite" class="form-control">
                                        <span class="text-danger" v-if="Commande.errors.value[`articles.${i - 1}.quantite`]">
                                            {{ Commande.errors.value[`articles.${i - 1}.quantite`][0] }}
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" @input="calculerMontant(i - 1)" v-model="form.articles[i - 1].pu" name="pu" id="pu" class="form-control">
                                        <span class="text-danger" v-if="Commande.errors.value[`articles.${i - 1}.pu`]">
                                            {{ Commande.errors.value[`articles.${i - 1}.pu`][0] }}
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" @input="calculerMontant(i - 1)" v-model="form.articles[i - 1].tva" name="tva" id="tva" class="form-control">
                                        <span class="text-danger" v-if="Commande.errors.value[`articles.${i - 1}.tva`]">
                                            {{ Commande.errors.value[`articles.${i - 1}.tva`][0] }}
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
                    <SaveBtn v-if="nouveau" @click.prevent="save" :loading="Commande.creating.value">Enregistrer</SaveBtn>
                    <SaveBtn v-else @click.prevent="save" :loading="Commande.updating.value">Mettre a jour</SaveBtn>
                </div>
            </div>
        </div>
    </form>
</template>

<script lang="ts">
import Input from '../html/Input.vue';
import { Skeletor } from 'vue-skeletor';
import router from '../../router/router';
import Config from '../../config/config';
import SaveBtn from '../html/SaveBtn.vue';
import Flash from '../../functions/Flash';
import MultiSelect from '@vueform/multiselect';
import Datepicker from '@vuepic/vue-datepicker';
import useCRUD from '../../services/CRUDServices';
import { montantHT, montantTTC } from '../../functions/functions';
import ArticleFormComponent from '../article/ArticleFormComponent.vue';
import NouveauClientFormComponent from '../client/ClientFormComponent.vue';
import { computed, onMounted, onBeforeMount, ref, defineComponent } from 'vue';
import NouveauFournisseurComponent from '../fournisseur/FournisseurFormComponent.vue';

const Commande = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Commande
const Fournisseur = useCRUD('/fournisseur'); // Recuperer le service de CRUD de fournisseur
const Client = useCRUD('/client'); // Recuperer le service de CRUD de client
const Article = useCRUD('/article') // Recuperer le service de CRUD d'article
const Depot = useCRUD('/depot') // Recuperer le service de CRUD de depot

type Form = {
    numero: string|null,
    type: number,
    date: Date|null,
    adresse_livraison: string|null
    validite?: number,
    fournisseur: number|null,
    client: number|null,
    appro: boolean,
    articles: Array<any>,
    devis?: number,
    depot?: number,
}

export default defineComponent({
    name: "CommandeFormComponent",
    components: {
        Input, SaveBtn, Datepicker, MultiSelect, Skeletor, ArticleFormComponent, NouveauFournisseurComponent, NouveauClientFormComponent,
    },

    props: {
        /**
         * Permet de savoir si on veut modifier un commande ou créer une
         * @values true, false
         */
        nouveau: {
            type: Boolean,
            required: false,
        },

        /**
         * Commande a modifier dans le cas d'une modification
         */
        commande: {
            type: Object,
            required: false,
            default: null,
        },

        /**
         * Permet de determiner si le commande est un approvisionnement ou vente
         * @values true, false
         */
        appro: {
            type: Boolean,
            required: true,
            default: true,
        },

        devis: {
            type: Object,
            required: false,
            default: null,
        },
    },

    setup(props) {
        const form = ref({
            numero: null,
            type: 2,
            date: null,
            adresse_livraison: null,
            fournisseur: null,
            client: null,
            appro: props.appro,
            articles: [],
        } as Form);

        const nombreArticle = ref(1);
        const creationArticle = ref(false);
        const creationFrs = ref(false);
        const creationClient = ref(false);

        /**
         * Permet de faire un recherche d'articles en fonction de query
         *
         * @param   {string|null}   query  Query de recherche
         *
         * @return  {Promise}
         */
        const fetchArticles = async (query: string|null): Promise<any> => {
            if (query === null) query = ""
            return await Article.findBy('designation', query)
        }

        /**
         * Permet de detecter l'evenement de selection d'un article parmi la liste
         * Permet aussi de calculer le montant
         *
         * @param   {number}   index  Index de l'article
         *
         * @return  {void}
         */
        const handleSelect = (index: number): void => {
            const object = form.value.articles[index].object
            form.value.articles[index].id = object.id
            form.value.articles[index].pu = object.pu
            calculerMontant(index)
        }

        const fetchDepots = async (query: string|null): Promise<any> => {
            if (query === null) query = ""
            return await Depot.findBy('nom', query)
        }

        const articleCree = async (): Promise<any> => {
            await Article.all()
            creationArticle.value = false;
        }

        const creerArticle = (): void => {
            creationArticle.value = !creationArticle.value;
        }

        const frsCree = async (): Promise<any> => {
            await Fournisseur.all()
            creationFrs.value = false;
        }

        const creerFrs = (): void => {
            creationFrs.value = !creationFrs.value;
        }

        const clientCree = async (): Promise<any> => {
            await Client.all()
            creationClient.value = false;
        }

        const creerClient = (): void => {
            creationClient.value = !creationClient.value;
        }

        const save = async () => {
            if (props.nouveau === true) {
                await Commande.create(form.value)
                if (Commande.success.value !== null) {
                    router.replace({ query: {} })
                    resetForm()
                    setCommandeKey()
                }
            } else if (props.commande) {
                await Commande.update(props.commande.id, form.value)
            }

            window.scrollTo({ top: 0, behavior: 'smooth' })
            Commande.success.value = null
        }

        const resetForm = () => {
            form.value = {
                numero: null,
                type: 2,
                date: null,
                adresse_livraison: null,
                fournisseur: null,
                client: null,
                appro: props.appro,
                articles: [],
            }
            nombreArticle.value = 1
            generateArticleArray(nombreArticle.value)
        }

        const check = (e: { modelValue: null; }) => {
            if (e.modelValue !== null) Commande.errors.value.fournisseur = null
        }

        const checkArticle = (e: { modelValue: string; }) => {
            if (form.value.articles.length > 1 && e.modelValue !== null) {
                let find = form.value.articles.filter((article: any) => parseInt(article.id) === parseInt(e.modelValue))
                if (find.length > 1) {
                    let i = 0
                    form.value.articles.map((article: any) => {
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

        const checkDate = () => {
            Commande.errors.value.date = null
        }

        const generateArticleArrayFromArticles = (articles: any[]) => {
            articles.forEach((article: null | undefined) => addItem(false, article))
        }

        const generateArticleArray = (nombreArticle: number) => {
            for (let i = 0; i < nombreArticle; i++) {
                addItem(false)
            }
        }

        const removeItem = (index: number) => {
            form.value.articles.splice(index, 1)
            nombreArticle.value--
        }

        const addItem = (increment: boolean = true, article: any = null) => {
            if (nombreArticle.value > Config.commande.MAX_ARTICLE) {
                Flash('error', "Message d'erreur", `Nombre d'article maximum atteint. Limite ${Config.commande.MAX_ARTICLE}`)
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
                    ...(props.appro === false ? {
                        object: {
                            id: article.id,
                            value: 3,
                            reference: article.reference,
                            designation: article.designation,
                            quantite: article.pivot.quantite,
                            pu: article.pivot.pu,
                            label: `${article.reference} - ${article.designation} - ${article.pivot.pu} (${article.pivot.quantite ?? 'Quantité restant'})`
                        }
                    } : {}),
                })
            }

            if (increment === true) nombreArticle.value++
        }


        /**
         * Permet de calculer le montant pour une ligne de l'article
         *
         * @param {Number}  index   Index de la ligne darticle
         */
        const calculerMontant = (index: string | number) => {
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
         * @return  {Promise}
         */
        const setCommandeKey = async (): Promise<any> => {
            await Commande.getKey(2, form.value.appro)
            form.value.numero = Commande.key.value
        }

        const hasError = computed (() => {
            if (Commande.errors.value.fournisseur && Commande.errors.value.fournisseur.length > 0 && form.value.appro === true) return true
            if (Commande.errors.value.client && Commande.errors.value.client.length > 0 && form.value.appro === false) return true
            return false
        })

        const dateState = computed(() => {
            if (Commande.errors.value.date && Commande.errors.value.date.length > 0) return false
            return null
        })


        /**
         * Permet de savoiir si on veut recharger les données pendant le chargement
         */
        const loaded = ref(false)

        onMounted(() => {
            if (props.appro === true) Article.all();
            Fournisseur.all();
            Client.all();
            if (props.nouveau === true) setCommandeKey();

            loaded.value = false
        })

        onBeforeMount(() => {
            // Si c'est un modification de commande
            if (props.nouveau === false && props.commande) {
                nombreArticle.value = props.commande.articles.length
                form.value.numero = props.commande.numero
                form.value.date = props.commande.date
                form.value.adresse_livraison = props.commande.adresse_livraison
                form.value.fournisseur = props.commande.fournisseur
                form.value.client = props.commande.client
                form.value.type = 2
                form.value.appro = props.appro
                form.value.depot = props.commande.depot ?? null

                generateArticleArrayFromArticles(props.commande.articles)
            }

            // Si création d'une commande a partir d'un dévis
            else if (props.devis !== null && props.devis.id !== undefined) {
                nombreArticle.value = props.devis.articles.length
                form.value.date = props.devis.date
                form.value.adresse_livraison = props.devis.adresse_livraison
                form.value.fournisseur = props.devis.fournisseur
                form.value.client = props.devis.client
                form.value.type = 2
                form.value.appro = props.appro
                form.value.devis = props.devis.id
                form.value.depot = props.devis.depot

                generateArticleArrayFromArticles(props.devis.articles)
            }

            // Création d'une commande a partir de rien
            else {
                form.value.appro = props.appro;
                generateArticleArray(nombreArticle.value);
            }

            loaded.value = true
        })


        /**
         * Permet de determiner si on doit charger le select durant le chargement
         *
         * @return  {boolean}
         */
        const resolveOnLoad = computed((): boolean => {
            return (loaded.value === true && ((props.devis && props.devis.id !== null) || (props.commande && props.commande.id !== null)))
        })

        return {
            Commande, Fournisseur, Client, Article, creationFrs, hasError, dateState, creationClient, form, nombreArticle, creationArticle, resolveOnLoad,
            Flash, creerArticle, articleCree, frsCree, creerFrs, checkArticle, setCommandeKey, calculerMontant, addItem, removeItem, generateArticleArray,
            generateArticleArrayFromArticles, checkDate, check, save, clientCree, creerClient, fetchDepots, fetchArticles, handleSelect,
        }
    },
})

</script>
