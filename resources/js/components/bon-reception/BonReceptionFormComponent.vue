<template>
    <form action="" method="post">
        <div class="row mb-5">
            <div class="col-xl-12">
                <h6 class="text-uppercase text-primary mb-4">Information de la bon de reception</h6>
                <div class="row">
                    <div class="col-xl-6 mb-3" :class="Reception.loading.value === true ? 'd-flex align-items-end' : ''">
                        <Input v-if="Reception.loading.value === false" v-model="form.numero" :error="Reception.errors.value.numero" disabled>Numéro de bon de reception</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>

                    <div class="col-xl-6 mb-3">
                        <Input v-model="commande.frs.nom" :required="true" disabled>Fournisseur</Input>
                    </div>

                    <div class="col-xl-6 mb-3">
                        <label for="date" class="form-label">Date <span class="text-danger">(*)</span></label>
                        <Datepicker locale="fr-MG" v-model="form.date" selectText="Valider"
                            :enableTimePicker="false"
                            cancelText="Annuler" placeholder="Selectionner la date" arrowNavigation
                            @update:modelValue="checkDate"></Datepicker>

                        <div class="text-danger mt-1" v-if="dateState === false">
                            {{ Reception.errors.value.date[0] }}
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <Input v-model="form.adresse_livraison" :error="Reception.errors.value.adresse_livraison" required>Adresse de livraison</Input>
                    </div>

                    <div class="col-xl-6 mb-3">
                        <Input v-model="form.livreur" :error="Reception.errors.value.livreur">Livreur</Input>
                    </div>
                    <div class="col-xl-6 mb-3">
                        <Input v-model="form.contact" :error="Reception.errors.value.contact">Contact du livreur</Input>
                    </div>
                </div>
            </div>
        </div>

        <pre>
            {{ form.articles }}
        </pre>

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
                                    <th class="w-75">Nom de l'article</th>
                                    <th>Quantité</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="i in nombreArticle" :key="i">
                                    <td>
                                        <Input v-model="form.articles[i - 1].designation" disabled />
                                    </td>
                                    <td>
                                        <input type="number" @input="checkQuantite(i-1)" v-model="form.articles[i - 1].quantite" class="form-control">
                                        <span class="text-danger" v-if="Reception.errors.value[`articles.${i - 1}.quantite`]">
                                            {{ Reception.errors.value[`articles.${i - 1}.quantite`][0] }}
                                        </span>
                                    </td>
                                    <td v-if="nombreArticle > 1"><button type="button" @click.prevent="removeItem(i - 1)" class="btn btn-danger"><i class="fa fa-minus"></i></button></td>
                                    <td class="text-center" v-else><button type="button" class="btn btn-secondary"><i class="fa fa-ban"></i></button></td>
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
                    <SaveBtn v-if="nouveau" @click.prevent="save" :loading="Reception.creating.value" :disabled="!valide">Enregistrer</SaveBtn>
                    <SaveBtn v-else @click.prevent="save" :loading="Reception.updating.value" :disabled="!valide">Mettre a jour</SaveBtn>
                </div>
            </div>
        </div>
    </form>
</template>

<script lang="ts">
import Input from '../html/Input.vue';
import SaveBtn from '../html/SaveBtn.vue';
import useCRUD from '../../services/CRUDServices';
import Datepicker from '@vuepic/vue-datepicker';
import MultiSelect from '@vueform/multiselect';
import Flash from '../../functions/Flash';
import { Skeletor } from 'vue-skeletor';
import Config from '../../config/config';
import { computed, onMounted, onBeforeMount, ref, defineComponent, Ref } from 'vue';

const Reception = useCRUD('/bon-receptions'); // Contient tous les fonctions CRUD pour le Reception
const { getKey, key } = useCRUD('/commandes');

type Form = {
    numero: string|null,
    date: Date|null,
    adresse_livraison: string|null
    validite?: number,
    articles: Array<any>,
    commande: number, // Numero de la commande qui a generer le bon de reception
    livreur: string|null,
    contact: string|null,
}

export default defineComponent({
    name: "ReceptionFormComponent",
    components: {
        Input, SaveBtn, Datepicker, MultiSelect, Skeletor,
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
         * Reception a modifier dans le cas d'une modification
         */
        reception: {
            type: Object,
            required: false,
        },

        /**
         * Provenance du bon de reception
         */
        commande: {
            type: Object,
            required: true,
        },
    },

    setup(props) {
        const form = ref({
            numero: null,
            date: null,
            adresse_livraison: null,
            articles: [],
            commande: props.commande.id,
            livreur: null,
            contact: null,
        } as Form);

        const valide: Ref<boolean> = ref(true);

        const nombreArticle = ref(1);
        const originalArticles: Ref<Array<any>> = ref(props.commande.articles);

        const save = async () => {
            if (props.nouveau === true) {
                await Reception.create(form.value)
                /*if (Reception.success.value !== null) {
                    router.replace({ query: {} })
                    resetForm()
                    setReceptionKey()
                }*/
            } else if (props.commande) {
                await Reception.update(props.commande.id, form.value)
            }

            window.scrollTo({ top: 0, behavior: 'smooth' })
            Reception.success.value = null
        }

        const checkDate = () => {
            Reception.errors.value.date = null
        }

        const generateArticleArrayFromArticles = (articles: any[]) => {
            articles.forEach((article: null | undefined) => addItem(article))
        }

        const removeItem = (index: number) => {
            form.value.articles.splice(index, 1);
            originalArticles.value.splice(index, 1);
            nombreArticle.value--
        }

        const addItem = (article: any) => {
            if (nombreArticle.value > Config.commande.MAX_ARTICLE) {
                Flash('error', "Message d'erreur", `Nombre d'article maximum atteint. Limite ${Config.commande.MAX_ARTICLE}`)
                return
            }

            form.value.articles.push({
                id: article.id,
                quantite: article.pivot.quantite,
                designation: article.designation,
                valide: true,
            })
        }

        /**
         * Recuperer la nouvelle numéro du dévis et le mettre dans la formulaire
         *
         * @return  {Promise}
         */
        const setReceptionKey = async (): Promise<any> => {
            await getKey(3) // Clé de bon de reception
            form.value.numero = key.value
        }

        const dateState = computed(() => {
            if (Reception.errors.value.date && Reception.errors.value.date.length > 0) return false
            return null
        })

        const checkQuantite = (index: number): void => {
            valide.value = true;

            const quantite: number = form.value.articles[index].quantite;
            const max: number = originalArticles.value[index].pivot.quantite;

            if (quantite > max) {
                Flash('error', "Message d'erreur", "La quantité ne doit pas depasser la quantté totale: " + max.toString());
                form.value.articles[index].valide = false;
            } else if (quantite <= max && quantite > 0) {
                form.value.articles[index].valide = true;
            } else {
                Flash('error', "Message d'erreur", "La quantité ne doit pas être 0");
                form.value.articles[index].valide = false;
            }

            form.value.articles.map(article => {
                valide.value = valide.value && article.valide;
            })
        }

        onMounted(() => {
            if (props.nouveau === true) setReceptionKey();
        })

        onBeforeMount(() => {
            nombreArticle.value = props.commande.articles.length
            form.value.date = props.commande.date
            form.value.adresse_livraison = props.commande.adresse_livraison
            form.value.commande = props.commande.id

            generateArticleArrayFromArticles(props.commande.articles)
        })

        return {
            Reception, Flash, form, nombreArticle, setReceptionKey, getKey, key, checkQuantite,
            dateState, addItem, removeItem, generateArticleArrayFromArticles, checkDate, save, valide,
        }
    },

})

</script>
