<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Modifier le client</h5>
            <router-link to="/client/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des clients</router-link>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-xl-6 mb-3">
                        <Input v-if="!Client.loading.value" v-model="Client.entity.value.nom" :error="Client.errors.value.nom" :required="true">Nom du client</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-6 mb-3">
                        <Input v-if="!Client.loading.value" v-model="Client.entity.value.adresse" :error="Client.errors.value.adresse" :required="true">Adresse</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>

                    <div class="col-xl-3 mb-3">
                        <Input v-if="!Client.loading.value" v-model="Client.entity.value.email" :error="Client.errors.value.email" :required="false">Email</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-3 mb-3">
                        <Input v-if="!Client.loading.value" v-model="Client.entity.value.contact" :error="Client.errors.value.contact" :required="true">Contact</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-6 mb-3">
                        <label v-if="!Client.loading.value" for="categorie" class="form-label">Catégorie</label>
                        <MultiSelect
                            v-if="!Client.loading.value"
                            v-bind:class="hasError ? 'border-danger' : ''"
                            label="libelle" valueProp="id" :multiple="true" v-model="Client.entity.value.categories"
                            :options="Categorie.entities.value" mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                            :searchable="true" :object="true"
                            noOptionsText="Aucune catégorie" noResultsText="Aucune catégorie"
                            @close="check"
                        />

                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />

                        <div class="text-danger mt-1" v-if="hasError">
                            {{ Client.errors.value.categories[0] }}
                        </div>
                    </div>

                    <div class="col-xl-3 mb-3">
                        <Input v-if="!Client.loading.value" type="text" v-model="Client.entity.value.nif" :error="Client.errors.value.nif">NIF</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-3 mb-3">
                        <Input v-if="!Client.loading.value" type="text" v-model="Client.entity.value.cif" :error="Client.errors.value.cif">CIF</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-6 mb-3">
                        <Input v-if="!Client.loading.value" type="text" v-model="Client.entity.value.stat" :error="Client.errors.value.stat">STAT</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>

                    <div class="d-flex justify-content-end">
                        <SaveBtn v-if="!Client.loading.value" @click.prevent="save(Client.entity.value.id)" :loading="Client.updating.value">Enregistrer</SaveBtn>
                        <Skeletor v-else height="40" width="10%" style="border-radius: 3px" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

import SaveBtn from '../../components/html/SaveBtn.vue';
import Input from '../../components/html/Input.vue';
import { Skeletor } from 'vue-skeletor';
import MultiSelect from '@vueform/multiselect';
import useCRUD from '../../services/CRUDServices';

const Client = useCRUD('/client')
const Categorie = useCRUD('/categorie')

export default {
    setup() {
        return {
            Client, Categorie,
        }
    },

    components: {
        Input, SaveBtn, Skeletor, MultiSelect,
    },

    methods: {
        async save(id) {
            await Client.updateEntity(id, Client.entity.value);
            window.scrollTo({ top: 0, behavior: "smooth" });
            Client.success.value = null
        },
    },

    mounted() {
        const id = parseInt(this.$route.params.id);
        Client.getEntity(id)
        Categorie.getEntities({ type: 1 })
    },

}
</script>
