<template>
    <div class="row">
        <div class="d-flex justify-content-between p-0">
            <div class="shadow shadow-sm p-3 me-3 w-100">
                <Skeletor width="100%" height="30" style="border-radius: 5px" />
                <hr>
                <Skeletor width="75%" height="30" style="border-radius: 5px; margin-bottom: 1rem !important" />
                <Skeletor width="50%" height="30" style="border-radius: 5px; margin-bottom: 1rem !important"/>
            </div>

            <div class="shadow shadow-sm p-3 ms-3 w-100">
                <div class="mb-3">
                    <Skeletor width="100%" style="border-radius: 3px" height="30" />
                </div>

                <ul class="list-group">
                    <li v-for="i in 3" :key="i" class="list-group-item list-group-item-action">
                        <Skeletor width="100%" style="border-radius: 3px" height="30" />
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xl-12 shadow shadow-sm p-3 mt-5">
            <div class="mb-3">
                <Skeletor width="50%" style="border-radius: 3px" height="30" />
            </div>
            <Skeletor width="100%" style="border-radius: 3px" height="30" />

            <div class="d-flex justify-content-end mt-3">
                <Skeletor width="10%" style="border-radius: 3px" height="30" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">

import { defineComponent } from "vue";
import { Skeletor } from "vue-skeletor";

export default defineComponent({
    components: {
        Skeletor,
    },
});

</script>
