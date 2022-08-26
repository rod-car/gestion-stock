<template>
    <Table
        name="article"
        :data="articles"
        :columns="{ reference: 'Réference', designation: 'Désignation', unite: 'Unité', stock_alert: 'Stock d\'alerte' }"
        :actions="true"
        @onDeleteItem="deleteItem"
    />

    <!--table class="table table-striped table-hover">
        <thead class="bg-secondary text-white">
            <tr>
                <th>Réference</th>
                <th>Designation</th>
                <th>Stock d'alerte</th>
                <th>Unité</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody v-if="articles.length > 0">
            <tr v-for="(article, index) in articles" v-bind:key="article.id">
                <td>{{ article.reference }}</td>
                <td>{{ article.designation }}</td>
                <td>{{ article.stock_alert ?? "Non définie" }}</td>
                <td>{{ article.unite }}</td>
                <td class="d-flex justify-content-center">
                    <router-link v-if="true" :to="{ name: 'article.voir', params: { id: article.id }}" class="btn btn-info btn-sm me-2 text-white"><i class="fa fa-eye"></i></router-link>
                    <router-link v-if="true" :to="{ name: 'article.modifier', params: { id: article.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <DeleteBtn v-if="true" type="danger" @click.prevent="confirmDeletion(article.id, index)"/>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td class="text-center" colspan="9">Aucun article</td>
            </tr>
        </tbody>
    </table-->
</template>

<script lang="ts">
import { Skeletor } from 'vue-skeletor';
import Flash from '../../functions/Flash';
import useCRUD from '../../services/CRUDServices';
import DeleteBtn from '../../components/html/DeleteBtn.vue';
import { defineComponent } from 'vue';
import VueSimpleAlert from 'vue3-simple-alert';
import Table from '../html/Table.vue';

const { deleting, destroy } = useCRUD("/article")

export default defineComponent({
    props: {
        articles: {
            type: Array<any>,
            required: true,
        }
    },

    components: {
        DeleteBtn,
        Skeletor,
        Table
    },

    setup(props) {
        const deleteItem = async ($event): Promise<any> => {
            await confirmDeletion($event.id, $event.index);
        }

        const confirmDeletion = async (id: number, index: number): Promise<any> => {
            const result = await VueSimpleAlert.fire({
                title: 'Supprimer cet article?',
                text: "Cette action ne peut pas être annulé",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Non, annuler',
                allowOutsideClick: false,
            });

            if (result.value === true) {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                await destroy(id, props.articles, index)
            } else if (result.dismiss) {
                Flash('info', "Message", "Suppression annulée")
            }
        }
        return {
            deleting, confirmDeletion, deleteItem,
        }
    }

});
</script>
