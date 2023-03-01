<template>
    <SearchFromOldDevisComponent :appro="appro ? 1 : 0" v-if="nouveau" @articles="(id) => genereateArticleFromOld(id)">
    </SearchFromOldDevisComponent>

    <form action="" method="post" @submit.prevent="confirmSave" enctype="multipart/form-data">
        <div class="row mb-5">
            <div class="col-xl-12">
                <h6 class="text-uppercase text-primary mb-4">Information du devis</h6>
                <div class="row">
                    <div class="col-xl-6 mb-3" :class="Devis.loading.value === true ? 'd-flex align-items-end' : ''">
                        <Input v-if="Devis.loading.value === false" v-model="form.numero"
                            :error="Devis.errors.value.numero" :disabled="numberAuto">Numéro du devis</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>

                    <!-- ----------------------------------------------------------------------------------------- -->
                    <!-- POur la section de fournisseur et la création a la volée -->

                    <div v-if="form.appro === true" class="col-xl-6 mb-3">
                        <label for="fournisseur" class="form-label">
                            Fournisseur <span class="text-danger">(*)</span>
                            (<a v-if="creationFrs" href="#" @click.prevent="creerFrs" class="text-danger">Fermer</a>
                            <a v-else href="#" @click.prevent="creerFrs" class="text-primary">Créer nouveau</a>)
                        </label>

                        <MultiSelect v-if="!Fournisseur.loading.value" v-bind:class="hasError ? 'border-danger' : ''"
                            label="nom" valueProp="id" v-model="form.fournisseur" :options="Fournisseur.entities.value"
                            :closeOnSelect="true" :clearOnSelect="false" :searchable="true"
                            noOptionsText="Aucun fournisseur" noResultsText="Aucun fournisseur" @close="check" />
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />

                        <div class="text-danger mt-1" v-if="hasError">
                            {{ Devis.errors.value.fournisseur[0] }}
                        </div>
                    </div>

                    <div v-if="creationFrs" class="col-xl-12 border border-secondary shadow p-5 mb-5 mt-3">
                        <NouveauFournisseurComponent @frs-cree="frsCree" :nouveau="true" />
                    </div>

                    <!-- ----------------------------------------------------------------------------------------- -->
                    <!-- POur la section de client et la création a la volée -->

                    <div v-if="form.appro === false" class="col-xl-6 mb-3">
                        <label for="client" class="form-label">
                            Client <span class="text-danger">(*)</span>
                            (<a v-if="creationClient" href="#" @click.prevent="creerClient"
                                class="text-danger">Fermer</a>
                            <a v-else href="#" @click.prevent="creerClient" class="text-primary">Créer nouveau</a>)
                        </label>

                        <MultiSelect v-if="!Client.loading.value" v-bind:class="hasError ? 'border-danger' : ''"
                            label="nom" valueProp="id" v-model="form.client" :options="Client.entities.value"
                            :closeOnSelect="true" :clearOnSelect="false" :searchable="true" noOptionsText="Aucun client"
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
                        <Datepicker locale="fr-MG" v-model="form.date" selectText="Valider" :enableTimePicker="false"
                            cancelText="Annuler" placeholder="Selectionner la date" arrowNavigation
                            @update:modelValue="checkDate" utc />

                        <div class="text-danger mt-1" v-if="dateState === false">
                            {{ Devis.errors.value.date[0] }}
                        </div>
                    </div>

                    <div class="col-xl-6 mb-3">
                        <Input type="number" v-model="form.validite" :error="Devis.errors.value.validite"
                            required>Validité du devis (en Jour)</Input>
                    </div>

                    <!-- Mentionner ici le point de vente ou entrepot qui fait la vente. Uniquement pour la vente -->

                    <div v-if="form.appro === false" class="col-xl-12 mb-3">
                        <label for="depot" class="form-label">Point de vente ou Depôt</label>

                        <MultiSelect v-model="form.depot" placeholder="Selectionnez" noResultsText="Aucun depot trouvé"
                            noOptionsText="Aucun depot trouvé" label="nom" valueProp="id" :closeOnSelect="true"
                            :filter-results="true" :multiple="false" :min-chars="1" :resolve-on-load="resolveOnLoad"
                            :delay="500" :searchable="false" :object="false" :options="Depot.entities.value" />

                        <div class="text-danger mt-1" v-if="hasError">
                            {{ Devis.errors.value.depot[0] }}
                        </div>
                    </div>

                    <!-- ------------------------------------------- -->

                    <div class="col-xl-12">
                        <FileInput :multiple="false" @fileChanged="handleFileChange"
                            :default="(devis.file_path !== null && devis.file_path !== undefined) ? 'http://localhost:8000/storage/' + devis.file_path : undefined">
                            Pièce jointe si necessaire</FileInput>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="appro || form.depot" class="row mb-5">
            <div class="col-xl-12">
                <div class="d-flex justify-content-between mb-4">
                    <h6 class="text-uppercase text-primary">Information de l'article</h6>
                    <button v-if="creationArticle" @click="creerArticle" type="button" class="btn btn-danger"><i
                            class="fa fa-close me-2"></i>Fermer</button>
                    <button v-else-if="appro === true" @click="creerArticle" type="button" class="btn btn-primary"><i
                            class="fa fa-plus me-2"></i>Créer un article</button>
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
                                    <th>Prix unitaire HT</th>
                                    <th v-if="assujeti || appro === true">TVA</th>
                                    <th>Montant HT</th>
                                    <th>Montant TTC</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="i in nombreArticle" :key="i">
                                    <td>
                                        <MultiSelect v-if="appro === true" label="designation" valueProp="id"
                                            v-model="form.articles[i - 1].id" :options="Article.entities.value"
                                            :closeOnSelect="true" :clearOnSelect="false" :searchable="true"
                                            noOptionsText="Aucun article" noResultsText="Aucun article"
                                            @close="checkArticle" />

                                        <MultiSelect v-else v-model="form.articles[i - 1].object"
                                            placeholder="Rechercher un article" noResultsText="Aucun article trouvé"
                                            noOptionsText="Aucun article trouvé" :closeOnSelect="true"
                                            :filter-results="true" :multiple="false" :min-chars="1"
                                            :resolve-on-load="resolveOnLoad" :delay="500" :searchable="true"
                                            :object="true" :options="async function (query: string) {
                                                return await fetchArticles(query)
                                            }" @select="handleSelect(i - 1)" />

                                        <span class="text-danger" v-if="Devis.errors.value[`articles.${i - 1}.id`]">
                                            {{ Devis.errors.value[`articles.${i - 1}.id`][0] }}
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" @input="calculerMontant(i - 1)"
                                            v-model="form.articles[i - 1].quantite" class="form-control">
                                        <span class="text-danger"
                                            v-if="Devis.errors.value[`articles.${i - 1}.quantite`]">
                                            {{ Devis.errors.value[`articles.${i - 1}.quantite`][0] }}
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" @input="calculerMontant(i - 1)"
                                            v-model="form.articles[i - 1].pu" name="pu" id="pu" class="form-control">
                                        <span class="text-danger" v-if="Devis.errors.value[`articles.${i - 1}.pu`]">
                                            {{ Devis.errors.value[`articles.${i - 1}.pu`][0] }}
                                        </span>
                                    </td>
                                    <td v-if="assujeti || appro === true">
                                        <input type="number" @input="calculerMontant(i - 1)"
                                            v-model="form.articles[i - 1].tva" name="tva" id="tva" class="form-control">
                                        <span class="text-danger" v-if="Devis.errors.value[`articles.${i - 1}.tva`]">
                                            {{ Devis.errors.value[`articles.${i - 1}.tva`][0] }}
                                        </span>
                                    </td>
                                    <td><input type="number" disabled v-model="form.articles[i - 1].montant_ht"
                                            name="montant_ht" id="montant_ht" class="form-control"></td>
                                    <td><input type="number" disabled v-model="form.articles[i - 1].montant_ttc"
                                            name="montant_ttc" id="montant_ttc" class="form-control"></td>
                                    <td>
                                        <button type="button" v-if="i > 1" @click.prevent="removeItem(i - 1)"
                                            class="btn btn-danger"><i class="fa fa-minus"></i></button>
                                        <button type="button" v-else @click.prevent="addItem()"
                                            class="btn btn-success"><i class="fa fa-plus"></i></button>
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
                    <SaveBtn v-if="nouveau" :loading="Devis.creating.value" :disabled="!appro && !form.depot">
                        Enregistrer</SaveBtn>
                    <SaveBtn v-else :loading="Devis.updating.value" :disabled="!appro && !form.depot">Mettre a jour
                    </SaveBtn>
                </div>
            </div>
        </div>
    </form>
