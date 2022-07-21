<template>
    <form action="" method="post">
        <div class="row">
            <div class="col-xl-6 mb-4">
                <Skeletor height="40" width="100%" style="border-radius: 3px" />
            </div>
            <div class="col-xl-6 mb-4">
                <Skeletor height="40" width="100%" style="border-radius: 3px" />
            </div>
            <div class="col-xl-3 mb-4">
                <Skeletor height="40" width="100%" style="border-radius: 3px" />
            </div>
            <div class="col-xl-3 mb-4">
                <Skeletor height="40" width="100%" style="border-radius: 3px" />
            </div>

            <div class="col-xl-6 mb-4">
                <Skeletor height="40" width="100%" style="border-radius: 3px" />
            </div>

            <div class="col-xl-3 mb-4">
                <Skeletor height="40" width="100%" style="border-radius: 3px" />
            </div>
            <div class="col-xl-3 mb-4">
                <Skeletor height="40" width="100%" style="border-radius: 3px" />
            </div>
            <div class="col-xl-6 mb-4">
                <Skeletor height="40" width="100%" style="border-radius: 3px" />
            </div>

            <div class="d-flex justify-content-end">
                <Skeletor height="40" width="10%" style="border-radius: 3px" />
            </div>
        </div>
    </form>
</template>

<script>

import { Skeletor } from 'vue-skeletor'

export default {
    components: {
        Skeletor,
    },
}
</script>
