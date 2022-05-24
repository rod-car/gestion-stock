import axios from "axios";
import { ref } from "vue";

export default function usePersonnelles () {

    /**
     * Tableau contenant tous la listes des personnelles
     *
     * @return  {array}      Tableau contenant tous les personnelles
     */
    const personnelles = ref([]);

    /**
     * Contient un personnel en particulier
     *
     * @return  {Object}      Personnel
     */
    const personnel = ref({});


    /**
     * Erreurs lors de l'ajout, de mise a jour ou de suppression d'un personnel
     *
     * @return  {array}      Contenant toutes les erreurs
     */
    const errors = ref([]);


    /**
     * Message de success lors de l'ajout, de mise a jour ou de suppression d'un personnel
     *
     * @return  {string}      Contenant le message de success
     */
    const success = ref(null);

    /**
     * Message d'erreur s'il y en a
     *
     * @return  {string}      Contenant le message de success
     */
    const error = ref(null);

    /**
     * Fonction permet de recuperer toutes les personnelles
     *
     * @param  {integer} page Numéro de page
     * @return  {JSON}  Tableau contenant tous les personnels paginé
     */
    const getPersonnelles = async (page = 1) => {
        let response = await axios.get(`/api/user?page=${page}`);
        personnelles.value = response.data;
    }


    /**
     * Fonction permet de recuperer un personnel
     *
     * @param  {integer} id Id du personnel
     * @return  {JSON}  Le personnel sous forme de JSON
     */
    const getPersonnel = async (id) => {
        try
        {
            let response = await axios.get(`/api/user/${id}`);
            personnel.value = response.data;
        }
        catch (err)
        {
            if (err.response.status === 404)
            {
                errors.value = {
                    message: "Impossible de trouver le personnel",
                    status: 404,
                };
            }
        }
    }


    /**
     * Reinitialise les messages d'erreurs et de success
     *
     * @return  {void}
     */
    const resetFlashMessages = () => {
        errors.value = [];
        success.value = null;
    }

    /**
     * Fonction permettant de créer un nouveau personnel
     *
     * @param   {Object}  personnel  Données du personnel a créer
     *
     * @return  {Object}  Le personnel
     */
    const createPersonnel = async (data) => {
        await axios.post('/api/user', data).then(response => {
            success.value = "Personnel crée avec succès";
            personnel.value = response.data;
        }).catch((err) => {
            errors.value = err.response.data.errors;
        });
    }

    const updatePersonnel = async (data) => {
        await axios.put('/api/user/' + personnel.value.id, data).then(response => {
            success.value = "Modifié avec succes";
            personnel.value = response.data;
        }).catch((err) => {
            errors.value = err.response.data.errors;
        });
    }

    return {
        errors,
        success,
        personnel,
        personnelles,
        getPersonnel,
        getPersonnelles,
        updatePersonnel,
        createPersonnel,
        resetFlashMessages,
    };

}
