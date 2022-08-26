import { Ref, ref } from 'vue';
import axiosClient from '../axios';
import Router from '../router/router';
import Flash from '../functions/Flash';
import { AxiosResponse } from 'axios';

interface CRUD {
    create(data: Object, headers?: Object): Promise<any>,
    find(id: number): Promise<any>,
    findBy(field: string, value: string|number): Promise<any>
    update(id: number, data: object, updateType?: number | null): Promise<any>,
    all(type?: number | null, except?: string | null, appro?: boolean | null): Promise<any>,
    destroy(id: number, data: Array<any>|null, index: number): Promise<any>,
    creating: Ref<boolean>,
    loading: Ref<boolean>,
    updating: Ref<boolean>,
    deleting: Ref<boolean>,
    errors: Ref<any>,
    success: Ref<string | null>,
    entity: Ref<any>,
    entities: Ref<Array<any>>,
    key: Ref<string | null>,
    getKey(type: number, appro?: boolean): Promise<any>,
}

/**
 * Permet de fournir un service de CRUD
 *
 * @param   {String}  url  URL de l'api ressource
 *
 * @return  {CRUD}
 */
export default function useCRUD(url: string): CRUD {

    /**
     * Contient tous les donnees
     *
     * @return  {[]}
     */
    const entities: Ref<Array<any>> = ref([])


    /**
     * Un dépot en particulier
     *
     * @type {Object}
     */
    const entity : Ref<object> = ref({})


    const key: Ref<string | null> = ref(null)


    /**
     * Contient tous les erreurs de soumission de formulaire
     *
     * @return  {[]}
     */
    const errors: Ref<object> = ref([])


    /**
     * Contient le message de success
     *
     * @return  {[]}
     */
    const success: Ref<string | null> = ref(null)


    /**
     * Permet d'indiquer que les donees sont en cours de création
     *
     * @type {Boolean}
     */
    const creating: Ref<boolean> = ref(false)


    /**
     * Permet d'indiquer que les donees sont en cours de chargement
     *
     * @type {Boolean}
     */
    const loading: Ref<boolean> = ref(false)


    /**
     * Permet d'indiquer q'un point de vente est en cours de suppréssion
     *
     * @type {Boolean}
     */
    const deleting: Ref<boolean> = ref(false)


    /**
     * Permet d'indiquer q'un point de vente est en cours de mise a jour
     *
     * @type {Boolean}
     */
    const updating: Ref<boolean> = ref(false)


    /**
     * Créer un nouveau point de vente
     *
     * @param   {Object}  data  Contient tous les champs du formulaire
     * @return  {Promise}
     */
    const create = async (data: object, headers?: Object): Promise<any> => {
        creating.value = true

        try {
            let response = await axiosClient.post(`${url}`, data, {
                headers: headers
            })

            entity.value = response.data
            success.value = "Enregistré avec succes"
            Flash('success', "Message de succès", success.value)
        } catch (error: any) {
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
     * @return  {Promise}
     */
    const find = async (id: number | null): Promise<any> => {

        loading.value = true
        let response: AxiosResponse | null = null;

        try {
            if (id === null) response = await axiosClient.get(`${url}`)
            else response = await axiosClient.get(`${url}/${id}`)

            if (response !== null) entity.value = response.data
        } catch (error: any) {
            if (error.response.status === 404) return Router.push("/404");
            if (error.response.status === 500) return Router.push("/500");
            Router.push("/500");
        }

        loading.value = false
    }


    /**
     * Recupere tous les entités
     *
     * @param   {String | null}          type    [type description]
     * @param   {Number | null}          except  [except description]
     * @param   {Boolean |  null}        appro   [appro description]
     *
     * @return  {Promise}            [return description]
     */
    const all = async (type?: number | null, except?: string | null, appro?: boolean | null): Promise<any> => {
        loading.value = true

        let query: string = '';

        if (type !== null && type !== undefined) query += `?type=${type}`
        if (except !== null && except !== undefined) {
            let operator = '?';
            if (query !== '') operator = '&'
            query += `${operator}except=${except}`
        }
        if (appro !== null && appro !== undefined) {
            let operator = '?';
            if (query !== '') operator = '&'
            query += `${operator}appro=${appro}`
        }

        try {
            let response = await axiosClient.get(`${url}${query}`)
            entities.value = response.data

        } catch (error: any) {
            if (error.response.status === 404) return Router.push("/404");
            if (error.response.status === 500) return Router.push("/500");
            Router.push("/500");
        }

        loading.value = false
    }


    /**
     * Permet de supprimer un entity en fonciton de lID
     *
     * @param   {Number}  id  Identifiant du dépot a supprimer
     * @param   {Number} index Index de l'eleement dans le tableau de dépots
     *
     * @return  {Promise}
     */
    const destroy = async (id: number, data: Array<any>|null = null, index: number = 0): Promise<any> => {
        deleting.value = true
        try {
            let response = await axiosClient.delete(`${url}/${id}`)
            if (response.data.errors) {
                errors.value = response.data.errors
            } else {
                if (data === null) entities.value.splice(index, 1)
                else data.splice(index, 1)

                success.value = "Supprimé avec succes";
                Flash('success', "Message de succès", success.value)
            }
        } catch (error: any) {
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
     * @param   {Number | null}  updateType  Type de mise a jour (1: Responsable uniquement, 2: Travailleurs uniquement, 3: Tous)
     *
     * @return  {Promise}
     */
    const update = async (id: number, data: object, updateType?: number | null): Promise<any> => {

        updating.value = true

        // Integrer dans le données le type de mise a jour a faire (Type existe deja pour les devis et les commandes)
        if (data instanceof FormData) {
            data.append("_method", 'PATCH');
            if (!data.has('type') && updateType !== undefined && updateType !== null) data.append('type', updateType.toString())
        } else if (updateType !== null && updateType !== undefined && data["type"] === undefined) {
            data["type"] = updateType
        }

        try {
            if (data instanceof FormData) await axiosClient.post(`${url}/${id}`, data)
            else await axiosClient.patch(`${url}/${id}`, data)

            success.value = "Modifié avec success"
            Flash('success', 'Message de succès', success.value)
        } catch (error: any) {
            Flash('error', "Message d'erreur", "Erreur de soumission du formulaire")
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else if (error.response.status === 403) {
                Router.push('/403')
            }
        }
        updating.value = false

    }


    /**
     * Recuperer un clé de commande ou devis
     *
     * @param   {Number}  type   1: Devis, 2: Commande
     * @param   {Boolean}  appro  True: Fournisseur, False: Client
     *
     * @return  {Promise}
     */
    const getKey = async (type: number, appro: boolean): Promise<any> => {
        loading.value = true
        try {
            let response = await axiosClient.get(`${url}/get-key/?type=${type}&appro=${appro}`)
            key.value = response.data.key
        } catch (error: any) {
            if (error.response.status === 404) return Router.push("/404");
            if (error.response.status === 500) return Router.push("/500");
            Router.push("/500");
        }
        loading.value = false
    }

    const findBy = async (field: string, value: string|number): Promise<any> => {
        try {
            let response = await axiosClient.get(`${url}?${field}=${value}`)
            return response.data
        } catch (error: any) {
            if (error.response.status === 404) return Router.push("/404");
            if (error.response.status === 500) return Router.push("/500");
            Router.push("/500");
        }
    }

    return {
        entity, entities, errors, success, loading, creating, updating, deleting, key,
        getKey, create, find, all, destroy, update, findBy,
    }

}
