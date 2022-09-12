<template>
    <label v-if="hasSlot" class="form-label">
        <slot></slot>
        <span class="text-danger ms-2" v-if="required">(*)</span>
    </label>
    <textarea v-if="type === 'textarea'" :class="hasErrors === true ? 'border-danger' : ''" v-bind="$attrs" :placeholder="placeholder" @change="handleBlur" class="form-control" :value="modelValue"></textarea>

    <input v-else :class="hasErrors === true ? 'border-danger' : ''" v-bind="$attrs" :type="type === undefined ? 'text' : type" :placeholder="placeholder" :value="modelValue" @change="handleBlur" class="form-control" />

    <div class="text-danger mt-1" v-if="hasErrors">
        {{ error[0] }}
    </div>
</template>

<script lang="ts">
import { computed, ref, Ref, watch, defineComponent } from 'vue'

export default defineComponent({
    inheritAttrs: false,
    props: {
        modelValue: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            required: false,
            default: 'text'
        },
        placeholder: {
            type: String,
            required: false,
            default: ''
        },
        error: {
            type: Array,
            required: false,
            default: [],
        },
        required: {
            type: Boolean,
            required: false,
        },
        filter: {
            type: String,
            required: false,
        },
    },

    emits: ['update:modelValue'],

    setup(props, { emit, slots }) {
        const hasErrors: Ref<boolean> = ref(false);

        const handleBlur = (e: Event) => {
            if (e.target instanceof HTMLInputElement) {
                let value = e.target.value
                if (value !== "") hasErrors.value = false
                emit('update:modelValue', value)
            }
            throw new Error("Event is not an input element event");

        }

        const hasSlot = computed(() => {
            return slots.default !== undefined;
        })

        watch(
            () => props.error, (value) => {
                if (value && value.length > 0) {
                    hasErrors.value = true;
                }
            }
        );

        return {
            hasErrors, handleBlur, hasSlot,
        }
    },
})
</script>
