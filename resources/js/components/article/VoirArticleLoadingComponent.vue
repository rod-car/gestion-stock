<template>
    <div class="row">
        <div class="col-xl-4 d-flex justify-content-start align-items-center flex-column">
            <Skeletor class="mb-3" circle size="200" />
            <Skeletor class="mb-3" height="40" width="100%" style="border-radius: 3px" />
            <Skeletor height="40" width="75%" style="border-radius: 3px" />
        </div>
        <div class="col-xl-8">
            <Skeletor height="35" width="100%" class="mb-3" style="border-radius: 5px" />
            <Skeletor height="35" width="100%" class="mb-3" style="border-radius: 5px" />
            <Skeletor height="35" width="100%" class="mb-3" style="border-radius: 5px" />
        </div>
    </div>
</template>

<script lang="ts">
import { Skeletor } from 'vue-skeletor';
import { defineComponent } from 'vue';

export default defineComponent({

    components: {
        Skeletor,
    },

})
</script>

