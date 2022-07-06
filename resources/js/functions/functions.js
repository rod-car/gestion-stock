/**
 * Recuperer le dernier element d'un tableau
 *
 * @param   {array}  array  Tableau contenant l'element
 *
 * @return  {any}         Dernier element du tableau
 */
const last = (array) => {

    if (array.length === 0) return null

    return array[array.length - 1];

}


/**
 * [formatDate description]
 *
 * @param   {String|Date}  date  Date a formatter
 *
 * @return  {String}        Date formatté
 */
const formatDate = (date) => {
    if (date === undefined) throw new Error("La dae a formatter n'est pas définie")

    const config = { weekday: "long", year: "numeric", month: "long", day: "numeric" };
    const locale = 'fr-MG'

    if (date instanceof Date) {
        return date.toLocaleDateString(locale, config)
    }
    return new Date(date).toLocaleDateString(locale, config)
}


/**
 * Permet de calculer la date d'expiration d'un dévis en fonction de la date de début et la validité
 *
 * @param   {String|Date}  dateDebut    La date du dévis
 * @param   {Number}  delais     Nombre de jours de validité
 *
 * @return  {Date}             La date d'expiration
 */
const expiration = (dateDebut, delais) => {
    if (dateDebut === undefined || delais === undefined) throw new Error("La date ou le delais n'est pas définie")

    if (dateDebut instanceof Date) {
        return dateDebut.addDays(delais)
    }
    return new Date(dateDebut).addDays(delais)
}

export {
    last,
    expiration,
    formatDate,
};
