<template>
    <form action="" method="post">
        <div class="row mb-5">
            <div class="col-xl-12">
                <Skeletor height="30" width="30%" style="border-radius: 3px; margin-bottom: 1.5rem;" />
                <div class="row">
                    <div class="col-xl-6 mb-4">
                        <Skeletor height="30" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-6 mb-4">
                        <Skeletor height="30" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-6 mb-4">
                        <Skeletor height="30" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-6">
                        <Skeletor height="30" width="100%" style="border-radius: 3px" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-xl-12">
                <div class="d-flex justify-content-between mb-4">
                    <Skeletor height="30" width="30%" style="border-radius: 3px" />
                    <Skeletor height="30" width="10%" style="border-radius: 3px" />
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-warning">
                                <tr>
                                    <th class="w-25">Nom de l'article</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th>TVA</th>
                                    <th>Montant HT</th>
                                    <th>Montant TTC</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="i in 5" :key="i">
                                    <td>
                                        <Skeletor height="30" width="100%" style="border-radius: 3px" />
                                    </td>
                                    <td>
                                        <Skeletor height="30" width="100%" style="border-radius: 3px" />
                                    </td>
                                    <td>
                                        <Skeletor height="30" width="100%" style="border-radius: 3px" />
                                    </td>
                                    <td>
                                        <Skeletor height="30" width="100%" style="border-radius: 3px" />
                                    </td>
                                    <td>
                                        <Skeletor height="30" width="100%" style="border-radius: 3px" />
                                    </td>
                                    <td>
                                        <Skeletor height="30" width="100%" style="border-radius: 3px" />
                                    </td>
                                    <td>
                                        <Skeletor height="30" width="100%" style="border-radius: 3px" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="d-flex justify-content-end">
                    <Skeletor height="35" width="10%" style="border-radius: 3px" />
                </div>
            </div>
        </div>
    </form>
</template>

<script>

import { Skeletor } from 'vue-skeletor';

export default {
    components: {
        Skeletor,
    },
}

</script>
