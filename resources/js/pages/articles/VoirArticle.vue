<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Fiche article</h5>

            <div class="d-flex justify-content-between">
                <router-link to="/article/nouveau" class="btn btn-secondary me-2"><i class="fa fa-plus me-2"></i>Nouveau</router-link>
                <router-link v-if="!Article.loading.value && Article.entity.value.id" :to="{ name: 'article.modifier', params: { id: Article.entity.value.id }}" class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/article/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-4 d-flex justify-content-start align-items-center flex-column">
                    <ProfileAvatar class="avatar" v-if="!Article.loading.value && Article.entity.value.designation" bgColor="#CCC" textColor="#000" size="l" :username="Article.entity.value.designation"></ProfileAvatar>
                    <Skeletor class="mb-3" circle v-else size="200" />

                    <h1 v-if="!Article.loading.value" class="text-muted text-center mb-3">{{ Article.entity.value.designation }}</h1>
                    <Skeletor v-else class="mb-3" height="40" width="100%" style="border-radius: 3px" />

                    <div v-if="!Article.loading.value" class="text-center">
                        <div v-for="categorie in Article.entity.value.categories" :key="categorie.id">
                            <span class="badge bg-primary me-2">{{ categorie.libelle }}</span>
                            <span class="badge bg-danger me-2" v-for="s_categorie in categorie.sous_categories" :key="s_categorie.id">{{ s_categorie.libelle }}</span>
                        </div>
                    </div>
                    <Skeletor v-else height="40" width="75%" style="border-radius: 3px" />
                </div>
                <div class="col-xl-8">
                    <div v-if="!Article.loading.value">
                        <table class="table w-100">
                            <tr>
                                <td><h5 class="text-muted mb-3">Référence</h5></td>
                                <td><h5 class="text-muted">:</h5></td>
                                <td><h5 class="text-muted">{{ Article.entity.value.reference }}</h5></td>
                            </tr>
                            <tr>
                                <td><h5 class="text-muted mb-3">Unité</h5></td>
                                <td><h5 class="text-muted">:</h5></td>
                                <td><h5 class="text-muted">{{ Article.entity.value.unite }}</h5></td>
                            </tr>
                            <tr>
                                <td><h5 class="text-muted mb-3">Stock d'alerte</h5></td>
                                <td><h5 class="text-muted">:</h5></td>
                                <td><h5 class="text-muted">{{ Article.entity.value.stock_alert ?? "Non définie" }}</h5></td>
                            </tr>
                        </table>
                    </div>
                    <div v-else>
                        <Skeletor height="35" width="100%" class="mb-3" style="border-radius: 5px" />
                        <Skeletor height="35" width="100%" class="mb-3" style="border-radius: 5px" />
                        <Skeletor height="35" width="100%" class="mb-3" style="border-radius: 5px" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import SaveBtn from '../../components/html/SaveBtn.vue';
import Input from '../../components/html/Input.vue';
import { Skeletor } from 'vue-skeletor';
import MultiSelect from '@vueform/multiselect';

import ProfileAvatar from 'vue-profile-avatar'
import useCRUD from '../../services/CRUDServices';

const Article = useCRUD('/article');

export default {
    setup() {
        return {
            Article,
        }
    },

    components: {
        Input, SaveBtn, Skeletor, MultiSelect, ProfileAvatar,
    },

    mounted() {
        const id = parseInt(this.$route.params.id);
        Article.getEntity(id)
    },

}
</script>

<style scoped>

.avatar {
    font-size: 50px;
    width: 200px;
    height: 200px;
    margin-bottom: 2rem;
}

</style>
