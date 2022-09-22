<template>
    <div class="row mb-5">
        <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h5 class="mb-3">{{ infoEntreprise.generale.nom }}</h5>
            <h6>Tanambao 5</h6>
            <h6>Toamasina I</h6>
            <h6>Telephone: {{ infoEntreprise.generale.contact }}</h6>
        </div>
        <div class="col-xl-6 d-flex align-items-center justify-content-end">
            <h4>COMMANDE</h4>
        </div>
    </div>

    <div class="row mb-5">
        <div v-if="appro === false && commande.cl" class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h6>Client: {{ commande.cl.nom }}</h6>
            <h6>{{ commande.cl.adresse }}</h6>
            <h6>Téléphone: {{ commande.cl.contact }}</h6>
        </div>
        <div v-if="appro === true && commande.frs" class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h6>Fournisseur: {{ commande.frs.nom }}</h6>
            <h6>{{ commande.frs.adresse }}</h6>
            <h6>Téléphone: {{ commande.frs.contact }}</h6>
        </div>
        <div class="col-xl-6 d-flex align-items-end flex-column justify-content-center">
            <h6>Date: {{ formatDate(commande.date, false, false) }}</h6>
            <h6>Référence: {{ commande.numero }}</h6>
            <h6>Adresse de livraison: {{ commande.adresse_livraison }}</h6>
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
                        <th v-if="(assujeti || appro === true)">% TVA</th>
                        <th v-if="(assujeti || appro === true)" class="text-end">Total TVA</th>
                        <th class="text-end">Total TTC</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="article in commande.articles" :key="article.id">
                        <td>{{ article.designation }}</td>
                        <td>{{ article.pivot.quantite }}</td>
                        <td>{{ article.unite }}</td>
                        <td class="text-end">{{ format(article.pivot.pu) }}</td>
                        <td v-if="(assujeti || appro === true)">{{ article.pivot.tva }} %</td>
                        <td v-if="(assujeti || appro === true)" class="text-end">{{ format(montantTVA(article)) }}</td>
                        <td class="text-end">{{ format(montantTTC(article)) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="border-0">
                        <td :colspan="(assujeti || appro === true) ? 7 : 5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td :colspan="(assujeti || appro === true) ? 6 : 4" class="text-end">TOTAL HT</td>
                        <td class="text-end">{{ format(totalHT(commande.articles)) }}</td>
                    </tr>
                    <tr v-if="(assujeti || appro === true)">
                        <td colspan="6" class="text-end">TOTAL TVA</td>
                        <td class="text-end">{{ format(totalTVA(commande.articles)) }}</td>
                    </tr>
                    <tr class="text-warning">
                        <td :colspan="(assujeti || appro === true) ? 6 : 4" class="text-end">TOTAL TTC</td>
                        <td class="text-end">{{ format(totalTTC(commande.articles)) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</template>

<script lang="ts">

import store from '../../store';
import { defineComponent, computed } from 'vue';
import { formatDate, totalHT, totalTVA, totalTTC, format, montantTVA, montantTTC } from '../../functions/functions';

export default defineComponent({
    props: {
        commande: {
            type: Object,
            required: true,
        },
        appro: {
            type: Boolean,
            required: false,
            default: false,
        },
    },

    setup() {
        const infoEntreprise = store.state.infoEntreprise

        const assujeti = computed((): boolean => {
            return infoEntreprise.generale.assujeti
        })

        return {
            formatDate, totalHT, totalTVA, totalTTC, format, montantTVA, montantTTC, infoEntreprise, assujeti,
        }
    },

})
</script>
