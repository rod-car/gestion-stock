import { ref } from 'vue';
import axiosClient from '../axios';
import Router from '../components/router/router';

export default function useDepot () {

    /**
     * Contient tous les depots
     *
     * @return  {[]}
     */
    const depots = ref([])


    /**
     * Un dépot en particulier
     *
     * @type {Object}
     */
    const depot = ref({})


    /**
     * Contient tous les erreurs de soumission de formulaire
     *
     * @return  {[]}
     */
    const errors = ref([])


    /**
     * Contient le message de success
     *
     * @return  {[]}
     */
    const success = ref(null)


    /**
     * Permet d'indiquer que les donees sont en cours de chargement
     *
     * @type {Boolean}
     */
    let loading = ref(false)


    /**
     * Créer un nouveau point de vente
     *
     * @param   {Object}  data  Contient tous les champs du formulaire
     *
     * @return  {Object} Retourne le depot
     */
    const createDepot = async (data) => {
        loading = true
        await axiosClient.post(`/depot`, data).then((response) => {
            depot.value = response.data
            success.value = "Enregistré avec success"
        }).catch(error => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else if (error.response.status === 403) {
                Router.push('/403')
            }
        })
        loading = false
    }


    /**
     * Recuperer tous les dépots (Point de vente ou entrepot)
     *
     * @param   {Boolean}  type  Permet de determiner si c'est un point de vente ou un entrepot
     * 1: Point de vente
     * 0: Entrepot
     *
     * @return  {Array}
     */
    const getDepots = async (type = 1) => {

        try {
            let response = await axiosClient.get(`/depot?type=${type}`)
            depots.value = response.data

        } catch (error) {
            console.log(error)
        }

    }

    return {
        depot, depots, errors, success,
        createDepot, getDepots,
    }

}
