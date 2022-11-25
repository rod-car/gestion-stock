<template>
<div class="row mb-5">
    <div class="col-xl-12">
        <h6 class="text-uppercase text-primary mb-4">Information du transfert d'article</h6>
        <div class="row">
            <div class="col-xl-6 mb-3" :class="Transfert.loading.value === true ? 'd-flex align-items-end' : ''">
                <Input v-if="Transfert.loading.value === false" v-model="form.numero" :error="Transfert.errors.value.numero"
                    disabled>Numéro de bon de reception</Input>
                <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
            </div>
            <div class="col-xl-6 mb-3">
                <label for="date" class="form-label">Date <span class="text-danger">(*)</span></label>
                <Datepicker locale="fr-MG" v-model="form.date" selectText="Valider" :enableTimePicker="false" cancelText="Annuler"
                    placeholder="Selectionner la date" arrowNavigation @update:modelValue="checkDate" utc />

                <div class="text-danger mt-1" v-if="dateState === false">
                    {{ Transfert.errors.value.date[0] }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <label for="depotOrigin" class="form-label">Entrepot ou point de vente d'origine</label>
                <MultiSelect v-if="!DepotOrigin.loading.value" :class="Transfert.errors.value.depotOrigin != undefined ? 'border-danger' : ''"
                    :object="false" :options="DepotOrigin.entities.value" :searchable="true" :multiple="false"
                    v-model="form.depotOrigin" noOptionsText="Aucune donées" noResultsText="Aucune donées" label="nom" valueProp="id"
                    @close="check" />
                <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                <div class="text-danger mt-1" v-if="Transfert.errors.value.depotOrigin != undefined">
                    {{ Transfert.errors.value.depotOrigin[0] }}
                </div>

            </div>
            <div class="col-xl-6">
                <label for="depotDestiny" class="form-label">Entrepot ou point de vente de destination</label>
                <MultiSelect v-if="!DepotDestiny.loading.value" :class="Transfert.errors.value.depotDestiny != undefined ? 'border-danger' : ''" :object="false"
                    :options="DepotDestiny.entities.value" :searchable="true" :multiple="false" v-model="form.depotDestiny"
                    noOptionsText="Aucune donées" noResultsText="Aucune donées" label="nom" valueProp="id" @close="check" />
                <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                <div class="text-danger mt-1" v-if="Transfert.errors.value.depotDestiny != undefined">
                    {{ Transfert.errors.value.depotDestiny[0] }}
                </div>
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
                    <thead>
                        <tr>
                            <th class="w-50">Nom de l'article</th>
                            <th>Quantité</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in nombreArticle" :key="i">
                            <td>
                                <MultiSelect v-if="appro === true" label="designation" valueProp="id"
                                    v-model="form.articles[i - 1].id" :options="Article.entities.value"
                                    :closeOnSelect="true" :clearOnSelect="false" :searchable="true"
                                    noOptionsText="Aucun article" noResultsText="Aucun article" @close="checkArticle" />

                                <MultiSelect v-else v-model="form.articles[i - 1].object"
                                    placeholder="Rechercher un article" noResultsText="Aucun article trouvé"
                                    noOptionsText="Aucun article trouvé" :closeOnSelect="true" :filter-results="true"
                                    :multiple="false" :min-chars="1" :resolve-on-load="resolveOnLoad" :delay="500"
                                    :searchable="true" :object="true" :options="async function (query: string) {
                                        return await fetchArticles(query)
                                    }"  />

                                <span class="text-danger" v-if="Transfert.errors.value[`articles.${i - 1}.id`]">
                                    {{ Transfert.errors.value[`articles.${i - 1}.id`][0] }}
                                </span>
                            </td>
                            <td>
                                <input type="number"
                                    v-model="form.articles[i - 1].quantite" class="form-control">
                                <span class="text-danger" v-if="Transfert.errors.value[`articles.${i - 1}.quantite`]">
                                    {{ Transfert.errors.value[`articles.${i - 1}.quantite`][0] }}
                                </span>
                            </td>

                            <td >
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <button type="button" v-if="i > 1" @click.prevent="removeItem(i - 1)"
                                            class="btn btn-danger"><i class="fa fa-minus"></i></button>
                                        <button type="button" v-else @click.prevent="addItem()" class="btn btn-success"><i
                                                class="fa fa-plus"></i>
                                            </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-xl-12">
        <div class="d-flex justify-content-end">
            <SaveBtn v-if="nouveau" :loading="Transfert.creating.value"
                :disabled="!appro && !form.depotOrigin && !form.depotDestiny" @click.prevent="save">Enregistrer
            </SaveBtn>
            <SaveBtn v-else :loading="Transfert.updating.value"
                :disabled="!appro && !form.depotOrigin && !form.depotDestiny">Mettre a jour</SaveBtn>
        </div>
    </div>
