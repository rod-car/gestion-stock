<template>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Nouveau catégorie de client</h5>
            <router-link to="/client/categorie/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des catégories</router-link>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-xl-12 mb-3">
                        <Input v-model="form.libelle" :error="errors.libelle" :required="true">Nom de la catégorie</Input>
                    </div>
                    <div class="col-xl-12 mb-3">
                        <Input type="textarea" v-model="form.description" :error="errors.description">Description de la catégorie</Input>
                    </div>
                    <div class="d-flex justify-content-end">
                        <SaveBtn @click.prevent="save" :loading="creating">Enregistrer</SaveBtn>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

import SaveBtn from '../../../components/html/SaveBtn.vue';
import Input from '../../../components/html/Input.vue';
import useCategorie from '../../../services/categorie/CategorieServices';

const { creating, errors, success, nouveauCategorie } = useCategorie();

export default {
    setup() {
        return {
            creating, errors, success, nouveauCategorie,
        }
    },

    data() {
        return {
            form: {
                libelle: null,
                description: null,
                type: 1, // Catégorie client
            },
        }
    },

    components: {
        Input, SaveBtn,
    },

    methods: {
        async save () {
            await nouveauCategorie(this.form)
            window.scrollTo({ top: 0, behavior: 'smooth' });
            if (success.value !== null) this.resetForm();
            success.value = null
        },

        resetForm () {
            this.form = {
                libelle: null,
                description: null,
                type: 1,
            }
        }
    },

}
</script>
