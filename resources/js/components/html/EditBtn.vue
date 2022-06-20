<template>
    <Button :type="type">
        <i class="fa fa-edit"></i>
        <slot class="ms-2"></slot>
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
