<template>
    <table class="table table-striped table-hover">
        <thead class="bg-secondary text-white">
            <tr>
                <th>ID</th>
                <th>Numero</th>
                <th>Date</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody v-if="TransfertList.length > 0">
            <tr v-for="(transfert, index) in TransfertList" v-bind:key="transfert.id">
                <td>{{ transfert.id }}</td>
                <td>{{ transfert.numero }}</td>
                <td>{{ transfert.date }}</td>
                <td class="d-flex justify-content-center">
                    <router-link v-if="true" :to="{ name: 'transfert.modifier', params: { id: transfert.id } }"
                        class="btn btn-info btn-sm me-2 text-white"><i class="fa fa-eye"></i></router-link>
                    <router-link v-if="true" :to="{ name: 'transfert.modifier', params: { id: transfert.id } }"
                        class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <DeleteBtn v-if="true" type="danger" @click.prevent="confirmDeletion(transfert.id, index)" />
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td class="text-center" colspan="9">Aucun client</td>
            </tr>
        </tbody>
    </table>
</template>
<script lang="ts">
import axiosClient from '../../axios';
import DeleteBtn from '../html/DeleteBtn.vue'
import SimpleAlert from 'vue3-simple-alert';
import useCRUD from '../../services/CRUDServices';

import Flash from '../../functions/Flash';
const { destroy } = useCRUD('/transfert-article');

import { computed, onMounted, onBeforeMount, ref, defineComponent, Ref, watch } from 'vue';

export default {
    components: {
        DeleteBtn
    },
    setup() {
        // -------- State ---------
        let TransfertList = ref([])
        // -------- State ---------

        // ------- methodes --------
        const getList = () => (
            axiosClient.get("/transfert-article").then(({ data }) => {
                TransfertList.value = data
                console.log(TransfertList)
            })
        )

        const confirmDeletion = async (id: number, index: number): Promise<any> => {
            await SimpleAlert.confirm("Voulez-vous supprimer ce transfert ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                //destroy(id, props.entities, index)
            }).catch((error: undefined) => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce transfert")
                }
            });
        }

        // ------- methodes --------

        onMounted(() => {
            getList()
        })

        return { TransfertList, confirmDeletion }

    }
}

</script>
