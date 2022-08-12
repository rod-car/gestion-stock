<template>
    <table class="table table-striped">
        <thead class="bg-secondary text-white">
            <tr>
                <th v-for="i in 7" :key="i" class="p-3">
                    <Skeletor height="30" width="100%" style="border-radius: 3px" />
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="i in 5" :key="i">
                <td v-for="j in 7" :key="j"><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
            </tr>
        </tbody>
    </table>
</template>

<script lang="ts">

import { Skeletor } from 'vue-skeletor'

export default {

    components: {
        Skeletor,
    }

}

</script>
