<template>
    <div class="row mb-5">
        <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h5 class="mb-3">{{ infoEntreprise.generale.nom }}</h5>

            <h6>Telephone: {{ infoEntreprise.generale.contact }}</h6>
        </div>
        <div class="col-xl-6 d-flex align-items-center justify-content-end">
            <h4>BON DE LIVRAISON</h4>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h6>Fournisseur: {{ bonLivraison.get_commande.cl.nom }}</h6>
            <h6>{{ bonLivraison.get_commande.cl.adresse }}</h6>
            <h6>Téléphone: {{ bonLivraison.get_commande.cl.contact }}</h6>
        </div>
        <div class="col-xl-6 d-flex align-items-end flex-column justify-content-center">
            <h6>Date: {{ bonLivraison.date }}</h6>
            <h6>Référence: {{ bonLivraison.numero }}</h6>
            <h6>Adresse de livraison: {{ bonLivraison.adresse_livraison }}</h6>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h6>Mode de livraison: {{ modeLivraison(bonLivraison.mode_livraison) }}</h6>
            <h6>A la charge du: {{ chargeLivraison(bonLivraison.a_la_charge_de) }}</h6>
            <h6>Coût: {{ format(parseFloat(bonLivraison.cout)) }}</h6>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <table class="table table-bordered table-striped">
                <thead class="bg-warning">
                    <tr>
                        <th>Designation</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="article in bonLivraison.articles" :key="article.id">
                        <td>{{ article.designation }}</td>
                        <td>{{ article.pivot.quantite }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>

<script lang="ts">
import store from '../../store';

import { formatDate, format, modeLivraison, chargeLivraison } from '../../functions/functions';

export default {
    props: {
        bonLivraison: {
            type: Object,
            required: true,
        },
    },

    setup() {
        const infoEntreprise = store.state.infoEntreprise

        return {
            formatDate, format, modeLivraison, chargeLivraison, infoEntreprise
        }
    },

}
</script>
