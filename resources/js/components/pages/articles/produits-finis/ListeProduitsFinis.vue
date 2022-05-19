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
                                    <th scope="col">Name</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody v-show="loading">
                                <tr>
                                    <th class="text-center text-info" colspan="4">Chargement des données</th>
                                </tr>
                            </tbody>
                            <tbody v-show="!loading">
                                <tr v-for="user in users.data" v-bind:key="user.id">
                                    <th scope="row">{{ user.id }}</th>
                                    <th scope="row">{{ user.name }}</th>
                                    <th scope="row">{{ user.email }}</th>
                                    <td><i class="ti-trash"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        <pagination align="center" :data="users" @pagination-change-page="list"></pagination>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from 'axios';
import { ref } from "vue";
import pagination from 'laravel-vue-pagination'

export default {
    components: {
        pagination,
    },
    data() {
        return {
            users: ref([]),
            loading: true,
        }
    },
    async mounted() {
        this.list();
    },
    methods:{
        async list(page=1){
            await axios.get(`http://localhost:8000/api/user?page=${page}`).then(({data})=>{
                this.users = data
                this.loading = false
            }).catch(({ response })=>{
                if (response.status === 401) {
                    alert("Vous n'êtes pas connecté");
                    window.location = '/login';
                }
            })
        }
    }
}
</script>

<style scoped>
    .pagination{
        margin-top: 20px;
        margin-bottom: 0;
    }
</style>
