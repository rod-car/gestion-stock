<template>
    <table class="table table-striped table-hover">
        <thead class="text-uppercase">
            <tr>
                <th v-for="i in 4" :key="i"><Skeletor height="30" width="100%" style="border-radius: 3px" /></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="i in 5" :key="i">
                <td v-for="j in 4" :key="j"><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
            </tr>
        </tbody>
    </table>
</template>

<script lang="ts">

import { defineComponent } from 'vue';
import { Skeletor } from 'vue-skeletor';

export default defineComponent({
    components: { Skeletor }
});

</script>
