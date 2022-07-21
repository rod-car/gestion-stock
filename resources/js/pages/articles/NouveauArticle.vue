<template>
    <div class="col-xl-12">
        <div class="card me-3">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Nouveau article</h5>
                    <router-link to="/article/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des articles</router-link>
                </div>
            </div>

            <div class="card-body">
                <NouveauArticleComponent />
            </div>
        </div>
    </div>
</template>

<script>
import NouveauArticleComponent from '../../components/article/NouveauArticleComponent.vue'

export default {
    components: {
        NouveauArticleComponent,
    },
}
</script>
