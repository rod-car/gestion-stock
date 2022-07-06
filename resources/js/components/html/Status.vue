<template>
    <div>
        <span class="badge bg-success" v-if="value === 1">Valide</span>
        <span class="badge bg-danger" v-if="value === 2">Expiré</span>
    </div>
</template>

<script>

export default {
    props: {
        value: {
            type: Number,
            required: true,
        },
    },
}

</script>
