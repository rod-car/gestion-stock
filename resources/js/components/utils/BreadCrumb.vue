<template>
    <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
            <h4 class="page-title pull-left">{{ name }}</h4>
            <ul class="breadcrumbs pull-left">
                <li v-if="tree">
                    <router-link v-if="tree.length === 1" to="/">Accueil</router-link>
                    <router-link v-if="tree.length > 1" to="/">{{ majFirst(tree.at(0).replaceAll('-', ' ')) }}</router-link>
                </li>
                <li v-if="tree">
                    <span v-if="tree.length === 1">{{ majFirst(tree.at(0).replaceAll('-', ' ')) }}</span>
                    <span v-if="tree.length > 1">{{ majFirst(tree.at(1).replaceAll('-', ' ')) }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            name: String,
            path: String,
            tree: Array,
        },
        methods: {
            majFirst (string) {
                return ucfirst(string)
            }
        },
    }

</script>
