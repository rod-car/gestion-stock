<template>
    <div class="row">
        <div class="col-xl-12">

        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Table from '../../components/html/Table.vue';

export default defineComponent({
    props: {
        articles: {
            type: Array<any>,
            required: true,
        }
    },

    setup() {
        const columns = { reference: 'Réference', designation: 'Désignation', unite: 'Unité', 'entree - sortie': 'Quantité', 'fullArticle.pivot.pu': 'PU' };

        return {
            columns,
        }
    },

    components: {
        Table,
    },

});
</script>

