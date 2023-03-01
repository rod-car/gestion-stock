<template>
    <div class="row mb-5">
        <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h5 class="mb-3">{{ infoEntreprise.generale.nom }}</h5>

            <h6>Telephone: {{ infoEntreprise.generale.contact }}</h6>
        </div>
        <div class="col-xl-6 d-flex align-items-center justify-content-end">
            <h4>BON DE RECEPTION</h4>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h6>Fournisseur: {{ bonReception.get_commande.frs.nom }}</h6>
            <h6>{{ bonReception.get_commande.frs.adresse }}</h6>
            <h6>Téléphone: {{ bonReception.get_commande.frs.contact }}</h6>
        </div>
        <div class="col-xl-6 d-flex align-items-end flex-column justify-content-center">
            <h6>Date: {{ bonReception.date }}</h6>
            <h6>Référence: {{ bonReception.numero }}</h6>
            <h6>Adresse de livraison: {{ bonReception.adresse_livraison }}</h6>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <h6>Mode de livraison: {{ modeLivraison(bonReception.mode_livraison) }}</h6>
            <h6>A la charge du: {{ chargeLivraison(bonReception.a_la_charge_de) }}</h6>
            <h6>Coût: {{ format(parseFloat(bonReception.cout === null ? 0 : bonReception.cout)) }}</h6>
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
                    <tr v-for="article in bonReception.articles" :key="article.id">
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
        bonReception: {
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
