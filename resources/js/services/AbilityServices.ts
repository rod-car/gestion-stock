import axiosClient from "../axios"
import { Ref, ref } from 'vue';

export default function useAbility () {

    const permissions: Ref<Array<any>> = ref([])

    /**
     * Recuperer tous les permissions de l'utilsateur connecté
     *
     * @return  {Promise}
     */
    const getPermissions = async (): Promise<any> => {

        let response = await axiosClient.get('abilities')
        permissions.value = response.data

    }

    return {
        permissions,
        getPermissions,
    };

}
