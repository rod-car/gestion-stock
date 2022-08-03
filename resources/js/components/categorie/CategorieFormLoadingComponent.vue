<template>
    <div class="row">
        <div class="col-xl-12 mb-3">
            <Skeletor height="40" width="100%" style="border-radius: 3px" />
        </div>
        <div v-if="hasSub" class="col-xl-12 mb-3">
            <Skeletor height="40" width="100%" style="border-radius: 3px" />
        </div>
        <div class="col-xl-12 mb-3">
            <Skeletor height="80" width="100%" style="border-radius: 3px" />
        </div>
        <div class="d-flex justify-content-end">
            <Skeletor height="40" width="10%" style="border-radius: 3px" />
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Skeletor } from 'vue-skeletor';

export default defineComponent({
    props: {
        hasSub: {
            type: Boolean,
            required: false,
            default: false,
        }
    },

    components: {
        Skeletor,
    },

});

</script>