</template>

<script lang="ts">
import Input from '../html/Input.vue';
import { Skeletor } from 'vue-skeletor';
import Config from '../../config/config';
import SaveBtn from '../html/SaveBtn.vue';
import Flash from '../../functions/Flash';
import FileInput from '../html/FileInput.vue';
import MultiSelect from '@vueform/multiselect';
import Datepicker from '@vuepic/vue-datepicker';
import useCRUD from '../../services/CRUDServices';
import { montantHT, montantTTC } from '../../functions/functions';
import ArticleFormComponent from '../article/ArticleFormComponent.vue';
import NouveauClientFormComponent from '../client/ClientFormComponent.vue';
import { computed, onMounted, onBeforeMount, ref, defineComponent, Ref } from 'vue';
import NouveauFournisseurComponent from '../fournisseur/FournisseurFormComponent.vue';
import store from '../../store';
import { useRouter, useRoute } from 'vue-router'
import SimpleAlert from 'vue3-simple-alert';
import SearchFromOldDevisComponent from "./SearchFromOldDevisComponent.vue"
const { find, entity, loading } = useCRUD('/commandes')


const Depot = useCRUD('/depot'); // Recuperer le service de CRUD de depots
const Client = useCRUD('/client'); // Recuperer le service de CRUD de client
const Article = useCRUD('/article') // Recuperer le service de CRUD de l'article
const Devis = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Devis
const Fournisseur = useCRUD('/fournisseur'); // Recuperer le service de CRUD de fournisseur

