import { ref } from "vue";
import axiosClient from "../axios";
import Router from '../components/router/router';

export default function useFonctions () {

    /**
     * Tableau contenant tous la listes des fonctions
     *
     * @return  {array}      Tableau contenant tous les fonctions
     */
    const fonctions = ref([]);

    /**
     * Contient une fonction en particulier
     *
     * @return  {Object}      Fonction
     */
    const fonction = ref({});


    /**
     * Erreurs lors de l'ajout, de mise a jour ou de suppression d'une fonction
     *
     * @return  {array}      Contenant toutes les erreurs
     */
    const errors = ref([]);


    /**
     * Message de success lors de l'ajout, de mise a jour ou de suppression d'une fonction
     *
     * @return  {string}      Contenant le message de success
     */
    const success = ref(null);


    /**
     * Fonction permet de recuperer toutes les fonctions
     *
     * @param  {integer} page Numéro de page
     * @return  {JSON}  Tableau contenant tous les fonctions paginé
     */
    const getFonctions = async (page = 1) => {
        let response = await axiosClient.get(`/fonctions?page=${page}`);
        fonctions.value = response.data;
    }


    /**
     * Fonction permet de recuperer une fonction
     *
     * @param  {integer} id Id de la fonction
     * @return  {JSON}  La fonction sous forme de JSON
     */
    const getFonction = async (id) => {
        try
        {
            let response = await axiosClient.get(`/fonctions/${id}`);
            fonction.value = response.data;
        }
        catch (err)
        {
            if (err.response.status === 404)
            {
                errors.value = {
                    message: "Impossible de trouver la fonction",
                    status: 404,
                };
            }
        }
    }


    /**
     * Fonction permettant de créer une nouvelle fonction
     *
     * @param   {Object}  fonction  Données du fonction a créer
     *
     * @return  {Object}  Le fonction
     */
    const createFonction = async (data) => {
        await axiosClient.post('/fonctions', data).then(response => {
            success.value = "La fonction est crée avec succès";
            fonction.value = response.data;
        }).catch((err) => {
            if (err.response.status === 422) {
                errors.value = err.response.data.errors;
            } else if (err.response.status === 403) {
                Router.push('/403')
            }
        });
    }


    /**
     * Permet de mettre a jour une fonction
     *
     * @param   {array}  data  Nouvelle donées
     *
     * @return  {void}
     */
    const updateFonction = async (data) => {
        await axiosClient.put('/fonctions/' + fonction.value.id, data).then(response => {
            success.value = "Modifié avec succes";
            fonction.value = response.data;
        }).catch((err) => {
            errors.value = err.fonction.data.errors;
        });
    }


    /**
     * Permet de supprimer une fonction
     *
     * @param   {integer}  id  Identifiant de la fonction
     *
     * @return  {void}
     */
    const deleteFonction = async (id) => {
        await axiosClient.delete(`/fonctions/${id}`).then(response => {
            if (response.data.errors) {
                errors.value = response.data.errors
                getFonctions()
            } else {
                success.value = "Fonction supprimé avec succes";
            }
        }).catch(err => {
            errors.value = err.response.data.errors;
        });
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

    return {
        errors,
        success,
        fonction,
        fonctions,
        getFonction,
        getFonctions,
        updateFonction,
        deleteFonction,
        createFonction,
        resetFlashMessages,
    };

}
