<template>
    <div class="row">
        <div class="col-xl-4 d-flex justify-content-start align-items-center flex-column">
            <ProfileAvatar class="avatar" bgColor="#CCC" textColor="#000" size="l" :username="fournisseur.nom"></ProfileAvatar>
            <h1 class="text-muted text-center mb-3">{{ fournisseur.nom }}</h1>
            <div class="text-center">
                <span v-for="categorie in fournisseur.categories" :key="categorie.id" class="badge bg-primary me-2">{{ categorie.libelle }}</span>
            </div>
        </div>
        <div class="col-xl-8">
            <table class="table w-100">
                <tr>
                    <td><h5 class="text-muted mb-3">Contact</h5></td>
                    <td><h5 class="text-muted">:</h5></td>
                    <td><h5 class="text-muted">{{ fournisseur.contact }}</h5></td>
                </tr>
                <tr>
                    <td><h5 class="text-muted mb-3">Adresse</h5></td>
                    <td><h5 class="text-muted">:</h5></td>
                    <td><h5 class="text-muted">{{ fournisseur.adresse }}</h5></td>
                </tr>
                <tr>
                    <td><h5 class="text-muted mb-3">Adresse email</h5></td>
                    <td><h5 class="text-muted">:</h5></td>
                    <td><h5 class="text-muted">{{ fournisseur.email ?? "Non définie" }}</h5></td>
                </tr>
                <tr>
                    <td><h5 class="text-muted mb-3">NIF</h5></td>
                    <td><h5 class="text-muted">:</h5></td>
                    <td><h5 class="text-muted">{{ fournisseur.nif ?? "Non définie" }}</h5></td>
                </tr>
                <tr>
                    <td><h5 class="text-muted mb-3">CIF</h5></td>
                    <td><h5 class="text-muted">:</h5></td>
                    <td><h5 class="text-muted">{{ fournisseur.cif ?? "Non définie" }}</h5></td>
                </tr>
                <tr>
                    <td><h5 class="text-muted mb-3">STAT</h5></td>
                    <td><h5 class="text-muted">:</h5></td>
                    <td><h5 class="text-muted">{{ fournisseur.stat ?? "Non définie" }}</h5></td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script lang="ts">
import ProfileAvatar from 'vue-profile-avatar'
import { defineComponent } from 'vue';

export default defineComponent({
    props: {
        fournisseur: {
            type: Object,
            required: true,
        },
    },

    components: {
       ProfileAvatar,
    },

})

</script>
