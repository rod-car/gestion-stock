<template>
    <div v-bind:class="className" class="mt-3 mb-3" v-if="message && Array.isArray(message) === false">
        {{ message }}
    </div>
</template>

<script>
export default {
    props: {
        message: String,
        type: String,
    },
    data() {
        return {
            className: null,
        }
    },
    mounted() {
        if (this.type !== undefined) {
            this.className = "alert alert-" + this.type;
        }
    },
    unmounted() {

    },
}
</script>
