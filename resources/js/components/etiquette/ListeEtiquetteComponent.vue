<template>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Libellé</th>
                <th>Description</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody v-if="etiquettes.length > 0">
            <tr v-for="(etiquette, index) in etiquettes" :key="etiquette.id">
                <td>{{ etiquette.id }}</td>
                <td>{{ etiquette.libelle }}</td>
                <td>{{ etiquette.description }}</td>

                <td class="d-flex justify-content-center">
                    <router-link v-if="true" :to="{ name: `parametres.etiquette.modifier`, params: { id: etiquette.id } }"
                        class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <DeleteBtn v-if="true" type="danger" @click.prevent="confirmDeletion(etiquette.id, index)" />
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td class="text-center" colspan="6">Aucune étiquette pour le moment</td>
            </tr>
        </tbody>
    </table>
</template>

<script lang="ts">

import Flash from '../../functions/Flash';
import useCRUD from '../../services/CRUDServices';
import DeleteBtn from '../../components/html/DeleteBtn.vue';
import SimpleAlert from 'vue3-simple-alert';
import { computed, defineComponent } from 'vue';

const { deleting, destroy } = useCRUD('/etiquette');

export default defineComponent({
    props: {
        etiquettes: {
            type: Array<any>,
            required: true
        }
    },
    setup(props) {
        const confirmDeletion = async (id: number, index: number): Promise<any> => {
            await SimpleAlert.confirm("Voulez-vous supprimer ce étiquettes ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                destroy(id, props.etiquettes, index)
            }).catch(error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce étiquette")
                }
            });
        }

        return {
            deleting, confirmDeletion,
        }
    },
    components: {
        DeleteBtn,
    },
})

</script>
