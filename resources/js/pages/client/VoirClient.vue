<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Fiche client</h5>

            <div class="d-flex justify-content-between">
                <router-link to="/client/nouveau" class="btn btn-secondary me-2"><i class="fa fa-plus me-2"></i>Nouveau</router-link>
                <router-link v-if="!Client.loading.value && Client.entity.value.id" :to="{ name: 'client.modifier', params: { id: Client.entity.value.id }}" class="btn btn-warning me-2"><i class="fa fa-pencil me-2"></i>Modifier</router-link>
                <router-link to="/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste</router-link>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-4 d-flex justify-content-start align-items-center flex-column">
                    <ProfileAvatar class="avatar" v-if="!Client.loading.value && Client.entity.value.nom" bgColor="#CCC" textColor="#000" size="l" :username="Client.entity.value.nom"></ProfileAvatar>
                    <Skeletor class="mb-3" circle v-else size="200" />

                    <h1 v-if="!Client.loading.value" class="text-muted text-center mb-3">{{ Client.entity.value.nom }}</h1>
                    <Skeletor v-else class="mb-3" height="40" width="100%" style="border-radius: 3px" />

                    <div v-if="!Client.loading.value" class="text-center">
                        <span v-for="categorie in Client.entity.value.categories" :key="categorie.id" class="badge bg-primary me-2">{{ categorie.libelle }}</span>
                    </div>
                    <Skeletor v-else height="40" width="75%" style="border-radius: 3px" />
                </div>
                <div class="col-xl-8">
                    <div v-if="!Client.loading.value">
                        <table class="table w-100">
                            <tr>
                                <td><h5 class="text-muted mb-3">Contact</h5></td>
                                <td><h5 class="text-muted">:</h5></td>
                                <td><h5 class="text-muted">{{ Client.entity.value.contact }}</h5></td>
                            </tr>
                            <tr>
                                <td><h5 class="text-muted mb-3">Adresse</h5></td>
                                <td><h5 class="text-muted">:</h5></td>
                                <td><h5 class="text-muted">{{ Client.entity.value.adresse }}</h5></td>
                            </tr>
                            <tr>
                                <td><h5 class="text-muted mb-3">Adresse email</h5></td>
                                <td><h5 class="text-muted">:</h5></td>
                                <td><h5 class="text-muted">{{ Client.entity.value.email ?? "Non définie" }}</h5></td>
                            </tr>
                            <tr>
                                <td><h5 class="text-muted mb-3">NIF</h5></td>
                                <td><h5 class="text-muted">:</h5></td>
                                <td><h5 class="text-muted">{{ Client.entity.value.nif ?? "Non définie" }}</h5></td>
                            </tr>
                            <tr>
                                <td><h5 class="text-muted mb-3">CIF</h5></td>
                                <td><h5 class="text-muted">:</h5></td>
                                <td><h5 class="text-muted">{{ Client.entity.value.cif ?? "Non définie" }}</h5></td>
                            </tr>
                            <tr>
                                <td><h5 class="text-muted mb-3">STAT</h5></td>
                                <td><h5 class="text-muted">:</h5></td>
                                <td><h5 class="text-muted">{{ Client.entity.value.stat ?? "Non définie" }}</h5></td>
                            </tr>
                        </table>
                    </div>
                    <div v-else>
                        <Skeletor height="35" width="100%" class="mb-3" style="border-radius: 5px" />
                        <Skeletor height="35" width="100%" class="mb-3" style="border-radius: 5px" />
                        <Skeletor height="35" width="100%" class="mb-3" style="border-radius: 5px" />
                        <Skeletor height="35" width="100%" class="mb-3" style="border-radius: 5px" />
                        <Skeletor height="35" width="100%" class="mb-3" style="border-radius: 5px" />
                        <Skeletor height="35" width="100%" class="mb-3" style="border-radius: 5px" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import SaveBtn from '../../components/html/SaveBtn.vue';
import Input from '../../components/html/Input.vue';
import { Skeletor } from 'vue-skeletor';
import MultiSelect from '@vueform/multiselect';

import ProfileAvatar from 'vue-profile-avatar'
import useCRUD from '../../services/CRUDServices';

const Client = useCRUD('/client');
const Categorie = useCRUD('/categorie');

export default {
    setup() {
        return {
            Client, Categorie,
        }
    },

    components: {
        Input, SaveBtn, Skeletor, MultiSelect, ProfileAvatar,
    },

    methods: {
        async save(id) {
            await updateclient(id, Client.entity.value);
            window.scrollTo({ top: 0, behavior: "smooth" });
            Client.success.value = null
        },
    },

    mounted() {
        const id = parseInt(this.$route.params.id);
        Client.getEntity(id)
        Categorie.getEntities(1)
    },

}
</script>

