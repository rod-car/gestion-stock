<template>
    <div class="row mb-5">
        <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h5 class="mb-3">{{ infoEntreprise.generale.nom }}</h5>
            <h6>Tanambao 5</h6>
            <h6>Toamasina I</h6>
            <h6>Telephone: {{ infoEntreprise.generale.contact }}</h6>
        </div>
        <div class="col-xl-6 d-flex align-items-center justify-content-end">
            <h4>FACTURE</h4>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h6>Client: {{ facture.get_commande.cl.nom }}</h6>
            <h6>{{ facture.get_commande.cl.adresse }}</h6>
            <h6>Téléphone: {{ facture.get_commande.cl.contact }}</h6>
        </div>
        <div class="col-xl-6 d-flex align-items-end flex-column justify-content-center">
            <h6>Référence: {{ facture.numero_facture }}</h6>
            <h6>Date de facturation: {{ formatDate(facture.date_facturation, false, false) }}</h6>
            <h6>Date de vente: {{ formatDate(facture.date_vente, false, false) }}</h6>
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
                        <th v-if="(assujeti === true || facture.get_commande.tva > 0)">% TVA</th>
                        <th v-if="(assujeti === true || facture.get_commande.tva > 0)" class="text-end">Total TVA</th>
                        <th class="text-end">Total TTC</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="article in facture.get_commande.articles" :key="article.id">
                        <td>{{ article.designation }}</td>
                        <td>{{ article.pivot.quantite }}</td>
                        <td>{{ article.unite }}</td>
                        <td class="text-end">{{ format(article.pivot.pu) }}</td>
                        <td v-if="(assujeti === true || facture.get_commande.tva > 0)">{{ article.pivot.tva }}</td>
                        <td v-if="(assujeti === true || facture.get_commande.tva > 0)" class="text-end">{{ format(montantTVA(article)) }}</td>
                        <td class="text-end">{{ format(montantTTC(article)) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="border-0">
                        <td :colspan="(assujeti === true || facture.get_commande.tva > 0) ? 7 : 5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td :colspan="(assujeti === true || facture.get_commande.tva > 0) ? 6 : 4" class="text-end">TOTAL HT</td>
                        <td class="text-end">{{ format(totalHT(facture.get_commande.articles)) }}</td>
                    </tr>
                    <tr v-if="(assujeti === true || facture.get_commande.tva > 0)">
                        <td colspan="6" class="text-end">TOTAL TVA</td>
                        <td class="text-end">{{ format(totalTVA(facture.get_commande.articles)) }}</td>
                    </tr>
                    <tr class="text-warning">
                        <td :colspan="(assujeti === true || facture.get_commande.tva > 0) ? 6 : 4" class="text-end">TOTAL TTC</td>
                        <td class="text-end">{{ format(totalTTC(facture.get_commande.articles)) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</template>

<script lang="ts">
import { computed, defineComponent } from 'vue';
import store from "../../store";
import { format, formatDate, totalHT, montantTTC, montantTVA, totalTVA, totalTTC } from '../../functions/functions'

export default defineComponent({
    props: {
        facture: {
            type: Object,
            required: true,
        },
    },

    setup() {
        const infoEntreprise = store.state.infoEntreprise

        const assujeti = computed((): boolean => {
            return infoEntreprise.generale.assujeti
        })

        return {
            formatDate, format, montantTVA, totalHT, montantTTC, totalTVA, totalTTC, assujeti, infoEntreprise,
        }
    },

})
</script>
