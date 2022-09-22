<template>
    <div class="row mb-5">
        <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h5 class="mb-3">{{ infoEntreprise.generale.nom }}</h5>
            <h6>Tanambao 5</h6>
            <h6>Toamasina I</h6>
            <h6>Telephone: {{ infoEntreprise.generale.contact }}</h6>
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
            <h6>Date: {{ formatDate(devis.date, false, false) }}</h6>
            <h6>Référence: {{ devis.numero }}</h6>
            <h6>Date de validité: {{ devis.validite }} jours</h6>
        </div>
    </div>

    <div class="row mb-5">
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
                    <tr v-for="article in devis.articles" :key="article.id">
                        <td>{{ article.designation }}</td>
                        <td>{{ article.pivot.quantite }}</td>
                        <td>{{ article.unite }}</td>
                        <td class="text-end">{{ format(article.pivot.pu) }} Ar</td>
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
                        <td class="text-end">{{ format(totalHT(devis.articles)) }}</td>
                    </tr>
                    <tr v-if="(assujeti || appro === true)">
                        <td colspan="6" class="text-end">TOTAL TVA</td>
                        <td class="text-end">{{ format(totalTVA(devis.articles)) }}</td>
                    </tr>
                    <tr class="text-warning">
                        <td :colspan="(assujeti || appro === true) ? 6 : 4" class="text-end">TOTAL TTC</td>
                        <td class="text-end">{{ format(totalTTC(devis.articles)) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div v-if="piece !== null" class="row">
        <div class="col-xl-12">
            <h5 class="text-primary mb-3">Pièce jointe</h5>
            <iframe width="100%" height="800px" title="Pièce jointe" :src="piece + '#view=fitH'" frameborder="0"></iframe>
        </div>
    </div>
</template>

<script lang="ts">
import store from '../../store';
import { defineComponent, ref, computed } from 'vue';
import { formatDate, totalHT, totalTVA, totalTTC, format, montantTVA, montantTTC } from '../../functions/functions';

export default defineComponent({
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

    setup(props) {
        const piece = ref(props.devis.file_path === null ? null : `http://localhost:8000/storage/${props.devis.file_path}`)
        const infoEntreprise = store.state.infoEntreprise

        const assujeti = computed((): boolean => {
            return infoEntreprise.generale.assujeti
        })

        return {
            formatDate, totalHT, totalTVA, totalTTC, format, montantTVA, montantTTC, piece, infoEntreprise, assujeti,
        }
    },

});

</script>
