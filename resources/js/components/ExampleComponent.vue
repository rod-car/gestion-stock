<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card p-5">
                <div v-show="loading">
                    <div class="loader"></div>
                </div>
                <div class="card-body" v-show="!loading">
                    <ul>
                        <div v-for="post in posts" v-bind:key="post.id">
                            <li class="text-uppercase">{{ post.id }}: {{ post.title }}</li>
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
                posts: null,
                loading: true,
            }
        },
        async mounted() {
            let result = await axios('https://jsonplaceholder.typicode.com/posts/')
            this.loading = false
            this.posts = result.data
        }
    }
</script>
