<template>
    <div class="row mb-5">
        <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h5 class="mb-3">Mon entreprise</h5>
            <h6>Tanambao 5</h6>
            <h6>Toamasina I</h6>
            <h6>Telephone: +261 34 123 45</h6>
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
            <h6>Date: {{ formatDate(bonLivraison.date, false, long = false) }}</h6>
            <h6>Référence: {{ bonLivraison.numero }}</h6>
            <h6>Adresse de livraison: {{ bonLivraison.adresse_livraison }}</h6>
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

import { formatDate, format } from '../../functions/functions';

export default {
    props: {
        bonLivraison: {
            type: Object,
            required: true,
        },
    },

    setup() {
        return {
            formatDate, format,
        }
    },

}
</script>