type Form = {
    numero: string | null,
    type: number,
    date: Date | null,
    validite: number,
    fournisseur: number | null,
    client: number | null,
    appro: boolean,
    articles: Array<any>,
    file?: FileList | null,
    depot?: any,
}

export default defineComponent({
    name: "DevisFormComponent",
    components: {
        Input, SaveBtn, Datepicker, MultiSelect, Skeletor, ArticleFormComponent, NouveauFournisseurComponent, NouveauClientFormComponent, FileInput, SearchFromOldDevisComponent
    },

    props: {
        nouveau: {
            type: Boolean,
            required: false,
            default: true,
        },

        devis: {
            type: Object,
            required: false,
            default: {}
        },

        appro: {
            type: Boolean,
            required: true,
            default: true,
        },

        numberAuto: {
            type: Boolean,
            required: false,
            default: true,
        },

        hasAttachment: {
            type: Boolean,
            required: false,
            default: false,
        }
    },

    setup(props) {
        const router = useRouter()

        const form = ref({
            numero: null,
            type: 1,
            date: null,
            validite: 7,
            fournisseur: null,
            client: null,
            appro: props.appro,
            articles: [],
            file: null,
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
        const fetchArticles = async (query: string | null): Promise<any> => {
            if (query === null) query = ""
            return await Article.findBy('designation', query, 'depot', form.value.depot)
        }


        /**
         * Permet de faire un recherche de depots en fonction de query
         *
         * @param   {string|null}   query  Query de recherche
         *
         * @return  {Promise}
         */
        const fetchDepots = async (query: string | null): Promise<any> => {

            if (query === null) query = "";
            return await Depot.findBy('nom', query)
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


        /**
         * Permet de detecter qu'un article est crée a la volée
         *
         * @return  {Promise<any>}
         */
        const articleCree = async (): Promise<any> => {
            await Article.all()
            creationArticle.value = false;
        }


        /**
         * Permet de switcher la creation a la volée d'un article
         *
         * @return  {void}
         */
        const creerArticle = (): void => {
            creationArticle.value = !creationArticle.value;
        }


        /**
         * Permet de detecter qu'un client est crée a la volée
         *
         * @return  {Promise<any>}
         */
        const frsCree = async (): Promise<any> => {
            await Fournisseur.all()
            creationFrs.value = false;
        }


        /**
         * Permet de switcher la creation a la vollée d'un fournisseur
         *
         * @return  {void}
         */
        const creerFrs = (): void => {
            creationFrs.value = !creationFrs.value;
        }


        /**
         * Permet de detecter qu'un client est crée a la volée
         *
         * @return  {Promise<any>}
         */
        const clientCree = async (): Promise<any> => {
            await Client.all()
            creationClient.value = false;
        }


        /**
         * Permet de switcher la creation a la vollée d'un client
         *
         * @return  {void}
         */
        const creerClient = (): void => {
            creationClient.value = !creationClient.value;
        }

        const confirmSave = async (): Promise<any> => {
            await SimpleAlert.confirm("Voulez-vous enregister ce devis ?", "Enregistrement", "question").then(() => {
                save()
            }).catch((error: undefined) => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible d'enregister ce devis")
                }
            });
        }

        /**
         * Permet d'enregistrer le devis
         *
         * @return  {Promise}
         */
        const save = async (): Promise<any> => {
            let data = form.value
            const formData = new FormData()

            Object.keys(data).forEach((key) => {
                if (key !== 'file' && key !== 'articles') formData.append(key, data[key] ?? '')
            })


            if (form.value.file && form.value.file.length > 0) {
                formData.append('file', form.value.file[0])
            } else {
                formData.append('file', '');
            }

            if (!assujeti.value && props.appro === false) setArticlesTva(0)

            if (form.value.articles) {
                formData.append('articles', JSON.stringify(form.value.articles))
            }

            if (props.nouveau === true) {
                await Devis.create(formData)

                if (Devis.success.value !== null) {
                    resetForm()
                    setDevisKey()
                }
            } else if (props.devis) {
                await Devis.update(props.devis.id, formData)
            }
            if (Devis.entity.value.id != undefined) router.push({ name: props.appro ? 'devis.fournisseur.voir' : 'devis.client.voir', params: { id: Devis.entity.value.id } })
            window.scrollTo({ top: 0, behavior: 'smooth' })
            Devis.success.value = null
        }


        const setArticlesTva = (tva: number): void => {
            form.value.articles.map(article => {
                article.tva = tva
            })
        }


        /**
         * Permet de reinitialiser tous les champs
         *
         * @return  {void}
         */
        const resetForm = (): void => {
            form.value = {
                numero: null,
                type: 1,
                date: null,
                validite: 7,
                fournisseur: null,
                client: null,
                appro: props.appro,
                articles: [],
                file: null,
            }

            nombreArticle.value = 1
            generateArticleArray(nombreArticle.value)
        }


        /**
         * Verifier si le champ de fournisseur est valide.
         * Si valide, supprimer les erreurs associé
         *
         * @param   {Object}  e
         *
         * @return  {void}
         */
        const check = (e: { modelValue: null; }): void => {
            if (e.modelValue !== null) Devis.errors.value.fournisseur = null
        }


        /**
         * Permet de verifier si un article a ajouter peut vraiment être ajouté au tableau d'articles
         *
         * @param   {Object}  e  [e description]
         *
         * @return  {void}
         */
        const checkArticle = (e: { modelValue: string; }): void => {
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
         * Mettre a jour la date et supprime les erreurs
         *
         * @param   {Date}  date  La date a valider
         *
         * @return  {void}
         */
        const checkDate = (date: Date): void => {
            //form.value.date = date.toLocaleDateString()
            Devis.errors.value.date = null
        }


        /**
         * Généré un tableau d'articles a partir des articles existant
         *
         * @param   {any[]}  articles  Les articles existantes
         *
         * @return  {void}
         */
        const generateArticleArrayFromArticles = (articles: any[]): void => {
            articles.forEach((article: any) => {
                addItem(false, article)
            })
        }

        /**
         * Fonction pour generer un tableau d'article à partir des articles en provenance d'un ancien devis
         *
         *
         */

        const genereateArticleFromOld = async (id) => {
            await find(id)

            entity.value.id = undefined

            if (props.appro == false) {
                form.value.depot = entity.value.depot
            }
            nombreArticle.value = 0
            form.value.articles = []
            addItem()
            entity.value.articles.forEach((article, index) => {
                if (index < (entity.value.articles.length - 1)) addItem()
                form.value.articles[index].id = article.id
                form.value.articles[index].quantite = article.pivot.quantite
                form.value.articles[index].pu = article.pivot.pu
                form.value.articles[index].tva = article.pivot.tva

                if (props.appro == false) form.value.articles[index].object = {
                    id: article.id,
                    value: article.id,
                    reference: article.reference,
                    designation: article.designation,
                    quantite: article.pivot.quantite,
                    pu: article.pivot.pu,
                    label: `${article.reference} - ${article.designation} - ${article.pivot.pu}`
                }

                calculerMontant(index)

            })

        }

        /**
         * Generer un tableau d'articles (Squelette d'articles)
         *
         * @param   {number}  nombreArticle  Nombre d'article a généré
         *
         * @return  {void}
         */
        const generateArticleArray = (nombreArticle: number): void => {
            for (let i = 0; i < nombreArticle; i++) {
                addItem(false)
            }
        }


        /**
         * Permet de retirer un article dans le tableau des articles
         *
         * @param   {number}  index  Index de l'article dans le tableau
         *
         * @return  {void}
         */
        const removeItem = (index: number): void => {
            form.value.articles.splice(index, 1)
            nombreArticle.value--
        }


        /**
         * Permet d'ajouter un article dans le tableau d'articles
         *
         * @param   {boolean}  increment  Si on doit incrementer le nombre d'article
         * @param   {any}      article    Objet contenant l'article a ajouter dans la tableau d'articles
         *
         * @return  {void}
         */
        const addItem = (increment: boolean = true, article: any = null): void => {
            if (nombreArticle.value > Config.devis.MAX_ARTICLE) {
                Flash('error', "Message d'erreur", `Nombre d'article maximum atteint. Limite ${Config.devis.MAX_ARTICLE}`)
                return
            }

            if (article === null) {
                form.value.articles.push({
                    id: null,
                    quantite: 1,
                    pu: null,
                    tva: 20,
                    montant_ht: null,
                    montant_ttc: null,
                    object: null,
                })
            } else {


                form.value.articles.push({
                    id: article.id,
                    quantite: article.pivot.quantite,
                    pu: article.pivot.pu,
                    tva: article.pivot.tva,
                    montant_ht: montantHT(article),
                    montant_ttc: montantTTC(article),
                    ...(props.appro === false ? {
                        object: {
                            id: article.id,
                            value: article.id,
                            reference: article.reference,
                            designation: article.designation,
                            quantite: article.pivot.quantite,
                            pu: article.pivot.pu,
                            label: `${article.reference} - ${article.designation} - ${article.pivot.pu}`
                        },
                    } : {})
                })

                console.log(form.value.articles, "io izy vita")
            }

            if (increment === true) nombreArticle.value++
        }


        /**
         * Permet de calculer le montant pour une ligne de l'article
         *
         * @param {Number}  index   Index de la ligne darticle
         */
        const calculerMontant = (index: number) => {
            let pu = form.value.articles[index].pu
            let quantite = form.value.articles[index].quantite
            let tva = form.value.articles[index].tva


            if (pu < 0) form.value.articles[index].pu = Math.abs(pu)
            if (quantite < 0) form.value.articles[index].quantite = Math.abs(quantite)
            if (tva < 0) form.value.articles[index].tva = Math.abs(tva)


            if (assujeti.value === false && props.appro === false) tva = 0;

            let montant_ht = Math.round((Math.abs(quantite) * Math.abs(pu)) * 100) / 100
            let montant_ttc = Math.round((montant_ht + (montant_ht * Math.abs(tva) / 100)) * 100) / 100

            form.value.articles[index].montant_ht = montant_ht
            form.value.articles[index].montant_ttc = montant_ttc

        }


        /**
         * Recuperer la nouvelle numéro du devis et le mettre dans la formulaire
         *
         * @return  {Promise}
         */
        const setDevisKey = async (): Promise<any> => {
            await Devis.getKey(1, form.value.appro)
            form.value.numero = Devis.key.value
        }


        /**
         * Permet de savoir si le champ client ou fournisseur contient des erreurs
         *
         * @return  {boolean}
         */
        const hasError = computed((): boolean => {
            if (Devis.errors.value.fournisseur && Devis.errors.value.fournisseur.length > 0 && form.value.appro === true) return true
            if (Devis.errors.value.client && Devis.errors.value.client.length > 0 && form.value.appro === false) return true
            return false
        })


        /**
         * Changer l'etat de la la datepicker en cas d'erreur
         *
         * @return  {Boolean|null}
         */
        const dateState: Ref<boolean | null> = computed((): boolean | null => {
            if (Devis.errors.value.date && Devis.errors.value.date.length > 0) return false
            return null
        })


        /**
         * Permet de savoiir si on veut recharger les données pendant le chargement
         */
        const loaded = ref(false)


        /**
         * Quant le composant est monté
         *
         * @return  {Promise}
         */
        onMounted(async (): Promise<any> => {
            Article.all();
            Fournisseur.all();
            Client.all();
            Depot.all(3)
            if (props.nouveau === true) setDevisKey();

            loaded.value = false // Rendre le depot non resolvable on load
        })


        /**
         * Executé aant que le composant soit monté
         */
        onBeforeMount(() => {
            if (props.nouveau === false && props.devis) {
                nombreArticle.value = props.devis.articles.length
                form.value.numero = props.devis.numero
                form.value.date = props.devis.date
                form.value.validite = props.devis.validite
                form.value.fournisseur = props.devis.fournisseur
                form.value.client = props.devis.client
                form.value.type = 1
                form.value.appro = props.appro
                form.value.depot = props.devis.depot

                generateArticleArrayFromArticles(props.devis.articles)
            } else {
                form.value.appro = props.appro;
                generateArticleArray(nombreArticle.value);
            }

            loaded.value = true // Rendre le depot resolvable on load
        })


        /**
         * Permet de gerer l'upload de fichier
         *
         * @param   {FileList}  files  Les fichiers selectionné
         * @return  {void}
         */
        const handleFileChange = (files: FileList): void => {
            form.value.file = files;
        }


        const assujeti = computed((): boolean => {
            return store.getters.isAssujeti;
        })


        /**
         * Permet de determiner si on doit charger le select durant le chargement
         *
         * @return  {boolean}
         */
        const resolveOnLoad = computed((): boolean => {
            return (loaded.value === true && props.nouveau === false)
        })

        return {
            nouveau: props.nouveau,
            Devis, Fournisseur, Client, Article, creationArticle, creationFrs, form, nombreArticle, creationClient, resolveOnLoad, hasError, dateState, store, assujeti, Depot,
            Flash, creerArticle, articleCree, frsCree, creerFrs, checkArticle, setDevisKey, calculerMontant, addItem, removeItem, generateArticleArray,
            generateArticleArrayFromArticles, checkDate, check, save, clientCree, creerClient, handleFileChange, fetchArticles, handleSelect, fetchDepots, confirmSave, genereateArticleFromOld
        }
    },

});

</script>
