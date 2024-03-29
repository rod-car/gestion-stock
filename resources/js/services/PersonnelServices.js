import axios from "axios";
import { ref } from "vue";
import Router from '../router/router';
import axiosClient from '../axios/index';

export default function usePersonnelles() {

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
     * @type  {array}      Contenant toutes les erreurs
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
     * Permet de detecter si les données sont en cours de chargement
     *
     * @type {Boolean}
     */
    const loading = ref(false)

    /**
     * Fonction permet de recuperer toutes les personnelles
     *
     * @param  {integer} page Numéro de page
     * @return  {JSON}  Tableau contenant tous les personnels paginé
     */
    const getPersonnelles = async (page = 1) => {
        loading.value = true
        let response = await axiosClient.get(`/user?page=${page}`);
        personnelles.value = response.data;
        loading.value = false
    }


    /**
     * Fonction permet de recuperer un personnel
     *
     * @param  {integer} id Id du personnel
     * @return  {JSON}  Le personnel sous forme de JSON
     */
    const getPersonnel = async (id) => {
        try {
            let response = await axiosClient.get(`/user/${id}`);
            personnel.value = response.data;
        }
        catch (err) {
            if (err.response.status === 404) {
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
            if (err.response.status === 422) {
                errors.value = err.response.data.errors;
            } else if (err.response.status === 403) {
                Router.push('/403')
            }
        });
    }


    /**
     * Permet de mettre a jour un personnel
     *
     * @param   {array}  data  Nouvelle donées
     *
     * @return  {void}
     */
    const updatePersonnel = async (data) => {
        await axiosClient.put('/user/' + personnel.value.id, data).then(response => {
            success.value = "Modifié avec succes";
            personnel.value = response.data;
        }).catch((err) => {
            errors.value = err.response.data.errors;
        });
    }


    /**
     * Permet de supprimer un personnel
     *
     * @param   {integer}  id  Identifiant du personnel
     *
     * @return  {void}
     */
    const deletePersonnel = async (id) => {
        await axiosClient.delete(`/user/${id}`).then(response => {
            if (response.data.errors) {
                errors.value = response.data.errors
            } else {
                success.value = "Personnel supprimé avec succes";
            }
        }).catch(err => {
            errors.value = err.response.data.errors;
        });
    }

    return {
        errors, success, personnel, personnelles, loading,
        getPersonnel, getPersonnelles, updatePersonnel, deletePersonnel, createPersonnel, resetFlashMessages,
    };

}
