<template>
    <div class="row">
        <div class="col-xl-4 d-flex justify-content-start align-items-center flex-column">
            <ProfileAvatar class="avatar" bgColor="#CCC" textColor="#000" size="l" :username="article.designation"></ProfileAvatar>
            <h1 class="text-muted text-center mb-3">{{ article.designation }}</h1>

            <div class="text-center">
                <div v-for="categorie in article.categories" :key="categorie.id">
                    <span class="badge bg-primary me-2">{{ categorie.libelle }}</span>
                    <span class="badge bg-danger me-Z">
                        {{ article.sc[categorie.id].length === 0 ? "" : last(article.sc[categorie.id]) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <table class="table w-100">
                <tr>
                    <td><h5 class="text-muted mb-3">Référence</h5></td>
                    <td><h5 class="text-muted">:</h5></td>
                    <td><h5 class="text-muted">{{ article.reference }}</h5></td>
                </tr>
                <tr>
                    <td><h5 class="text-muted mb-3">Unité</h5></td>
                    <td><h5 class="text-muted">:</h5></td>
                    <td><h5 class="text-muted">{{ article.unite }}</h5></td>
                </tr>
                <tr>
                    <td><h5 class="text-muted mb-3">Stock d'alerte</h5></td>
                    <td><h5 class="text-muted">:</h5></td>
                    <td><h5 class="text-muted">{{ article.stock_alert ?? "Non définie" }}</h5></td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script lang="ts">
import { Skeletor } from 'vue-skeletor';
import ProfileAvatar from 'vue-profile-avatar'
import { last } from '../../functions/functions';
import { defineComponent } from 'vue';

export default defineComponent({
    props: {
        article: {
            type: Object,
            required: true,
        }
    },

    setup() {
        return {
            last,
        }
    },

    components: {
        Skeletor, ProfileAvatar,
    },

});
</script>

