import { ref } from 'vue';
import axiosClient from '../axios';
import Router from '../components/router/router';
import Flash from '../functions/Flash';

export default function useDepot() {

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
     * Permet d'indiquer q'un point de vente est en cours de suppréssion
     *
     * @type {Boolean}
     */
    let deleting = ref(false)


    /**
     * Créer un nouveau point de vente
     *
     * @param   {Object}  data  Contient tous les champs du formulaire
     *
     * @return  {Object} Retourne le depot
     */
    const createDepot = async (data) => {
        loading.value = true
        await axiosClient.post(`/depot`, data).then((response) => {
            depot.value = response.data
            success.value = "Point de vente enregistré avec succes"
            Flash('success', "Message de succès", success.value)
        }).catch(error => {
            Flash('error', "Message d'erreur", "Erreur de soumission du formulaire")

            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else if (error.response.status === 403) {
                Router.push('/403')
            }
        })
        loading.value = false
    }


    /**
     * Recuperer un depot en particulier
     *
     * @param   {Number}  id  Identifiant du dépot (Point de vente ou entrepot)
     *
     * @return  {Object}
     */
    const getDepot = async (id) => {

        loading.value = true

        try {
            let response = await axiosClient.get(`/depot/${id}`)
            depot.value = response.data
        } catch (error) {
            console.error(error)
        }

        loading.value = false
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
        loading.value = true
        try {
            let response = await axiosClient.get(`/depot?type=${type}`)
            depots.value = response.data

        } catch (error) {
            console.log(error)
        }
        loading.value = false
    }


    /**
     * Permet de supprimer un depot en fonciton de lID
     *
     * @param   {Numner}  id  Identifiant du dépot a supprimer
     * @param   {Number|null} index Index de l'eleement dans le tableau de dépots
     *
     * @return  {void}
     */
    const deleteDepot = async (id, index = null) => {
        deleting.value = true
        try {
            let response = await axiosClient.delete(`/depot/${id}`)
            if (response.data.errors) {
                errors.value = response.data.errors
            } else {
                success.value = "Personnel supprimé avec succes";
                depots.value.splice(index)
                Flash('success', "Message de succès", success.value)
            }
        } catch (error) {
            errors.value = err.response.data.errors;
        }
        deleting.value = false
    }


    const updateDepot = async (id, data) => {

        loading.value = true
        try {
            await axiosClient.patch(`/depot/${id}`, data)
            success.value = "Modifié avec success"
            Flash('success', 'Message de succès', success.value)
        } catch (error) {
            Flash('error', "Message d'erreur", "Erreur de soumission du formulaire")
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else if (error.response.status === 403) {
                Router.push('/403')
            }
        }
        loading.value = false

    }

    return {
        depot, depots, errors, success, loading,
        createDepot, getDepot, getDepots, deleteDepot, updateDepot,
    }

}
