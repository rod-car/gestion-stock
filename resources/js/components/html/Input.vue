<template>
    <label class="form-label"><slot></slot></label>
    <input v-bind:class="hasErrors === true ? 'border-danger' : ''" v-bind="$attrs" :type="type === undefined ? 'text' : type" :placeholder="placeholder" :value="modelValue" @blur="handleBlur" class="form-control" />
    <div class="text-danger mt-1" v-if="hasErrors">
        {{ error[0] }}
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
    props: {
        modelValue: {
            type: String,
            required: true,
        },
        type: String,
        placeholder: String,
        error: Object,
    },
    data() {
        return {
            hasErrors: false,
        }
    },
    methods: {
        handleBlur (e) {
            if (e.target.value !== "") {
                this.hasErrors = false;
            }
            this.$emit('update:modelValue', e.target.value);
        },
    },
    watch: {
        error: function () {
            if (this.error.length > 0) {
                this.hasErrors = true;
            }
        }
    }
}
</script>
