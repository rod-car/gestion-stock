<template>
    <form action="" method="post" @submit.prevent="save" enctype="multipart/form-data">
        <div class="row mb-5">
            <div class="col-xl-12">
                <h6 class="text-uppercase text-primary mb-4">Information du dévis</h6>
                <div class="row">
                    <div class="col-xl-6 mb-3" :class="Devis.loading.value === true ? 'd-flex align-items-end' : ''">
                        <Input v-if="Devis.loading.value === false" v-model="form.numero" :error="Devis.errors.value.numero" :disabled="numberAuto">Numéro du dévis</Input>
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

                        <MultiSelect v-if="!Fournisseur.loading.value" v-bind:class="hasError ? 'border-danger' : ''" label="nom" valueProp="id"
                            v-model="form.fournisseur" :options="Fournisseur.entities.value" :closeOnSelect="true"
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
                    <!-- POur la section de client et la création a la volée -->

                    <div v-if="form.appro === false" class="col-xl-6 mb-3">
                        <label for="client" class="form-label">
                            Client <span class="text-danger">(*)</span>
                            (<a v-if="creationClient" href="#" @click.prevent="creerClient" class="text-danger">Fermer</a>
                            <a v-else href="#" @click.prevent="creerClient" class="text-primary">Créer nouveau</a>)
                        </label>

                        <MultiSelect v-if="!Client.loading.value" v-bind:class="hasError ? 'border-danger' : ''" label="nom" valueProp="id"
                            v-model="form.client" :options="Client.entities.value" :closeOnSelect="true"
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
                        <Datepicker locale="fr-MG" v-model="form.date" selectText="Valider"
                            :enableTimePicker="false"
                            cancelText="Annuler" placeholder="Selectionner la date" arrowNavigation
                            @update:modelValue="checkDate" />

                        <div class="text-danger mt-1" v-if="dateState === false">
                            {{ Devis.errors.value.date[0] }}
                        </div>
                    </div>

                    <div class="col-xl-6 mb-3">
                        <Input type="number" v-model="form.validite" :error="Devis.errors.value.validite" required>Validité du dévis (en Jour)</Input>
                    </div>

                    <div class="col-xl-12">
                        <FileInput :multiple="false" @fileChanged="handleChange" :default="(devis.file_path !== null && devis.file_path !== undefined)  ? 'http://localhost:8000/storage/' + devis.file_path : undefined">Pièce jointe si necessaire</FileInput>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-xl-12">
                <div class="d-flex justify-content-between mb-4">
                    <h6 class="text-uppercase text-primary">Information de l'article</h6>
                    <button v-if="creationArticle" @click="creerArticle" type="button" class="btn btn-danger"><i class="fa fa-close me-2"></i>Fermer</button>
                    <button v-else-if="appro === true" @click="creerArticle" type="button" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Créer une nouvelle</button>
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
                                        <MultiSelect v-if="appro === true"
                                            label="designation"
                                            valueProp="id"
                                            v-model="form.articles[i - 1].id"
                                            :options="Article.entities.value"
                                            :closeOnSelect="true"
                                            :clearOnSelect="false"
                                            :searchable="true"
                                            noOptionsText="Aucun article"
                                            noResultsText="Aucun article"
                                            @close="checkArticle" />

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
                                            :resolve-on-load="false"
                                            :delay="500"
                                            :searchable="true"
                                            :object="true"
                                            :options="async function (query: string) {
                                                return await fetchArticles(query)
                                            }"
                                            @select="handleSelect(i-1)"
                                        />

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
                    <SaveBtn v-if="nouveau" :loading="Devis.creating.value">Enregistrer</SaveBtn>
                    <SaveBtn v-else :loading="Devis.updating.value">Mettre a jour</SaveBtn>
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
import { computed, onMounted, onBeforeMount, ref, defineComponent, Ref } from 'vue';
import { montantHT, montantTTC } from '../../functions/functions';
import ArticleFormComponent from '../article/ArticleFormComponent.vue';
import NouveauClientFormComponent from '../client/ClientFormComponent.vue';
import NouveauFournisseurComponent from '../fournisseur/FournisseurFormComponent.vue';
import axiosClient from '../../axios';

