<template>
    <div>
        <span class="badge bg-success" v-if="value === 1">Valide</span>
        <span class="badge bg-danger" v-if="value === 2">Expiré</span>
        <span class="badge bg-info" v-if="value === 3">Livré</span>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';


export default defineComponent({
    props: {
        value: {
            type: Number,
            required: true,
        },
    },
})

</script>
