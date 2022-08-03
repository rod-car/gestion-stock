<template>
    <table class="table table-striped table-hover">
        <thead class="text-white bg-secondary">
            <tr>
                <th v-for="i in column" :key="i"><Skeletor height="30" width="100%" style="border-radius: 3px" /></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="i in row" :key="i">
                <td v-for="j in column" :key="j"><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
            </tr>
        </tbody>
    </table>
</template>

<script lang="ts">

import { defineComponent } from 'vue';
import { Skeletor } from 'vue-skeletor';

export default defineComponent({
    props: {
        row: {
            type: Number,
            required: false,
            default: 5,
        },
        column: {
            type: Number,
            required: false,
            default: 4,
        }
    },

    components: { Skeletor }
});

</script>
