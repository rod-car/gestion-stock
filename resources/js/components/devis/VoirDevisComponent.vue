<template>
    <div class="row mb-5">
        <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h5 class="mb-3">Mon entreprise</h5>
            <h6>Tanambao 5</h6>
            <h6>Toamasina I</h6>
            <h6>Telephone: +261 34 123 45</h6>
        </div>
        <div class="col-xl-6 d-flex align-items-center justify-content-end">
            <h4>DEVIS</h4>
        </div>
    </div>

    <div class="row mb-5">
        <div v-if="devis.cl" class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h6>Client: {{ devis.cl.nom }}</h6>
            <h6>{{ devis.cl.adresse }}</h6>
            <h6>Téléphone: {{ devis.cl.contact }}</h6>
        </div>
        <div v-if="devis.frs" class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h6>Fournisseur: {{ devis.frs.nom }}</h6>
            <h6>{{ devis.frs.adresse }}</h6>
            <h6>Téléphone: {{ devis.frs.contact }}</h6>
        </div>
        <div class="col-xl-6 d-flex align-items-end flex-column justify-content-center">
            <h6>Date: {{ formatDate(devis.date, false, long = false) }}</h6>
            <h6>Référence: {{ devis.numero }}</h6>
            <h6>Date de validité: {{ devis.validite }} jours</h6>
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
                        <th class="text-end">Total TVA</th>
                        <th class="text-end">Total TTC</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="article in devis.articles" :key="article.id">
                        <td>{{ article.designation }}</td>
                        <td>{{ article.pivot.quantite }}</td>
                        <td>{{ article.unite }}</td>
                        <td class="text-end">{{ format(article.pivot.pu) }} Ar</td>
                        <td>{{ article.pivot.tva }} %</td>
                        <td class="text-end">{{ format(montantTVA(article)) }}</td>
                        <td class="text-end">{{ format(montantTTC(article)) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="border-0">
                        <td colspan="7">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end">TOTAL HT</td>
                        <td class="text-end">{{ format(totalHT(devis.articles)) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end">TOTAL TVA</td>
                        <td class="text-end">{{ format(totalTVA(devis.articles)) }}</td>
                    </tr>
                    <tr class="text-warning">
                        <td colspan="6" class="text-end">TOTAL TTC</td>
                        <td class="text-end">{{ format(totalTTC(devis.articles)) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</template>

<script>

import { formatDate, totalHT, totalTVA, totalTTC, format, montantTVA, montantTTC } from '../../functions/functions.js';

export default {
    props: {
        devis: {
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
        return {
            formatDate, totalHT, totalTVA, totalTTC, format, montantTVA, montantTTC,
        }
    },

}
</script>
