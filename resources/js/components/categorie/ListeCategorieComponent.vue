<template>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Libellé</th>
                <th>Description</th>
                <th v-if="type === 3">Sous catégories</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody v-if="categories.length > 0">
            <tr v-for="(categorie, index) in categories" :key="categorie.id">
                <td>{{ categorie.id }}</td>
                <td>{{ categorie.libelle }}</td>
                <td>{{ categorie.description }}</td>
                <td v-if="type === 3">
                    <span v-if="categorie.sous_categories <= 0">Aucune sous-catégories</span>
                    <span class="badge bg-success me-2" v-else v-for="sous_categorie in categorie.sous_categories"
                        :key="sous_categorie.id">{{ sous_categorie.libelle }}</span>
                </td>
                <td class="d-flex justify-content-center">
                    <router-link v-if="true" :to="{ name: `${prefix}.categorie.modifier`, params: { id: categorie.id } }"
                        class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                    <DeleteBtn v-if="true" type="danger" @click.prevent="confirmDeletion(categorie.id, index)" />
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td class="text-center" colspan="6">Aucun catégorie pour le moment</td>
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

const { deleting, destroy } = useCRUD('/categorie');

export default defineComponent({
    props: {
        categories: {
            type: Array<any>,
            required: true,
        },
        type: {
            type: Number,
            required: true,
        },
    },

    components: {
        DeleteBtn,
    },

    setup(props) {
        const prefix = computed((): string => {
            if (props.type === 1) return "client";
            else if (props.type === 2) return "fournisseur";
            else if (props.type === 3) return "article";
            else throw new Error("Le type de categorie doit être 1 ou 2 ou 3");
        })

        const confirmDeletion = async (id: number, index: number): Promise<any> => {
            await SimpleAlert.confirm("Voulez-vous supprimer ce categorie ?", "Question", "question").then(() => {
                Flash('loading', "Chargement", "Suppression en cours", 1, false)
                destroy(id, props.categories, index)
            }).catch(error => {
                if (error !== undefined) {
                    Flash('error', "Message d'erreur", "Impossible de supprimer ce categorie")
                }
            });
        }

        return {
            deleting, confirmDeletion, prefix,
        }
    },

})
</script>
