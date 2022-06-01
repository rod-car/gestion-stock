<template>
    <label class="form-label">
        <slot></slot>
        <span class="text-danger ms-2" v-if="required">(*)</span>
    </label>

    <div v-if="type === 'textarea'">
        <textarea v-bind:class="hasErrors === true ? 'border-danger' : ''" v-bind="$attrs" :placeholder="placeholder" @blur="handleBlur" class="form-control">{{ modelValue }}</textarea>
    </div>

    <div v-else>
        <input v-bind:class="hasErrors === true ? 'border-danger' : ''" v-bind="$attrs" :type="type === undefined ? 'text' : type" :placeholder="placeholder" :value="modelValue" @blur="handleBlur" class="form-control" />
    </div>

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
        required: {
            type: Boolean,
            required: false,
        },
        filter: String,
    },
    data() {
        return {
            hasErrors: false,
        }
    },
    methods: {
        handleBlur (e) {
            let value = e.target.value
            if (value !== "") this.hasErrors = false
            this.$emit('update:modelValue', value)
        },
    },
    watch: {
        error: function () {
            if (this.error && this.error.length > 0) {
                this.hasErrors = true;
            }
        }
    }
}
</script>
