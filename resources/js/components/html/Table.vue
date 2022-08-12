<template>
    <table class="table table-striped w-100">
        <thead class="bg-secondary text-white">
            <tr>
                <th v-for="col in alias">{{ col }}</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody v-if="rows.length > 0">
            <tr v-for="(row, index) in rows">
                <td v-for="col in cols">{{ row[col] ?? '-' }}</td>
                <td class="d-flex justify-content-center">
                    <router-link v-if="true" :to="{ name: `${name}.voir`, params: { id: row.id }}" class="btn btn-info btn-sm me-2 text-white"><i class="fa fa-eye"></i></router-link>
                    <router-link v-if="true" :to="{ name: `${name}.modifier`, params: { id: row.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <DeleteBtn v-if="true" type="danger" @click.prevent="$emit('onDeleteItem', { id: row.id, index: index })" />
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td :colspan="cols.length" class="text-center">No data</td>
            </tr>
        </tbody>
    </table>
</template>

<script lang="ts">
import { defineComponent, Ref, ref } from "vue";
import DeleteBtn from "./DeleteBtn.vue";

export default defineComponent({
    props: {
        columns: {
            type: [Array<string>, Object],
            required: false,
            default: null,
        },
        data: {
            type: Array<any>,
            required: true,
        },
        name: {
            type: String,
            required: true,
        }
    },
    setup(props) {
        const cols: Ref<string[]> = ref([]);
        const alias: Ref<string[]> = ref([]);
        const rows: Ref<Array<any>> = ref([]);
        if (props.columns === null) {
            cols.value = Object.keys(props.data[0]);
            alias.value = cols.value;
        }
        else {
            if (Array.isArray(props.columns))
                cols.value = props.columns;
            if (typeof props.columns === "object") {
                alias.value = Object.values(props.columns);
                cols.value = Object.keys(props.columns);
            }
        }
        rows.value = props.data;
        return {
            rows,
            cols,
            alias,
        };
    },
    components: { DeleteBtn }
});

</script>
