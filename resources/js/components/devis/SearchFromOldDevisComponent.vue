<template>
    <div class="row my-2 pb-2" style="border-bottom:solid 1px rgba(128,128,128, 0.3);">
        <div class="col-sm-2">
            <label for="old_devis">Cherche un ancien devis</label>

        </div>
        <div class="col-sm-3">
            <input type="text" placeholder="Numéro" class="form-control" v-model="number" v-on:keyup="searchDevis()">

        </div>
    </div>
    <div class="row mb-4" v-if="articleFound.length > 0">
        <div class="col-sm-6">
            <ul class="list-group">
                <li class="list-group-item" v-for="article in articleFound" :key="article.id"
                    :style="selected == article.id ? 'background-color: rgba(128,128,128,0.2)' : 'background-color: white'">
                    <button v-on:click="selectDevis(article.id)"
                        style="background-color: transparent !important;border: none;width:100% !important;">
                        {{
    article.numero + " ( " + ((article.frs != null && article.frs.nom != undefined) ?
        article.frs.nom : article.cl.nom) + " - " + article.date + " )"
                        }}
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>

import { computed, onMounted, onBeforeMount, ref, defineComponent, Ref } from 'vue';

import axiosClient from '../../axios';

export default {
    props: {
        appro: {
            type: Number,
            default: 1
        },
        type: {
            type: Number,
            default: 1
        }
    },
    setup(props, { emit }) {
        let timer = null

        const number = ref("")
        const selected = ref(0)
        const articleFound = ref([])

        const searchDevis = async () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                let response = axiosClient.get("/commandes/from-old/" + props.type + "/" + props.appro + "/" + number.value).then(({ data }) => {
                    articleFound.value = data
                })
            }, 300);
        }

        const selectDevis = (id) => {
            selected.value = id
            emit('articles', selected.value)
        }
        return { number, searchDevis, articleFound, selected, selectDevis }
    }
}

</script>
