import axiosClient from "../axios"
import { ref } from 'vue';

export default function useAbility () {

    const permissions = ref([])

    /**
     * Recuperer tous les permissions de l'utilsateur connecté
     *
     * @return  {Array}
     */
    const getPermissions = async () => {

        let response = await axiosClient.get('abilities')
        permissions.value = response.data

    }

    return {
        permissions,
        getPermissions,
    };

}
