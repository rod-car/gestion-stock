import { ref } from 'vue';
import axiosClient from '../axios';
import Router from '../router/router';
import Flash from '../functions/Flash';

/**
 * Permet de fournir un service de CRUD
 *
 * @param   {String}  url  URL de l'api ressource
 *
 * @return  {Object}
 */
export default function useCRUD(url) {

    /**
     * Contient tous les donnees
     *
     * @return  {[]}
     */
    const entities = ref([])


    /**
     * Un dépot en particulier
     *
     * @type {Object}
     */
    const entity = ref({})


    const key = ref(null)


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
     * Permet d'indiquer que les donees sont en cours de création
     *
     * @type {Boolean}
     */
    let creating = ref(false)


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
     * Permet d'indiquer q'un point de vente est en cours de mise a jour
     *
     * @type {Boolean}
     */
    let updating = ref(false)


    /**
     * Créer un nouveau point de vente
     *
     * @param   {Object}  data  Contient tous les champs du formulaire
     *
     * @return  {Object} Retourne le entity
     */
    const createEntity = async (data) => {
        creating.value = true

        try {
            let response = await axiosClient.post(`${url}`, data)
            entity.value = response.data
            success.value = "Enregistré avec succes"
            Flash('success', "Message de succès", success.value)
        } catch (error) {
            Flash('error', "Message d'erreur", "Erreur de soumission du formulaire")

            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else if (error.response.status === 403) {
                Router.push('/403')
            }
        }

        creating.value = false
    }


    /**
     * Recuperer un entity en particulier
     *
     * @param   {Number}  id  Identifiant du dépot (Point de vente ou entrepot)
     *
     * @return  {Object}
     */
    const getEntity = async (id) => {

        loading.value = true

        try {
            let response = await axiosClient.get(`${url}/${id}`)
            entity.value = response.data
        } catch (error) {
            if (error.response.status === 404) return Router.push("/404");
            if (error.response.status === 500) return Router.push("/500");
            Router.push("/500");
        }

        loading.value = false
    }

    /**
     * Recuperer tous les dépots (Point de vente ou entrepot)
     *
     * @param   {Boolean}  type  Permet de determiner si c'est un point de vente ou un entrepot, 1: Point de vente, 0: Entrepot
     *
     * @return  {Array}
     */
    const getEntities = async ({ type, except, appro } = {}) => {
        loading.value = true

        try {
            let response = await axiosClient.get(`${url}?type=${type}&except=${except}&appro=${appro}`)
            entities.value = response.data

        } catch (error) {
            if (error.response.status === 404) return Router.push("/404");
            if (error.response.status === 500) return Router.push("/500");
            Router.push("/500");
        }

        loading.value = false
    }


    /**
     * Permet de supprimer un entity en fonciton de lID
     *
     * @param   {Numner}  id  Identifiant du dépot a supprimer
     * @param   {Number|null} index Index de l'eleement dans le tableau de dépots
     *
     * @return  {void}
     */
    const deleteEntity = async (id, index = null) => {
        deleting.value = true
        try {
            let response = await axiosClient.delete(`${url}/${id}`)
            if (response.data.errors) {
                errors.value = response.data.errors
            } else {
                success.value = "Personnel supprimé avec succes";
                entities.value.splice(index)
                Flash('success', "Message de succès", success.value)
            }
        } catch (error) {
            errors.value = error.response.data.errors;
            Flash('error', "Message d'erreur", `Impossible de supprimer: ${error.message}`)
        }
        deleting.value = false
    }


    /**
     * Fonction permet de mettre a jour un point de vente
     *n
     * @param   {Number}  id          Identifiant du point de vente
     * @param   {Object}  data        Nouvelle données
     * @param   {Number}  updateType  Type de mise a jour (1: Responsable uniquement, 2: Travailleurs uniquement, 3: Tous)
     *
     * @return  {Object}
     */
    const updateEntity = async (id, data, { updateType } = {}) => {

        updating.value = true

        if (data["type"] === undefined) data["type"] = updateType // Integrer dans le données le type de mise a jour a faire (Type existe deja pour les devis et les commandes)

        try {
            await axiosClient.patch(`${url}/${id}`, data)
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


    const getKey = async ({ type, appro } = {}) => {
        loading.value = true
        try {
            let response = await axiosClient.get(`${url}/get-key/?type=${type}&appro=${appro}`)
            key.value = response.data.key
        } catch (error) {
            if (error.response.status === 404) return Router.push("/404");
            if (error.response.status === 500) return Router.push("/500");
            Router.push("/500");
        }
        loading.value = false
    }

    return {
        entity, entities, errors, success, loading, creating, updating, deleting,
        key, getKey,
        createEntity, getEntity, getEntities, deleteEntity, updateEntity,
    }

}
