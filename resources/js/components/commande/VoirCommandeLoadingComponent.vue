<template>
    <div class="row mb-5">
        <div class="col-xl-6 d-flex align-items-start flex-column justify-content-center">
            <Skeletor class="mb-2" height="30" width="55%" style="border-radius: 3px" />
            <Skeletor class="mb-2" height="20" width="50%" style="border-radius: 3px" />
            <Skeletor class="mb-2" height="20" width="60%" style="border-radius: 3px" />
            <Skeletor height="20" width="75%" style="border-radius: 3px" />
        </div>
        <div class="col-xl-6 d-flex align-items-center justify-content-end">
            <h4>DEVIS</h4>
        </div>
    </div>

    <div class="row mb-5">
        <div v-for="i in 2" :key="i" class="col-xl-6 d-flex flex-column justify-content-center" :class="i === 2 ? 'align-items-end' : 'align-items-start'">
            <Skeletor class="mb-2" height="20" width="50%" style="border-radius: 3px" />
            <Skeletor class="mb-2" height="20" width="70%" style="border-radius: 3px" />
            <Skeletor height="20" width="65%" style="border-radius: 3px" />
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <table class="table table-bordered table-striped">
                <thead class="bg-warning">
                    <tr>
                        <th v-for="i in 7" :key="i"><Skeletor height="30" width="100%" style="border-radius: 3px" /></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="i in 5" :key="i">
                        <td v-for="j in 7" :key="j"><Skeletor height="30" width="100%" style="border-radius: 3px" /></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="border-0">
                        <td colspan="7">&nbsp;</td>
                    </tr>
                    <tr v-for="i in 3" :key="i">
                        <td colspan="6"><Skeletor height="30" width="20%" style="border-radius: 3px; float: right;" /></td>
                        <td class="text-end"><Skeletor height="30" width="100%" style="border-radius: 3px; float: right;" /></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</template>

<script>

import { Skeletor } from 'vue-skeletor'

export default {

    components: {
        Skeletor,
    }

}

</script>
