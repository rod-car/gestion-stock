<template>
    <Button :type="type" :disabled="loading" :click="click">
        <i v-if="!loading" class="fa fa-save me-2"></i>
        <div v-else class="spinner-border spinner-border-sm text-light me-2" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <slot v-if="!loading"></slot>
        <span v-else>Chargement...</span>
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
        loading: Boolean,
    },
}
</script>
