<template>
    <div class="row">
        <div class="col-xl-12">
            <div class="card me-3">
                <div class="card-header bg-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-info">Gerer le prix d'article</h5>
                        <div class="d-flex justify-content-between">
                            <router-link :to="{ name: 'point-de-vente.voir', params: { id: id }}" class="btn btn-secondary me-3"><i class="fa fa-eye me-2"></i>Voir le point de vente</router-link>
                            <router-link to="/point-de-vente/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des point de vente</router-link>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="" method="post">
                        <div class="mt-3 mb-3 d-flex justify-content-end">
                            <h6 class="text-danger">Quantité totale: <b>{{ loading ? 'Chargement...' : QUANTITE_MAX }}</b></h6>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Référence de l'article</th>
                                    <th>Désignation de l'article</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody v-if="loading === false">
                                <tr v-for="i in fieldNumber" :key="i">
                                    <td class="align-middle">{{ articles[i - 1].reference }}</td>
                                    <td class="align-middle">{{ articles[i - 1].designation }}</td>
                                    <td class="align-middle">
                                        <label v-if="i === 1" class="form-label">{{ articles[i - 1].quantite ?? 'Quantité restant' }}</label>
                                        <input v-else v-model="articles[i-1].quantite" @blur="checkQuantite(i - 1)" type="number" class="form-control">
                                    </td>
                                    <td class="align-middle"><input v-model="articles[i-1].pu" type="number" class="form-control"></td>
                                    <td class="align-middle text-center">
                                        <button v-if="i === 1" @click.prevent="addItem(1)" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                        <button v-if="i > 1" @click.prevent="removeItem(i-1)" type="button" class="btn btn-danger"><i class="fa fa-minus"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-5 mb-3 d-flex justify-content-end">
                            <SaveBtn @click.prevent="save" :loading="creating">Enregistrer</SaveBtn>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import router from '../../router/router';
import { defineComponent, onBeforeMount, Ref, ref } from 'vue';
import axiosClient from '../../axios';
import Flash from '../../functions/Flash';
import SaveBtn from '../../components/html/SaveBtn.vue';
import { AxiosError } from 'axios';

type Article = {
    reference: string,
    designation: string,
    quantite: number|null,
    pu: number,
}

export default defineComponent({
    setup() {
        const id: Ref<number> = ref(0);
        const fieldNumber: Ref<number> = ref(0);
        const articles: Ref<Array<Article>> = ref([]);
        const article: Ref<any> = ref(null);
        const loading = ref(false);
        const creating = ref(false);
        const QUANTITE_MAX: Ref<number> = ref(0);

        const addItem = (quantite: number | null = null) => {
            if (fieldNumber.value > 2) {
                Flash("error", "Message d'erreur", `Vous avez atteint la limite de nombre de champ. Limite max: ${3}`);
                return;
            }
            fieldNumber.value++;
            articles.value.push({
                reference: article.value.reference,
                designation: article.value.designation,
                quantite: quantite,
                pu: article.value.fullArticle.pivot.pu
            });
            checkQuantite(fieldNumber.value - 1);
        };
        const checkQuantite = (index: number) => {
            let quantiteTotal = 0;
            articles.value.forEach((article, index) => {
                if (index > 0 && article.quantite) {
                    quantiteTotal += article.quantite;
                }
            });
            if (quantiteTotal > QUANTITE_MAX.value) {
                articles.value[index].quantite = null;
                Flash("error", "Message d'erreur", "La quantité maximale est dépassé");
            }
        };

        const removeItem = (index: number) => {
            articles.value.splice(index, 1);
            fieldNumber.value--;
        };

        const save = async (): Promise<any> => {
            creating.value = true;
            try {
                await axiosClient.post(`/depot/${id.value}/gerer-prix/${article.value.article_id}`, { articles: articles.value });
                Flash('success', "Message de succès", "Enregistré avec succès");
            } catch (error: any) {
                if (error.response.status === 422) {
                    Flash('error', "Message d'erreur", error.response.data.message)
                }
            }
            creating.value = false;
        };

        onBeforeMount(async (): Promise<any> => {
            const depotId = parseInt(router.currentRoute.value.params.depot_id.toString());
            const articleId = parseInt(router.currentRoute.value.params.article_id.toString());
            id.value = depotId;
            loading.value = true;
            let response = await axiosClient.get(`/depot/${depotId}/articles/?article_id=${articleId}`);
            article.value = response.data;
            loading.value = false;
            // Recuperer la reference de l'article ainsi que la quantité
            if (article.value !== null) {
                addItem();
                QUANTITE_MAX.value = parseFloat(article.value.entree) - parseFloat(article.value.sortie ?? 0);
            }
        });
        return {
            id,
            addItem,
            fieldNumber,
            removeItem,
            articles,
            loading,
            QUANTITE_MAX,
            checkQuantite,
            save,
            creating,
        };
    },
    components: { SaveBtn }
})
</script>
