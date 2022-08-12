<template>
    <label for="input"><slot></slot></label>
    <input type="file" :multiple="false" name="input" id="input" class="form-control" accept="image/png, image/jpeg, .pdf" @change="handleFileChange">

    <div class="row mt-3">
        <div v-for="path in paths" :key="path" class="col-xl-12">
            <iframe :src="path" frameborder="1" width="100%" height="500px"></iframe>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, onBeforeMount, Ref, ref } from "vue";

export default defineComponent({

    props: {
        multiple: {
            type: Boolean,
            required: false,
            default: false,
        },

        default: {
            type: String,
            required: false,
            default: null,
        },
    },

    setup(props, { emit }) {
        const paths: Ref<Array<any>> = ref([]);

        const handleFileChange = (e: Event) => {
            if (e.target) {
                const input = <HTMLInputElement>e.target
                const reader = new FileReader();

                if (input.files)
                {
                    paths.value = [];
                    Array.from(input.files).forEach((file: File) => {
                        reader.readAsDataURL(file);
                        reader.onload = (e: ProgressEvent<FileReader>): any => {
                            paths.value.push(e.target?.result)
                        }
                    })
                }

                emit('fileChanged', input.files)
            }
        }

        onBeforeMount((): void => {
            if (props.default !== null && props.default !== undefined) paths.value.push(props.default);
        })

        return {
            handleFileChange, paths,
        }
    }

});

</script>
