import { ref } from 'vue';
import axiosClient from '../../axios';
import Router from '../../router/router';
import Flash from '../../functions/Flash';

export default function useFournisseur() {

    /**
     * Contient tous les fournisseurs
     *
     * @return  {[]}
     */
    const fournisseurs = ref([])


    /**
     * Un dépot en particulier
     *
     * @type {Object}
     */
    const fournisseur = ref({})


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
     * Permet d'indiquer q'un Fournisseur est en cours de suppréssion
     *
     * @type {Boolean}
     */
    let deleting = ref(false)


    /**
     * Permet d'indiquer q'un Fournisseur est en cours de mise a jour
     *
     * @type {Boolean}
     */
    let updating = ref(false)


    /**
     * Permet d'indiquer q'un Fournisseur est en cours de création
     *
     * @type {Boolean}
     */
    let creating = ref(false)


    /**
     * Créer un nouveau Fournisseur
     *
     * @param   {Object}  data  Contient tous les champs du formulaire
     *
     * @return  {Object} Retourne le fournisseur
     */
    const createFournisseur = async (data) => {
        creating.value = true
        await axiosClient.post(`/fournisseur`, data).then((response) => {
            fournisseur.value = response.data
            success.value = "Fournisseur enregistré avec succes"
            Flash('success', "Message de succès", success.value)
        }).catch(error => {
            Flash('error', "Message d'erreur", "Erreur de soumission du formulaire")

            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else if (error.response.status === 403) {
                Router.push('/403')
            }
        })
        creating.value = false
    }


    /**
     * Recuperer un fournisseur en particulier
     *
     * @param   {Number}  id  Identifiant du dépot (Fournisseur ou entrepot)
     *
     * @return  {Object}
     */
    const getFournisseur = async (id) => {

        loading.value = true

        try {
            let response = await axiosClient.get(`/fournisseur/${id}`)
            fournisseur.value = response.data
        } catch (error) {
            console.error(error)
        }

        loading.value = false
    }

    /**
     * Recuperer tous les dépots (Fournisseur ou entrepot)
     *
     * @param   {Boolean}  type  Permet de determiner si c'est un Fournisseur ou un entrepot
     * 1: Fournisseur
     * 0: Entrepot
     *
     * @return  {Array}
     */
    const getFournisseurs = async () => {
        loading.value = true
        try {
            let response = await axiosClient.get(`/fournisseur`)
            fournisseurs.value = response.data

        } catch (error) {
            console.log(error)
        }
        loading.value = false
    }


    /**
     * Permet de supprimer un fournisseur en fonciton de lID
     *
     * @param   {Numner}  id  Identifiant du dépot a supprimer
     * @param   {Number|null} index Index de l'eleement dans le tableau de dépots
     *
     * @return  {void}
     */
    const deleteFournisseur = async (id, index = null) => {
        deleting.value = true
        try {
            let response = await axiosClient.delete(`/fournisseur/${id}`)
            if (response.data.errors) {
                errors.value = response.data.errors
            } else {
                success.value = "Personnel supprimé avec succes";
                fournisseurs.value.splice(index)
                Flash('success', "Message de succès", success.value)
            }
        } catch (error) {
            errors.value = error.response.data.errors;
            Flash('error', "Message d'erreur", `Impossible de supprimer: ${error.message}`)
        }
        deleting.value = false
    }


    /**
     * Fonction permet de mettre a jour un Fournisseur
     *
     * @param   {Number}  id          Identifiant du Fournisseur
     * @param   {Object}  data        Nouvelle données
     * @param   {Number}  updateType  Type de mise a jour (1: Responsable uniquement, 2: Travailleurs uniquement, 3: Tous)
     *
     * @return  {Object}
     */
    const updateFournisseur = async (id, data) => {

        updating.value = true

        try {
            await axiosClient.patch(`/fournisseur/${id}`, data)
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
        updating.value = false

    }

    return {
        fournisseur, fournisseurs, errors, success, loading, updating,
        createFournisseur, getFournisseur, getFournisseurs, deleteFournisseur, updateFournisseur,
    }

}
