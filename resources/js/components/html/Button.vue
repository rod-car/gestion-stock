<template>
    <button v-bind:class="className" type="submit">
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
