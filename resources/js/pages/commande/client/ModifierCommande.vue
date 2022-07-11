<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Modifier le commande client N° {{ Commande.entity.value.numero }}</h5>
                    <router-link to="/commande/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des commande client</router-link>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="post">
                    <div class="row mb-5">
                        <div class="col-xl-12">
                            <h6 class="text-uppercase text-primary mb-4">Information du commande</h6>
                            <div class="row">
                                <div class="col-xl-6 mb-3" :class="Commande.loading.value === true ? 'd-flex align-items-end' : ''">
                                    <label v-if="!Commande.loading.value" class="form-label">Numéro de la commande</label>
                                    <label v-if="!Commande.loading.value" class="form-control">{{ form.numero }}</label>
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
                                        <tbody v-if="Commande.loading.value">
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
                                <SaveBtn @click.prevent="save()" :loading="Commande.updating.value">Enregistrer</SaveBtn>
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
import { onMounted, computed, onBeforeMount, ref } from 'vue';
import Config from '../../../config/config';
import router from '../../../router/router';

const Commande = useCRUD('/commandes'); // Contient tous les fonctions CRUD pour le Commande
const Client = useCRUD('/client'); // Recuperer le service de CRUD de client
const Article = useCRUD('/article')

export default {
    components: {
        Input, SaveBtn, Alert, Datepicker, MultiSelect, Skeletor
    },
    setup() {
        const form = ref({
            numero: null,
            type: 1,
            date: null,
            validite: null,
            client: null,
            adresse_livraison: null,
            articles: [],
        })

        const nombre_article = ref(1)

        const save = async () => {
            const id = Commande.entity.value.id
            await Commande.updateEntity(id, form.value)
            window.scrollTo({ top: 0, behavior: 'smooth' })
        }

        const check = (e) => {
            if (e.modelValue !== null) Commande.errors.value.client = null
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
            Commande.errors.value.date = null
        }

        const generateArticleArray = (articles) => {
            articles.forEach(article => addItem(article, false))
        }

        const removeItem = (index) => {
            form.value.articles.splice(index, 1)
            nombre_article.value--
        }

        const addItem = (article = null, increment = true) => {
            form.value.articles.push({
                id: article === null ? null : article.id,
                quantite: article === null ? 1 : article.pivot.quantite,
                pu: article === null ? null : article.pivot.pu,
                tva: article === null ? 20 : article.pivot.tva,
                montant_ht: article === null ? null : article.pivot.quantite * article.pivot.pu,
                montant_ttc: article === null ? null : (article.pivot.quantite * article.pivot.pu) * (1 + (article.pivot.tva / 100)),
            })

            if (increment === true) nombre_article.value++
        }

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

        const hasError = computed(() => {
            if (Commande.errors.value.client && Commande.errors.value.client.length > 0) return true
            return false
        })

        const dateState = computed(() => {
            if (Commande.errors.value.date && Commande.errors.value.date.length > 0) return false
            return null
        })

        onMounted(() => {
            Article.getEntities()
            Client.getEntities()
        })

        onBeforeMount(async () => {
            const id = router.currentRoute.value.params.id

            await Commande.getEntity(id)
            generateArticleArray(Commande.entity.value.articles)
            nombre_article.value = Commande.entity.value.articles.length

            form.value.numero = Commande.entity.value.numero
            form.value.date = Commande.entity.value.date
            form.value.validite = Commande.entity.value.validite
            form.value.client = Commande.entity.value.client
            form.value.type = 2
            form.value.adresse_livraison = Commande.entity.value.adresse_livraison
        })

        return {
            form, nombre_article, Commande, Client, Article, Flash, Config,
            addItem, removeItem, calculerMontant, check, checkDate, checkArticle, save, hasError, dateState,
        }
    }
}
</script>
