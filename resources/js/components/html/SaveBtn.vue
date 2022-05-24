<template>
    <Button :type="type" :click="click">
        <i class="fa fa-save me-2"></i>
        <slot></slot>
    </Button>
</template>

<script>

import Button from './Button.vue';

export default {
    components: {
        Button,
    },
    props: {
        click: String,
        type: String,
    },
}
</script>
