<template>
    <div class="row">
        <div class="col-xl-12 d-flex justify-content-between p-0">
            <div class="shadow shadow-sm p-3 w-100 me-3">
                <Skeletor width="100%" height="40" style="border-radius: 5px" />
                <hr>
                <Skeletor width="75%" height="30" style="border-radius: 5px; margin-bottom: 1rem !important" />
                <Skeletor width="50%" height="30" style="border-radius: 5px; margin-bottom: 1rem !important"/>
            </div>

            <div class="shadow shadow-sm p-3 w-100 ms-3">
                <div class="d-flex justify-content-between mb-3">
                    <Skeletor width="70%" style="border-radius: 3px" height="30" />
                    <Skeletor width="20%" style="border-radius: 3px" height="30" />
                </div>

                <ul class="list-group">
                    <li v-for="i in 3" :key="i" class="list-group-item list-group-item-action">
                        <Skeletor width="100%" style="border-radius: 3px" height="30" />
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xl-12 mt-5 p-0">
            <div class="d-flex justify-content-between p-0">
                <div class="me-2 shadow shadow-sm w-100 p-3">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <Skeletor width="70%" style="border-radius: 3px" height="30" />
                        <Skeletor width="20%" style="border-radius: 3px" height="30" />
                    </div>
                    <ul class="list-group">
                        <li v-for="i in 4" :key="i" class="list-group-item list-group-item-action">
                            <Skeletor width="100%" style="border-radius: 3px" height="30" />
                        </li>
                    </ul>
                </div>
                <div class="ms-2 shadow shadow-sm w-100 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <Skeletor width="70%" style="border-radius: 3px" height="30" />
                        <Skeletor width="20%" style="border-radius: 3px" height="30" />
                    </div>

                    <ul class="list-group">
                        <li v-for="i in 4" :key="i" class="list-group-item list-group-item-action">
                            <Skeletor width="100%" style="border-radius: 3px" height="30" />
                        </li>
                    </ul>
                </div>
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
    }
});

</script>