const Article = useCRUD('/article')
const Client = useCRUD('/client'); // Recuperer le service de CRUD de client
const Devis = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Devis
const Fournisseur = useCRUD('/fournisseur'); // Recuperer le service de CRUD de fournisseur

type Form = {
    numero: string|null,
    type: number,
    date: string|null,
    validite: number,
    fournisseur: number|null,
    client: number|null,
    appro: boolean,
    articles: Array<any>,
    file?: FileList|null,
}

export default defineComponent({
    name: "DevisFormComponent",
    components: {
        Input, SaveBtn, Datepicker, MultiSelect, Skeletor, ArticleFormComponent, NouveauFournisseurComponent, NouveauClientFormComponent, FileInput,
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
            defaulr: true,
        },

        hasAttachment: {
            type: Boolean,
            required: false,
            default: false,
        }
    },

    setup(props) {
        const test = ref(null);

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

        const fetchArticles = async (query: string): Promise<any> => {
            return await Article.findBy('designation', query)
        }

        const handleSelect = (index: number) => {
            const object = form.value.articles[index].object
            form.value.articles[index].id = object.id
            form.value.articles[index].pu = object.pu
            calculerMontant(index)
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
                file: null,
            }

            nombreArticle.value = 1
            generateArticleArray(nombreArticle.value)
        }

        const check = (e: { modelValue: null; }) => {
            if (e.modelValue !== null) Devis.errors.value.fournisseur = null
        }

        const checkArticle = (e: { modelValue: string; }) => {
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

        const checkDate = (date: Date) => {
            form.value.date = date.toLocaleDateString()
            Devis.errors.value.date = null
        }

        const generateArticleArrayFromArticles = (articles: any[]): void => {
            articles.forEach((article: any) => addItem(false, article))
        }

        const generateArticleArray = (nombreArticle: number): void => {
            for (let i = 0; i < nombreArticle; i++) {
                addItem(false)
            }
        }

        const removeItem = (index: number): void => {
            form.value.articles.splice(index, 1)
            nombreArticle.value--
        }

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
                    tva: 20.00,
                    montant_ht: null,
                    montant_ttc: null,
                    object: null,
                })
            } else {
                form.value.articles.push({
                    id: article === null ? null : article.id,
                    quantite: article === null ? 1 : article.pivot.quantite,
                    pu: article === null ? null : article.pivot.pu,
                    tva: article === null ? 20 : article.pivot.tva,
                    montant_ht: article === null ? null : montantHT(article),
                    montant_ttc: article === null ? null : montantTTC(article),
                    object: null,
                })
            }

            if (increment === true) nombreArticle.value++
        }


        /**
         * Permet de calculer le montant pour une ligne de l'article
         *
         * @param {Number}  index   Index de la ligne darticle
         */
        const calculerMontant = (index: number) => {
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
        const setDevisKey = async (): Promise<any> => {
            await Devis.getKey(1, form.value.appro)
            form.value.numero = Devis.key.value
        }

        const hasError = computed(() => {
            if (Devis.errors.value.fournisseur && Devis.errors.value.fournisseur.length > 0 && form.value.appro === true) return true
            if (Devis.errors.value.client && Devis.errors.value.client.length > 0 && form.value.appro === false) return true
            return false
        })

        const dateState: Ref<false|null> = computed(() => {
            if (Devis.errors.value.date && Devis.errors.value.date.length > 0) return false
            return null
        })

        onMounted(async (): Promise<any> => {
            Article.all();
            Fournisseur.all();
            Client.all();
            if (props.nouveau === true) setDevisKey();
        })

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

                generateArticleArrayFromArticles(props.devis.articles)
            } else {
                form.value.appro = props.appro;
                generateArticleArray(nombreArticle.value);
            }
        })

        const handleChange = (files: FileList): void => {
            form.value.file = files;
        }

        return {
            Devis, Fournisseur, Client, Article, Flash, creerArticle, creationArticle, articleCree, creationFrs, frsCree, creerFrs,
            form, nombreArticle, checkArticle, setDevisKey, hasError, dateState, calculerMontant, addItem, removeItem,
            generateArticleArray, generateArticleArrayFromArticles, checkDate, check, save, clientCree, creerClient, creationClient,
            handleChange, test, fetchArticles, handleSelect,
        }
    },

});

</script>
