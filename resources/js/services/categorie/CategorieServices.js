import { ref } from 'vue';
import axiosClient from '../../axios/index';
import Flash from '../../functions/Flash';

export default function useCategories() {

    const categories = ref([])

    const errors = ref([])

    const success = ref(null)

    const categorie = ref({})

    /**
     * Permet de determiner si un noveau categorie est en couts
     *
     * @return  {Boolean}
     */
    const creating = ref(false)

    const loading = ref(false)

    const updating = ref(false)

    const deleting = ref(false)

    const nouveauCategorie = async (data) => {

        creating.value = true

        try {
            let response = await axiosClient.post('/categorie', data)
            categorie.value = response.data
            success.value = "Point de vente enregistré avec succes"
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
     * Recuperer un categorie en particulier
     *
     * @param   {Number}  id  Identifiant du dépot (Point de vente ou entrepot)
     *
     * @return  {Object}
     */
    const getCategorie = async (id) => {

        loading.value = true

        try {
            let response = await axiosClient.get(`/categorie/${id}`)
            categorie.value = response.data
        } catch (error) {
            console.error(error)
        }

        loading.value = false
    }

    /**
     * Recuperer tous les dépots (Point de vente ou entrepot)
     *
     * @param   {Number}  type  Permet de determiner quelle type de catégorie on veut recuperer
     * 1: Categorie de client
     * 2: Categorie des fournisseurs
     * 3: Catégorie d'article
     * @param   {Number} except  Id a exclure pendant la réquête
     * @return  {Array}
     */
    const getCategories = async (type = 1, except = 0) => {
        loading.value = true
        try {
            const queryParams = `type=${type}&except=${except}`

            let response = await axiosClient.get(`/categorie?${queryParams}`)
            categories.value = response.data

        } catch (error) {
            console.log(error)
        }
        loading.value = false
    }


    /**
     * Permet de supprimer un categorie en fonciton de lID
     *
     * @param   {Numner}  id  Identifiant du dépot a supprimer
     * @param   {Number|null} index Index de l'eleement dans le tableau de dépots
     *
     * @return  {void}
     */
    const deleteCategorie = async (id, index = null, type = null) => {
        deleting.value = true
        try {
            let response = await axiosClient.delete(`/categorie/${id}`)
            if (response.data.errors) {
                errors.value = response.data.errors
            } else {
                success.value = "Catégorie supprimé avec succes";
                categories.value.splice(index)
                if (type === 3) getCategories(3)
                Flash('success', "Message de succès", success.value)
            }
        } catch (error) {
            errors.value = error.response.data.errors;
            Flash('error', "Message d'erreur", `Impossible de supprimer la catégorie: ${error.message}`)
        }
        deleting.value = false
    }


    /**
     * Fonction permet de mettre a jour un point de vente
     *
     * @param   {Number}  id          Identifiant du point de vente
     * @param   {Object}  data        Nouvelle données
     * @param   {Number}  updateType  Type de mise a jour (1: Responsable uniquement, 2: Travailleurs uniquement, 3: Tous)
     *
     * @return  {Object}
     */
    const updateCategorie = async (id, data) => {

        updating.value = true

        try {
            await axiosClient.patch(`/categorie/${id}`, data)
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
        categories, categorie, errors, success, creating, updating, deleting, loading,
        nouveauCategorie, getCategorie, getCategories, deleteCategorie, updateCategorie
    }

}
