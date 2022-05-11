<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card p-5">
                <div v-show="loading">
                    Loading
                </div>
                <div class="card-body" v-show="!loading">
                    <ul>
                        <div v-for="user in users" v-bind:key="user.id">
                            <li class="text-uppercase">{{ user.id }}: {{ user.name }}</li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                users: null,
                loading: true,
            }
        },
        async mounted() {
            let result = await axios('https://jsonplaceholder.typicode.com/users/')
            this.loading = false
            this.users = result.data
        }
    }
</script>
