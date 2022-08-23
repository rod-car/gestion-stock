<template>
    <div v-if="searchable">
        <form action="" method="get" class="d-flex justify-content-end mb-3">
            <input v-model="query" @input="filter" type="text" class="form-control w-25" placeholder="Search">
        </form>
    </div>

    <table class="table table-striped w-100">
        <thead>
            <tr>
                <th @click="changeOrder(col)" vbind:class="ordered ? 'table-header' : ''" v-for="col in alias" :class="col === 'PU' ? 'text-end' : ''"><i v-if="ordered" class="fa fa-arrow-up me-2"></i>
                    {{ col }}
                </th>
                <th v-if="actions || showable" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody v-if="loading">
            <tr v-for="i in 5" :key="i">
                <td v-for="j in cols.length" :key="j">
                    <Skeletor height="30" width="100%" style="border-radius: 3px" />
                </td>
                <td v-if="actions || showable">
                    <Skeletor height="30" width="100%" style="border-radius: 3px" />
                </td>
            </tr>
        </tbody>
        <tbody v-else-if="d.length > 0">
            <tr v-for="(row, index) in d">
                <td class="align-middle" v-for="col in cols" :class="casts[col] === 'money' ? 'text-end' : ''">
                    <ul class="list" v-if="display(row, col).length > 1 && typeof display(row, col) === 'object'">
                        <li v-for="(data, index) in display(row, col)" :key="index">
                            <b>{{ data.quantite === null ? "Quantité restant" : data.quantite + ' (Quantité)' }}</b> : {{ format(data.pu) }}
                        </li>
                    </ul>
                    <span v-else>
                        {{ display(row, col).length === 0 ? "Non définie" : display(row, col) }}
                    </span>
                </td>
                <td v-if="actions === true" class="d-flex justify-content-center align-middle">
                    <router-link v-if="true" :to="{ name: `${name}.voir`, params: { id: row[id] }}" class="btn btn-info btn-sm me-2 text-white"><i class="fa fa-eye"></i></router-link>
                    <router-link v-if="true" :to="{ name: `${name}.modifier`, params: { id: row[id] }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <DeleteBtn v-if="true" type="danger" @click.prevent="$emit('onDeleteItem', { id: row[id], index: index })" />
                </td>
                <td class="align-middle text-center" v-else-if="showable">
                    <button @click.prevent="$emit('onShow', { id: row[id] })" class="btn btn-danger btn-sm me-2 text-white">
                        <i class="fa fa-cog"></i>
                    </button>
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
import { defineComponent, Ref, ref, watch } from "vue";
import DeleteBtn from "./DeleteBtn.vue";
import { Skeletor } from "vue-skeletor";
import { format } from "../../functions/functions";

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
        },
        actions: {
            type: Boolean,
            required: false,
            default: false
        },
        searchable: {
            type: Boolean,
            required: false,
            default: false,
        },
        ordered: {
            type: Boolean,
            required: false,
            default: false,
        },
        loading: {
            type: Boolean,
            required: false,
            default: false,
        },
        casts: {
            type: Object,
            required: false,
            default: [],
        },
        showable: {
            type: Boolean,
            required: false,
            default: false
        },
        editable: {
            type: Boolean,
            required: false,
            default: false
        },
        deletable: {
            type: Boolean,
            required: false,
            default: false
        },
        id: {
            type: String,
            required: false,
            default: 'id'
        },
    },

    emits: ["onShow", "onDeleteItem"], // <--- add this line

    setup(props) {
        const cols: Ref<string[]> = ref([]);
        const alias: Ref<string[]> = ref([]);
        const query: Ref<string> = ref('');
        const d: Ref<Array<any>> = ref(props.data);

        if (props.columns === null) {
            cols.value = Object.keys(props.data[0]);
            alias.value = cols.value;
        } else {
            if (Array.isArray(props.columns))
                cols.value = props.columns;
            if (typeof props.columns === "object") {
                alias.value = Object.values(props.columns);
                cols.value = Object.keys(props.columns);
            }
        }

        watch(
            () => props.loading, (value) => {
                if (value === false) d.value = props.data
            }
        );


        const changeOrder = (col: string) => {

        }

        /**
         * Retourner la valeur a afficher dans la colonne
         *
         * @param   {any}     row  La ligne en question (Un enregistrement dans l'objet) - Peut être un tableau complexe
         * @param   {string}  col  La colonne en question (Un clé dans row)
         *
         * @return  {string}           [return description]
         */
        const display = (row: { [x: string]: any; }, col: string): string|Array<any> => {
            if (row[col] === null) return '-';

            else if (row[col] !== undefined)
            {
                if (props.casts[col] !== undefined) {
                    return castingValue(props.casts[col], row[col])
                }
                return row[col]
            }
            else
            {
                let columns: string[] = [];
                let operator: null|string = null;

                if (col.includes('-')) {
                    columns = col.split('-')
                    operator = 'minus'
                } else {
                    columns = col.split('.');
                }

                const first = columns[0].trim();
                columns = columns.slice(1);

                let data = row[first];

                columns.forEach((column: string) => {
                    if (operator === 'minus') {
                        data = parseFloat(data)
                        if (row[column.trim()] !== null) data -= parseFloat(row[column.trim()])
                    } else {
                        data = data[column.trim()]
                    }
                })

                if (data === null || data === undefined) return "Undefined value"

                if (props.casts[col] !== undefined) {
                    return castingValue(props.casts[col], data)
                }

                return data;
            }
        }

        const castingValue = (castType: string, value: string | number): string => {
            if (castType === 'decimal') return (value + ' - ' + castType).toString();
            if (castType === 'money')
                if (typeof (value) === "number") return format(value).toString();
                else return format(parseFloat(value)).toString();
            return value.toString();
        }

        const filter = () => {
            if (query.value === "") d.value = props.data
            else {
                d.value = d.value.filter(data => {
                    return data.designation.toLowerCase().includes(query.value)
                })
            }
        }

        return {
            d,
            cols,
            alias,
            query,
            filter,
            format,
            display,
            castingValue,
            changeOrder,
        };
    },
    components: { DeleteBtn, Skeletor }
});

</script>

<style scoped>

.table-header:hover {
	background: rgba(192, 192, 192, .5);
}

.table-header {
	cursor: pointer;
    transition: all;
    transition-duration: .3s;
}

</style>
