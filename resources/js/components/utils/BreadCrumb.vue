<template>
    <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
            <h4 class="page-title pull-left">{{ name }}</h4>
            <ul class="breadcrumbs pull-left">
                <li><a href="index.html">Home</a></li>
                <li><span>Dashboard</span></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            name: String,
            path: String,
        },
    }
</script>