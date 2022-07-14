<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Fiche commande client</h5>

            <div class="d-flex justify-content-between">
                <router-link to="/commande/client/nouveau" class="btn btn-secondary me-2"><i class="fa fa-plus me-2"></i>Nouvelle</router-link>
                <router-link v-if="!Commande.loading.value && Commande.entity.value.id" :to="{ name: 'commande.client.modifier', params: { id: Commande.entity.value.id }}" class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/commande/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-5">
                <div v-if="!Commande.loading.value" class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
                    <h5 class="mb-3">Mon entreprise</h5>
                    <h6>Tanambao 5</h6>
                    <h6>Toamasina I</h6>
                    <h6>Telephone: +261 34 123 45</h6>
                </div>
                <div v-else class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
                    <Skeletor class="mb-2" height="30" width="55%" style="border-radius: 3px" />
                    <Skeletor class="mb-2" height="20" width="50%" style="border-radius: 3px" />
                    <Skeletor class="mb-2" height="20" width="60%" style="border-radius: 3px" />
                    <Skeletor height="20" width="75%" style="border-radius: 3px" />
                </div>
                <div class="col-xl-6 d-flex align-items-center justify-content-end">
                    <h4>COMMANDE</h4>
                </div>
            </div>

            <div v-if="!Commande.loading.value && Commande.entity.value.cl" class="row mb-5">
                <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
                    <h6>Client: {{ Commande.entity.value.cl.nom }}</h6>
                    <h6>{{ Commande.entity.value.cl.adresse }}</h6>
                    <h6>Téléphone: {{ Commande.entity.value.cl.contact }}</h6>
                </div>
                <div class="col-xl-6 d-flex align-items-end flex-column justify-content-center">
                    <h6>Date: {{ formatDate(Commande.entity.value.date, false, long = false) }}</h6>
                    <h6>Référence: {{ Commande.entity.value.numero }}</h6>
                    <h6>Adresse de livraison: {{ Commande.entity.value.adresse_livraison }}</h6>
                </div>
            </div>

            <div v-else class="row mb-5">
                <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
                    <Skeletor class="mb-2" height="20" width="50%" style="border-radius: 3px" />
                    <Skeletor class="mb-2" height="20" width="70%" style="border-radius: 3px" />
                    <Skeletor height="20" width="65%" style="border-radius: 3px" />
                </div>
                <div class="col-xl-6 d-flex align-items-end flex-column justify-content-center">
                    <Skeletor class="mb-2" height="20" width="50%" style="border-radius: 3px" />
                    <Skeletor class="mb-2" height="20" width="70%" style="border-radius: 3px" />
                    <Skeletor height="20" width="65%" style="border-radius: 3px" />
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-warning">
                            <tr>
                                <th>Designation</th>
                                <th>Quantité</th>
                                <th>Unité</th>
                                <th class="text-end">Prix unitaire HT</th>
                                <th>% TVA</th>
                                <th class="text-end">Montant TVA</th>
                                <th class="text-end">Montant TTC</th>
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
                            <tr v-for="article in Commande.entity.value.articles" :key="article.id">
                                <td>{{ article.designation }}</td>
                                <td>{{ article.pivot.quantite }}</td>
                                <td>{{ article.unite }}</td>
                                <td class="text-end">{{ format(article.pivot.pu) }} Ar</td>
                                <td>{{ article.pivot.tva }} %</td>
                                <td class="text-end">{{ format(montantTVA(article)) }}</td>
                                <td class="text-end">{{ format(montantTTC(article)) }}</td>
                            </tr>
                        </tbody>
                        <tfoot v-if="!Commande.loading.value && Commande.entity.value.articles">
                            <tr class="border-0">
                                <td colspan="7">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-end">TOTAL HT</td>
                                <td class="text-end">{{ format(totalHT(Commande.entity.value.articles)) }}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-end">TOTAL TVA</td>
                                <td class="text-end">{{ format(totalTVA(Commande.entity.value.articles)) }}</td>
                            </tr>
                            <tr class="text-warning">
                                <td colspan="6" class="text-end">TOTAL TTC</td>
                                <td class="text-end">{{ format(totalTTC(Commande.entity.value.articles)) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { onMounted } from 'vue';
import { Skeletor } from 'vue-skeletor';
import { formatDate, totalHT, totalTVA, totalTTC, montantTVA, montantTTC, format } from '../../../functions/functions';
import router from '../../../router/router';
import useCRUD from '../../../services/CRUDServices';

const Commande = useCRUD('/commandes');

export default {
    setup() {

        onMounted(async () => {
            const id = parseInt(router.currentRoute.value.params.id);
            await Commande.getEntity(id)
        })

        return {
            Commande, formatDate, totalHT, totalTVA, totalTTC, montantTVA, montantTTC, format,
        }
    },

    components: {
        Skeletor,
    },

}
</script>
