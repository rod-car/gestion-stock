<template>
    <div class="row mt-8">
        <div class="col-sm-12 text-center">
            <h4 class="text-muted">Liste des stocks par dépôt</h4>
        </div>
        <div class="col-sm-12 mt-2">
            <ul class="list-group">
                <li v-for="(depot, index) in depot" :key="depot.depot.id"
                    class="list-group-item d-flex justify-content-between align-items-center text-muted">
                    {{ depot.depot.nom }}
                    <span class="badge bg-primary rounded-pill">{{ depot.stock }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>

export default {
    props: {
        depot: {
            type: Array,
            default() {
                return []
            }
        }
    }
}
</script>
