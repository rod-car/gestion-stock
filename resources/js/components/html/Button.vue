<template>
    <button v-bind:class="className" class="d-flex align-items-center justify-content-center" type="submit">
        <slot></slot>
    </button>
</template>

<script>
export default {
    props: {
        click: String,
        type: String,
    },
    data() {
        return {
            className: null,
        };
    },
    mounted() {
        if (this.type !== undefined) {
            this.className = "btn btn-" + this.type;
        } else {
            this.className = "btn btn-primary";
        }
    },
}
</script>