</div>
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
import { computed, onMounted, onBeforeMount, ref, defineComponent, Ref } from 'vue';

const Transfert = useCRUD('/transfert-article'); // Contient tous les fonctions CRUD pour les transferts
const Depot = useCRUD('/depot'); // Contient tous les fonctions CRUD pour le depôt
const Article = useCRUD('/article') // Recuperer le service de CRUD de l'article


type Form = {
    numero: string | null,
    date: Date | null,
    validite?: number,
    articles: Array<any>,
    livreur: string | null,
    depotOrigin: number | null,
    depotDestiny: number | null,
    appro: boolean,

}


export default defineComponent({
    props: {
        nouveau: {
            type: Boolean,
            required: false,
            default: true,
        },
        appro: {
            type: Boolean,
            required: true,
            default: true,
        },
        transfert: {
            type: Object,
            required: false,
            default: {}
        },

    },
    components: {
        Input, SaveBtn, Datepicker, MultiSelect, Skeletor,
    },
    setup(props) {
        let form = ref({
            numero: null,
            date: null,
            articles: [],
            livreur: null,
            depotOrigin: null,
            depotDestiny: null,
            appro: props.appro,

        } as Form);


        let DepotOrigin = { ...Depot }
        let DepotDestiny = { ...Depot }
        const nombreArticle = ref(1);

        /**
       * Permet de savoiir si on veut recharger les données pendant le chargement
       */
        const loaded = ref(false)


        /**
         * Permet de faire un recherche d'articles en fonction de query
         *
         * @param   {string|null}   query  Query de recherche
         *
         * @return  {Promise}
         */
        const fetchArticles = async (query: string | null): Promise<any> => {
            if (query === null) query = ""
            return await Article.findBy('designation', query)
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
                    object: null,
                })
            } else {
                form.value.articles.push({
                    id: article.id,
                    quantite: article.pivot.quantite,

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
            }

            if (increment === true) nombreArticle.value++
        }



        const check = (e: { modelValue: null; }) => {
            if (e.modelValue !== null) Depot.errors.value.categories = null
        }

        const checkDate = () => {
            Transfert.errors.value.date = null
        }

        const dateState = computed(() => {
            if (Transfert.errors.value.date && Transfert.errors.value.date.length > 0) return false
            return null
        })

        /**
        * Permet de determiner si on doit charger le select durant le chargement
        *
        * @return  {boolean}
        */
        const resolveOnLoad = computed((): boolean => {
            return (loaded.value === true )
        })

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

        onBeforeMount(() => {
            DepotOrigin.all(3)
            DepotDestiny.all(3)

            form.value.appro = props.appro;
            generateArticleArray(nombreArticle.value);
        })

        /**
         * Quant le composant est monté
         *
         * @return  {Promise}
         */
        onMounted(async (): Promise<any> => {
            Article.all();

            loaded.value = false // Rendre le depot non resolvable on load
        })

        /**
         * Permet de reinitialiser tous les champs
         *
         * @return  {void}
         */
        const resetForm = (): void => {
            form = ref({
                numero: null,
                date: null,
                articles: [],
                livreur: null,
                depotOrigin: null,
                depotDestiny: null,
                appro: props.appro,
            })

            nombreArticle.value = 1
            generateArticleArray(nombreArticle.value)
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

            if (form.value.articles) {
                formData.append('articles', JSON.stringify(form.value.articles))
            }

            if (props.nouveau === true) {
                await Transfert.create(formData)
                console.log(Transfert.errors.value)

                if (Transfert.success.value !== null) {
                    resetForm()
                    //setDevisKey()
                }

            } else if (props.transfert) {
                //await Transfert.update(props.devis.id, formData)
            }

            window.scrollTo({ top: 0, behavior: 'smooth' })
            Transfert.success.value = null
        }

        return {
            Transfert, form, appro: props.appro, check, checkDate, fetchArticles, removeItem, resolveOnLoad,
            DepotOrigin, DepotDestiny, nombreArticle, dateState, addItem, Article, save, checkArticle

        }
    }
})

</script>
