<template>
    <div class="col-xl-12">
        <div class="card">
            <div v-show="loading">Chargement</div>
            <div class="card-body">
                <h4 class="text-uppercase mb-3">Liste des produits finis</h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="text-uppercase bg-secondary">
                                <tr class="text-white">
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody v-show="loading">
                                <tr>
                                    <th class="text-center text-info" colspan="4">Chargement des données</th>
                                </tr>
                            </tbody>
                            <tbody v-show="!loading">
                                <tr v-for="post in posts" v-bind:key="post.id">
                                    <th scope="row">{{ post.id }}</th>
                                    <th scope="row">{{ post.title }}</th>
                                    <th scope="row">{{ post.body }}</th>
                                    <td><i class="ti-trash"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from 'axios';
import { ref } from "vue";

export default {

    data() {
        return {
            posts: ref([]),
            loading: true,
        }
    },
    async mounted() {
        let result = await axios('https://jsonplaceholder.typicode.com/posts/')
        this.loading = false
        this.posts = result.data
    },
}
</script>
