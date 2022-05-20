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

    return {
        errors,
        success,
        personnel,
        personnelles,
        getPersonnelles,
        createPersonnel,
    };

}
