<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Modifier le fournisseur</h5>
            <router-link to="/fournisseur/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des fournisseurs</router-link>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-xl-6 mb-3">
                        <Input v-if="!loading" v-model="fournisseur.nom" :error="errors.nom" :required="true">Nom du fournisseur</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-6 mb-3">
                        <Input v-if="!loading" v-model="fournisseur.adresse" :error="errors.adresse" :required="true">Adresse</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>

                    <div class="col-xl-3 mb-3">
                        <Input v-if="!loading" v-model="fournisseur.email" :error="errors.email" :required="false">Email</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-3 mb-3">
                        <Input v-if="!loading" v-model="fournisseur.contact" :error="errors.contact" :required="true">Contact</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-6 mb-3">
                        <label v-if="!loading" for="categorie" class="form-label">Catégorie</label>
                        <MultiSelect
                            v-if="!loading"
                            v-bind:class="hasError ? 'border-danger' : ''"
                            label="libelle" valueProp="id" :multiple="true" v-model="fournisseur.categories"
                            :options="categories" mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                            :searchable="true"
                            :object="true"
                            noOptionsText="Aucune catégorie"
                            noResultsText="Aucune catégorie"
                            @close="check"
                        />

                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />

                        <div class="text-danger mt-1" v-if="hasError">
                            {{ errors.categories[0] }}
                        </div>
                    </div>

                    <div class="col-xl-3 mb-3">
                        <Input v-if="!loading" type="text" v-model="fournisseur.nif" :error="errors.nif">NIF</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-3 mb-3">
                        <Input v-if="!loading" type="text" v-model="fournisseur.cif" :error="errors.cif">CIF</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>
                    <div class="col-xl-6 mb-3">
                        <Input v-if="!loading" type="text" v-model="fournisseur.stat" :error="errors.stat">STAT</Input>
                        <Skeletor v-else height="40" width="100%" style="border-radius: 3px" />
                    </div>

                    <div class="d-flex justify-content-end">
                        <SaveBtn v-if="!loading" @click.prevent="save(fournisseur.id)" :loading="updating">Enregistrer</SaveBtn>
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
import useFournisseur from '../../services/fournisseur/FournisseurServices';
import { Skeletor } from 'vue-skeletor';
import MultiSelect from '@vueform/multiselect';
import useCategories from '../../services/categorie/CategorieServices';

const { updating, loading, fournisseur, errors, success, getFournisseur, updateFournisseur } = useFournisseur();
const { categories, getCategories } = useCategories();

export default {
    setup() {
        return {
            loading, updating, errors, success, fournisseur, getFournisseur, updateFournisseur,
            categories, getCategories,
        }
    },

    components: {
        Input, SaveBtn, Skeletor, MultiSelect,
    },

    methods: {
        async save(id) {
            await updateFournisseur(id, fournisseur.value);
            window.scrollTo({ top: 0, behavior: "smooth" });
            success.value = null
        },
    },

    mounted() {
        const id = parseInt(this.$route.params.id);
        getFournisseur(id)
        getCategories(2)
    },

}
</script>
