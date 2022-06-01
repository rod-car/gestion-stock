import { ref } from "vue";
import axiosClient from '../axios/index';

export default function useRoles () {

    /**
     * Tableau contenant tous la listes des personnelles
     *
     * @return  {array}      Tableau contenant tous les personnelles
     */
    const roles = ref([]);

    /**
     * Contient un personnel en particulier
     *
     * @return  {Object}      Personnel
     */
    const role = ref({});


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
    const getRoles = async (page = 1, perPage = 5) => {
        let response = await axiosClient.get(`/roles?page=${page}&perPage=${perPage}`);
        roles.value = response.data;
    }


    /**
     * Fonction permet de recuperer toutes les personnelles
     *
     * @param  {integer} page Numéro de page
     * @return  {JSON}  Tableau contenant tous les personnels paginé
     */
    const findRoles = async (query, perPage = 5) => {
        let page = 1;
        let response = await axiosClient.get(`/roles/search?page=${page}&perPage=${perPage}&q=${query}`);
        roles.value = response.data;
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
            let response = await axiosClient.get(`/user/${id}`);
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
        await axiosClient.post('/user', data).then(response => {
            success.value = "Personnel crée avec succès";
            personnel.value = response.data;
        }).catch((err) => {
            errors.value = err.response.data.errors;
        });
    }

    const updatePersonnel = async (data) => {
        await axiosClient.put('/user/' + personnel.value.id, data).then(response => {
            success.value = "Modifié avec succes";
            personnel.value = response.data;
        }).catch((err) => {
            errors.value = err.response.data.errors;
        });
    }

    return {
        errors,
        success,
        roles,
        getRoles,
        findRoles,
    };

}
