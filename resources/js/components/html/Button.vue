<template>
    <button v-bind:class="className" @click.prevent="click">
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
        console.log(this.type);
        if (this.type !== undefined) {
            this.className = "btn btn-" + this.type;
        } else {
            this.className = "btn btn-primary";
        }
    },
}
</script>
